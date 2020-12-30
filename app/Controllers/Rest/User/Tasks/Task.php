<?php
namespace App\Controllers\Rest\User\Tasks;

use App\Controllers\Rest\PrivateController;
use App\Models\TasksModel;
use App\Models\TaskTypesModel;
use App\Models\ScrapsModel;
use App\Entities\Tasks;
use App\Models\UsersModel;

class Task extends PrivateController
{
    protected $FieldMap = [
        'get_user_model'    =>  [
            'username_followers',
            'username_followings',
            'username_likes',
            'hashtag_likes',
            'location_likes',
            'post_likes'
        ],
        'get_item_model'    =>  [
            'username_posts',
            'hashtag_posts',
            'location_posts'
        ],
        'get_comment_model' =>  [
            'username_comments',
            'hashtag_comments',
            'location_comments',
            'post_comments'
        ]
    ];
    protected $ExtraFields = [
        'Username',
        'FullName'
    ];

    public function get()
    {
        if ($this->request->getMethod() == "get") {
            $TasksModel = new TasksModel();
            $ReturnTasks = [];

            $Type = $this->request->getVar('type');
            $UserId = $this->session->user_id;

            if ($Type == 'parent') {
                $Tasks = $TasksModel->where('task_parent', 0)
                    ->where('task_userid', $UserId)->where('to_delete', 0)
                    ->get()->getResultArray();
                foreach ($Tasks as $TaskData) {
                    if ($TaskData['task_done'] == 1) {
                        $TaskStatus = 4;
                    } elseif ($TaskData['task_stop'] == 1) {
                        $TaskStatus = 3;
                    } elseif ($TaskData['task_failed'] == 1) {
                        $TaskStatus = 2;
                    } else {
                        $TaskStatus = 1;
                    }

                    $ReturnTasks[] = [
                        'RecordID'          =>  $TaskData['id'],
                        'task_name'         =>  $TaskData['task_name'],
                        'created_at'        =>  $TaskData['created_at'],
                        'task_status'       =>  $TaskStatus
                    ];
                }
            } else {
                $ParentTask = $this->request->getVar('parent_id');
                $ScrapsModel = new ScrapsModel();
                if ($ParentTask > 0) {
                    $ChildTasks = $TasksModel->where('task_parent', $ParentTask)->where('task_userid', $UserId)->get()->getResultArray();
                    foreach ($ChildTasks as $ChildTaskData) {
                        if ($ChildTaskData['task_done'] == 1) {
                            $ChildTaskStatus = 4;
                            $ChildTaskProgress = 1;
                        } elseif ($ChildTaskData['task_stop'] == 1) {
                            $ChildTaskStatus = 3;
                        } elseif ($ChildTaskData['task_failed'] == 1) {
                            $ChildTaskStatus = 2;
                        } else {
                            $ChildTaskStatus = 1;
                        }

                        if (!isset($ChildTaskProgress)) {
                            $DoneScraps = $ScrapsModel->where('task_id', $ChildTaskData['id'])->where('object_processed', 1)->countAllResults();
                            $ProgressingScraps = $ScrapsModel->where('task_id', $ChildTaskData['id'])->where('object_processed', 0)->countAllResults();

                            $ChildTaskProgress = (($ProgressingScraps/$ChildTaskData['task_max'])/10) + $DoneScraps/$ChildTaskData['task_max'];
                        }

                        $ReturnTasks[] = [
                        'RecordID'          =>  $ChildTaskData['id'],
                        'task_type'         =>  ucfirst(str_replace('_', ' ', $ChildTaskData['task_type'])),
                        'task_max'          =>  $ChildTaskData['task_max'],
                        'task_status'       =>  $ChildTaskStatus,
                        'task_progress'     =>  number_format($ChildTaskProgress*100, 2)
                    ];

                        unset($ChildTaskProgress);
                    }
                }
            }

            $this->data['data'] = $ReturnTasks;
            return;
        } else {
            $this->data['Status'] = 0;
            $this->data['Message'] = "Bad Request !";
            return;
        }
    }

