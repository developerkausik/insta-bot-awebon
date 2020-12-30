<?php

namespace App\Controllers\Rest\Tasks;

use App\Controllers\Rest\RestTaskController;
use App\Models\AccountsModel;
use App\Models\LogsModel;
use App\Models\ScrapsModel;
use App\Models\TasksModel;
use App\Models\UsersModel;

class Profiles extends RestTaskController
{
    public function execute()
    {
        $AccountsModel = new AccountsModel();
        $TasksModel = new TasksModel();
        $ScrapsModel = new ScrapsModel();
        $UsersModel = new UsersModel();

        try {
            $IgInstance = new \InstagramAPI\Instagram();
            if (!empty($this->Account->account_proxy)) {
                $IgInstance->setProxy($this->Account->account_proxy);
            }
            $IgLogin = $IgInstance->login($this->Account->account_username, $this->Account->account_password);

            helper('accounts');
            foreach ($this->ProgressingProfiles as $ProgressingProfile) {
                $FollowerDataResponse = [];
                $CurrentTask = $TasksModel->where('id', $ProgressingProfile['task_id'])->first();
                if ($CurrentTask->task_stop == 1) {
                    break;
                }
                try {
                    $FollowerDataResponse = $IgInstance->people->getInfoByName($ProgressingProfile['object_value']);
                    //$FollowerDataResponse = $IgInstance->people->getInfoById($ProgressingProfile['object_id']);
                } catch (\InstagramAPI\Exception\ThrottledException $e) {
                    $CurrentTime = new \Datetime();
                    $CurrentTime->modify('+24 hours');

                    $AccountsModel->update($this->Account->id, [
                        'username_followers'  => $CurrentTime->format('Y-m-d H:i:s')
                    ]);

                    $ScrapsModel->update($ProgressingProfile['id'], [
                        'object_processing' =>  0
                    ]);

                    break;
                } catch (\Exception $e) {
                    $TasksModel->update($ProgressingProfile['task_id'], [
                        'task_finished' =>  0
                    ]);
                    $ScrapsModel->delete($ProgressingProfile['id']);
                    continue;
                }

                if (!empty($FollowerDataResponse)) {
                    $FollowerScraps = [];
                    $FollowerData = $FollowerDataResponse->getUser();
                    $ScrapedFields = get_user_model(true);
                    foreach ($ScrapedFields as $FieldKey => $FieldType) {
                        if (in_array($FieldKey, ['RegexEmail', 'RegexPhone'])) {
                            continue;
                        }

                        $IsField = 'is'.$FieldKey;
                        $GetField = 'get'.$FieldKey;

                        if (!preg_match('/ImageCandidate/', $FieldType) &&
                            !preg_match('/ChainingSuggestion/', $FieldType) &&
                            !preg_match('/string\[\]/', $FieldType) &&
                            !preg_match('/Link\[\]/', $FieldType)
                        ) {
                            $FollowerScraps[$FieldKey] = false;
                            if ($FollowerData->{$IsField}()) {
                                $FollowerScraps[$FieldKey] = $FieldType == 'string' ? utf8_encode($FollowerData->{$GetField}()) : $FollowerData->{$GetField}();
                            }
                        }
                    }

                    $FollowerBiography = $FollowerScraps['Biography'];

                    preg_match_all(
                        '/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i',
                        $FollowerBiography,
                        $EmailRegex
                    );
                    $FollowerScraps['RegexEmail'] = !empty($EmailRegex[0]) ? $EmailRegex[0] : '';

                    preg_match_all(
                        '/(ph:|ph |phone)([\(\)\d or\-]+?)([^\(\)\d or\-]|$)/is',
                        $FollowerBiography,
                        $PhoneRegex
                    );
                    $FollowerScraps['RegexPhone'] = !empty($PhoneRegex[2][0]) ? $PhoneRegex[2][0] : '';

                    if (!empty($ProgressingProfile['object_extra'])) {
                        $TempFollowerScraps = unserialize($ProgressingProfile['object_extra']);
                        $FollowerScraps = array_merge($FollowerScraps, $TempFollowerScraps);
                    }

                    $ScrapsModel->update($ProgressingProfile['id'], [
                        'object_extra'  =>  serialize($FollowerScraps),
                        'object_processing' =>  0,
                        'object_processed'  =>  1
                    ]);
                }

                if ($ScrapsModel->where('task_id', $ProgressingProfile['task_id'])
                        ->where('object_processed', 0)
                        ->countAllResults() == 0
                ) {
                    $TasksModel->update($ProgressingProfile['task_id'], [
                        'task_done' =>  1
                    ]);
                    $CurrentUser =  $UsersModel->find($CurrentTask->task_userid);

                    $UsersModel->update($CurrentTask->task_userid, [
                        'locked_credits'    =>  $CurrentUser->locked_credits - $CurrentTask->task_max
                    ]);

                    $this->checkParentTask($ProgressingProfile['task_id']);
                }

                sleep(1);
            }
        } catch (\InstagramAPI\Exception\ChallengeRequiredException $e) {
            $AccountsModel->update($this->Account->id, [
                'account_status'  => 0
            ]);

            foreach ($this->ProgressingProfiles as $ProgressingProfile) {
                $ScrapsModel->update($ProgressingProfile['id'], [
                    'object_processing' =>  0
                ]);
            }
        } catch (\InstagramAPI\Exception\ThrottledException $e) {
            $CurrentTime = new \Datetime();
            $CurrentTime->modify('+24 hours');

            if (!empty($CurrentTask)) {
                $AccountsModel->update($this->Account->id, [
                    $CurrentTask->task_action  => $CurrentTime->format('Y-m-d H:i:s')
                ]);
            }

            foreach ($this->ProgressingProfiles as $ProgressingProfile) {
                $ScrapsModel->update($ProgressingProfile['id'], [
                    'object_processing' =>  0
                ]);
            }
        } catch (\Exception $e) {
            foreach ($this->ProgressingProfiles as $ProgressingProfile) {
                $ScrapsModel->update($ProgressingProfile['id'], [
                    'object_processing' =>  0
                ]);
            }
        }

        $this->data['Message'] = "Done";
        $this->data['Status'] = 1;
        return;
    }

    // Misc Functions
    protected function checkParentTask($TaskId)
    {
        $TasksModel = new TasksModel();
        $TasksQueryBuilder = $this->QueryDb->table('tasks');

        $Task = $TasksQueryBuilder->where('id', $TaskId)->get()->getRow();
        $ParentTaskId = $Task->task_parent;
        $ParentTask = $TasksQueryBuilder->where('id', $ParentTaskId)->get()->getRow();
        $ChildTasks = $TasksQueryBuilder->where('task_parent', $ParentTaskId)->get();
        $ParentTaskDone = true;

        foreach ($ChildTasks->getResult() as $ChildTask) {
            if ($ChildTask->task_done == 0) {
                $ParentTaskDone = false;
                break;
            }
        }

        if ($ParentTaskDone) {
            $TasksModel->update($ParentTask->id, [
                'task_done' =>  1
            ]);

            $LogsModel = new LogsModel();
            $LogEntity = new \App\Entities\Logs();
            $LogEntity->log_type = 'scrap';
            $LogEntity->user_id = $ParentTask->task_userid;

            $StartTime = new \DateTime($ParentTask->created_at);
            $CurrentTime = new \DateTime();
            $Diff = $StartTime->diff($CurrentTime);

            $AccessDetails = [
                'ExecutionTime'  =>  round($Diff->s, 2)
            ];
            $LogEntity->log_content = serialize($AccessDetails);
            $LogsModel->save($LogEntity);
        }
    }
}