    public function details()
    {
        if ($this->request->getMethod() == "get") {
            $TaskId = $this->request->getVar('task_id');
            $Type = $this->request->getVar('type');

            helper('accounts');
            $TasksModel = new TasksModel();
            $Task = $TasksModel->where('id', $TaskId)->first();
            $FieldsSchema = '\\' . $this->get_fields_schema($Task->task_action);
            $ScrapedFields = call_user_func_array($FieldsSchema, [true, true]);

            if ($Type == 'data') {
                $ReturnScraps = [];
                if (!empty($TaskId)) {
                    $Start = $this->request->getVar('start');
                    $Length = $this->request->getVar('length');

                    $ScrapsModel = new ScrapsModel();
                    $TaskScraps = $ScrapsModel->where('task_id', $TaskId)->where('object_processed', 1)
                                              ->findAll($Length, $Start);

                    $TotalTaskScraps = $ScrapsModel->where('task_id', $TaskId)->where('object_processed', 1)
                                                    ->countAllResults();

                    foreach ($TaskScraps as $_Scrap) {
                        $ExportRecord = [];
                        $ExportRecord['RecordID'] = $_Scrap->id;
                        $DecodedObject = (object) unserialize($_Scrap->object_extra);
                        foreach ($ScrapedFields as $ScrapName => $ScrapType) {
                            if ($ScrapType == 'string') {
                                $ExportRecord[$ScrapName] = utf8_decode($DecodedObject->{$ScrapName});
                            } elseif ($ScrapType == 'bool') {
                                $ExportRecord[$ScrapName] = $DecodedObject->{$ScrapName} ?
                                    '<span class="kt-badge kt-badge--unified-success kt-badge--lg kt-badge--bold"><i class="fa fa-check-circle"></i></span>' :
                                    '<span class="kt-badge kt-badge--unified-danger kt-badge--lg kt-badge--bold"><i class="fa fa-times-circle"></i></span>';
                            } elseif ($ScrapType == 'User') {
                                foreach ($this->ExtraFields as $ExtraField) {
                                    $ExportRecord[$ExtraField] = utf8_decode($DecodedObject->{$ExtraField});
                                }
                            } else {
                                $ExportRecord[$ScrapName] = $DecodedObject->{$ScrapName};
                            }

                            if ($ScrapName == 'ProfilePicUrl') {
                                $ExportRecord[$ScrapName] = '<img src=" '. $ExportRecord[$ScrapName] . '" width="100px" />';
                            }
                        }

                        $ReturnScraps[] = $ExportRecord;
                    }

                    $this->data = [
                        'iTotalRecords' =>  $TotalTaskScraps,
                        'iTotalDisplayRecords'  =>  $TotalTaskScraps,
                        'sEcho' =>  0,
                        'aaData'    =>  $ReturnScraps
                    ];
                    return;
                }
            } elseif ($Type == 'columns') {
                $ReturnColumns = [];
                if (!empty($Task)) {
                    $ReturnColumns[] = [
                        'data' => 'RecordID',
                    ];

                    foreach ($ScrapedFields as $ScrapName => $ScrapType) {
                        if ($ScrapType == 'User') {
                            foreach ($this->ExtraFields as $ExtraField) {
                                $ReturnColumns[] = [
                                    'data' => $ExtraField,
                                ];
                            }
                        } else {
                            $ReturnColumns[] = [
                                'data' => $ScrapName,
                            ];
                        }
                    }
                }

                $this->data['columns'] = $ReturnColumns;
                return;
            }
        } else {
            $this->data['Status'] = 0;
            $this->data['Message'] = "Bad Request !";
            return;
        }
    }
    
    public function create()
    {
        if ($this->request->getMethod() == "post") {
            $postData = $this->request->getPOST();
            $UserId = $this->session->user_id;

            $UsersModel = new UsersModel();
            $CurrentUser = $UsersModel->where('id', $UserId)->first();
            if (!empty($CurrentUser)) {
                $UserBalance = intval($CurrentUser->user_credits);
                $RequestBalance = intval($postData['task_max']);
                if ($UserBalance < $RequestBalance) {
                    $this->data['Status'] = 0;
                    $this->data['Message'] = 'Insufficient Credits !';
                    exit();
                }

                $UsersModel->update($UserId, [
                    'user_credits' =>  $UserBalance - $RequestBalance,
                    'locked_credits'    =>  $CurrentUser->locked_credits + $RequestBalance
                ]);
            }

            $TasksModel = new TasksModel();

            $TaskTypesModel = new TaskTypesModel();
            $TaskTypes = $TaskTypesModel->findAll();

            $parentTask = new Tasks();
            $parentTask->task_name = $postData['task_name'];
            $parentTask->task_action = $postData['task_type'];
            $parentTask->task_max = $postData['task_max'];
            $parentTask->task_destination = $postData['task_destination'];
            $parentTask->task_userid = $UserId;

            $parentTaskID = $TasksModel->insert($parentTask);

            foreach ($TaskTypes as $scraping_type) {
                if (in_array($scraping_type->task_url, array_keys($postData))) {
                    $selectedTaskType = $TaskTypesModel->where('task_url', $scraping_type->task_url)->first();
                    $insert_data[] = [
                        'task_parent'           =>  $parentTaskID,
                        'task_name'             =>  $postData['task_name'],
                        'task_action'           =>  $selectedTaskType->task_url,
                        'task_userid'           =>  $UserId,
                        'task_typeid'           =>  $selectedTaskType->id,
                        'task_typecat'          =>  $selectedTaskType->task_category,
                        'task_type'             =>  $selectedTaskType->task_name,
                        'task_max'              =>  $postData[$scraping_type->task_url.'_max'],
                        'task_destination'      =>  $postData['task_destination']
                    ];
                }
            }

            if (!$TasksModel->insertBatch($insert_data)) {
                $this->data['Status'] = 0;
                $this->data['Message'] = 'Invalid Data';
                exit();
            }

            $this->data['Status'] = 1;
            $this->data['Message'] = 'Task has been created successfully !';
            exit();
        } else {
            $this->data['Status'] = 0;
            $this->data['Message'] = 'Bad Request !';
            exit();
        }
    }

    public function delete()
    {
        if ($this->request->getMethod() == "post") {
            $postData = $this->request->getPOST();

            $TasksModel = new TasksModel();
            if (isset($postData['task_id'])) {
                $ParentTask = $TasksModel->find($postData['task_id']);
                if (isset($ParentTask->id)) {
                    $ChildTasks = $TasksModel->where('task_parent', $ParentTask->id)->get()->getResultArray();
                    foreach ($ChildTasks as $ChildTask) {
                        $TasksModel->update($ChildTask['id'], [
                            'task_stop' =>  1
                        ]);
                    }
                    $TasksModel->update($ParentTask->id, [
                        'task_stop' =>  1,
                        'to_delete' =>  1
                    ]);

                    $this->data['Status'] = 1;
                    $this->data['Message'] = 'Task deletion has been scheduled !';
                    exit();
                } else {
                    $this->data['Status'] = 0;
                    $this->data['Message'] = 'Bad Request !';
                    exit();
                }
            } else {
                $this->data['Status'] = 0;
                $this->data['Message'] = 'Bad Request !';
                exit();
            }
        } else {
            $this->data['Status'] = 0;
            $this->data['Message'] = 'Bad Request !';
            exit();
        }
    }

    public function stop()
    {
        if ($this->request->getMethod() == "post") {
            $postData = $this->request->getPOST();
            $UserId = $this->session->user_id;

            $UsersModel = new UsersModel();
            $CurrentUser = $UsersModel->where('id', $UserId)->first();

            $ScrapsModel = new ScrapsModel();

            $TasksModel = new TasksModel();
            if (isset($postData['task_id'])) {
                $ParentTask = $TasksModel->find($postData['task_id']);
                if (isset($ParentTask->id)) {
                    $ChildTasks = $TasksModel->where('task_parent', $ParentTask->id)->get()->getResultArray();
                    foreach ($ChildTasks as $ChildTask) {
                        $TasksModel->update($ChildTask['id'], [
                            'task_stop' =>  1
                        ]);
                        $usedCredits = $ScrapsModel->where('task_id', $ChildTask['id'])
                            ->where('object_processed', 1)->countAllResults();
                        $UsersModel->update($ChildTask['task_userid'], [
                            'locked_credits'    =>  $CurrentUser->locked_credits - $ChildTask['task_max'],
                            'user_credits' =>  $CurrentUser->user_credits + ($ChildTask['task_max'] - $usedCredits)
                        ]);
                    }
                    $TasksModel->update($ParentTask->id, [
                        'task_stop' =>  1
                    ]);

                    $this->data['Status'] = 1;
                    $this->data['Message'] = 'Task stop has been scheduled !';
                    exit();
                } else {
                    $this->data['Status'] = 0;
                    $this->data['Message'] = 'Bad Request !';
                    exit();
                }
            } else {
                $this->data['Status'] = 0;
                $this->data['Message'] = 'Bad Request !';
                exit();
            }
        } else {
            $this->data['Status'] = 0;
            $this->data['Message'] = 'Bad Request !';
            exit();
        }
    }

    public function export()
    {
        if ($this->request->getMethod() == "post") {
            $postData = $this->request->getPOST();

            if (isset($postData['task_id'])) {
                $TasksModel = new TasksModel();
                $ScrapsModel = new ScrapsModel();
                $TaskRecord = $TasksModel->find($postData['task_id']);
                $ScrapedRecords = $ScrapsModel->where('task_id', $postData['task_id'])->where('object_processed', 1)
                                              ->findAll();

                if (!empty($ScrapedRecords) && !empty($TaskRecord)) {
                    helper('accounts');
                    $FieldsSchema = '\\' . $this->get_fields_schema($TaskRecord->task_action);
                    $ScrapedFields = call_user_func_array($FieldsSchema, [true, true]);
                    echo 'before';
                    $writer = new \XLSXWriter();
                    echo 'after';
                    $writer->writeSheetHeader('Scraped', $ScrapedFields);

                    try {
                        foreach ($ScrapedRecords as $Record) {
                            $ExportRecord = [];
                            $DataRecord = (object) unserialize($Record->object_extra);
                            foreach ($ScrapedFields as $RecordName => $RecordType) {
                                if (in_array($RecordName, ['RegexEmail', 'RegexPhone']) && !empty($DataRecord->{$RecordName})) {
                                    if (is_array($DataRecord->{$RecordName})) {
                                        $TheRecord = reset($DataRecord->{$RecordName});
                                        $DataRecord->{$RecordName} = $TheRecord;
                                    }
                                }

                                if ($RecordType == 'string') {
                                    $ExportRecord[] = utf8_decode($DataRecord->{$RecordName});
                                } elseif ($RecordType == 'bool') {
                                    $ExportRecord[] = $DataRecord->{$RecordName} ? 'TRUE' : '';
                                } else {
                                    $ExportRecord[] = $DataRecord->{$RecordName};
                                }
                            }
                            $writer->writeSheetRow('Scraped', $ExportRecord);
                        }
                    } catch (\Exception $e) {
                        $x = '';
                    }

                    $ExportFileName = time() . '_scraped_results_' . md5(rand(9999, 9999999));
                    $ExportFile = ROOTPATH . 'public/exports/' . $ExportFileName . '.xlsx';
                    $writer->writeToFile($ExportFile);

                    $this->data['Status'] = 1;
                    $this->data['Message'] = 'Your file is ready, <a href="/exports/' . $ExportFileName . '.xlsx" target="_blank"><b>Download</b></a>';
                    exit();
                /*header("Content-Description: File Transfer");
                header("Content-Type: application/octet-stream");
                header("Content-Disposition: attachment; filename=" . basename($ExportFile));

                readfile ($ExportFile);
                exit();*/
                } else {
                    $this->data['Status'] = 0;
                    $this->data['Message'] = 'No Scraped Records Yet !';
                    exit();
                }
            } else {
                $this->data['Status'] = 0;
                $this->data['Message'] = 'Bad Request !';
                exit();
            }
        } else {
            $this->data['Status'] = 0;
            $this->data['Message'] = 'Bad Request !';
            exit();
        }
    }

    protected function get_fields_schema($TaskType)
    {
        foreach ($this->FieldMap as $ModelType => $InputType) {
            if (in_array($TaskType, $InputType)) {
                return $ModelType;
            }
        }
    }
}
