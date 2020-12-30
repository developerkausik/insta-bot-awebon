<?php
namespace App\Controllers\Rest\Tasks;

use App\Controllers\Rest\RestTaskController;
use App\Models\AccountsModel;
use App\Models\ScrapsModel;
use App\Models\TasksModel;
use App\Models\AccountsRecordsModel;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\FileCookieJar;

class Task extends RestTaskController
{
    // Username Scraping Functions
    public function username_followers()
    {
        $ScrapsModel = new ScrapsModel();
        $TasksModel = new TasksModel();
        $AccountsRecordsModel = new AccountsRecordsModel();
        $CurrentAccountRecords = $AccountsRecordsModel->asArray()->where('account_id', $this->Account->id)->first();
        $CurrentRecordLimit = intval($CurrentAccountRecords['username_followers']);

        $UserId = $this->Task->task_destination;

        $InstaClientSettings = [
            'base_uri'  =>  'https://www.instagram.com',
            'cookies'   =>  $cookie_jar = new FileCookieJar(
                APPPATH . 'Vendor/mgp25/instagram-php/sessions/' . $this->Account->account_username . '/' . $this->Account->account_username . '-cookies.dat',
                false
            )
        ];
        if(!empty($this->Account->account_proxy)) {
            $InstaClientSettings = array_merge($InstaClientSettings, [
                'proxy' =>  $this->Account->account_proxy
            ]);
        }

        $InstaClient = new Client($InstaClientSettings);

        if (empty($this->Task->task_pagination)) {
            $First = 50;
            $InstaRequest = [
                'id'    =>  $UserId,
                'include_reel' => 'true',
                'fetch_mutual'  =>  'false',
                'first' =>  $First
            ];
        } else {
            $InstaRequest = unserialize($this->Task->task_pagination);
            $First = $InstaRequest['first'];
        }

        $StopLooping = false;
        $HasCorrectedFollowersCount = false;
        $MaxResults = $this->Task->task_max;
        $DoneResults = $ScrapsModel->where('task_id', $this->Task->id)->countAllResults();

        helper('accounts');
        do {
            $PaginationInfos = [];
            $First = $First + 50;
            $CurrentRecordLimit = $CurrentRecordLimit - 50;
            try {
                $FollowersResponse = $InstaClient->request('GET', '/graphql/query/?'.http_build_query([
                        'query_hash'    =>  'c76146de99bb02f6415203be841dd25a',
                        'variables'     =>  json_encode($InstaRequest)
                    ]));
                log_message('info', $FollowersResponse->getBody());
                $FollowersObject = json_decode($FollowersResponse->getBody(), true);

                if ($CurrentRecordLimit <= 0) {
                    $StopLooping = true;
                }

                if (!empty($FollowersObject['data']['user']['edge_followed_by']['edges'])) {
                    $PaginationInfos = $FollowersObject['data']['user']['edge_followed_by']['page_info'];
                    $FollowersEdges = $FollowersObject['data']['user']['edge_followed_by']['edges'];
                    $FollowersCount = $FollowersObject['data']['user']['edge_followed_by']['count'];

                    if ($FollowersCount < $MaxResults && !$HasCorrectedFollowersCount) {
                        $MaxResults = $FollowersCount;
                        $this->Task->task_max = $MaxResults;
                        $TasksModel->save($this->Task);
                        $HasCorrectedFollowersCount = true;
                    }

                    foreach ($FollowersEdges as $FollowerEdge) {
                        $FollowerNode = $FollowerEdge['node'];
                        $DoneResults++;

                        if ($DoneResults > $MaxResults) {
                            $this->Task->task_finished = 1;
                            $TasksModel->save($this->Task);
                            $StopLooping = true;
                            break;
                        }

                        $ScrapsModel->insert([
                            'task_id'       => $this->Task->id,
                            'object_id'     => $FollowerNode['id'],
                            'object_value'  => $FollowerNode['username']
                        ]);
                    }
                }

                if (!empty($PaginationInfos) && $PaginationInfos['has_next_page'] == true) {
                    $InstaRequest = array_merge($InstaRequest, [
                        'first' =>  $First,
                        'after' =>  $PaginationInfos['end_cursor']
                    ]);
                }
            } catch(\Exception $e) {
                $StopLooping = true;
                $errorMessage = 'Error in Account ';
                if(strpos($e->getMessage(), '429 -')  !== false){
                    $errorMessage = '429 - Throttled by too many api requests ';
                }
                $AccountsModel = new AccountsModel();

                $CurrentTime = new \Datetime();
                $CurrentTime->modify('+24 hours');

                $AccountsModel->update($this->Account->id, [
                    'account_fail_reason'  => $errorMessage.$CurrentTime->format('Y-m-d H:i:s'),
                    'account_status'    =>  1
                ]);

            }
        } while($StopLooping == false);

        $AccountsRecordsModel->update($CurrentAccountRecords['id'], [
            'username_followers'    =>  $CurrentRecordLimit
        ]);

        $TasksModel->update($this->Task->id, [
            'task_pagination'   =>  serialize($InstaRequest)
        ]);

        $this->data['Message'] = "Done";
        $this->data['Status'] = 1;
        return;
    }
    public function username_followings()
    {
        $ScrapsModel = new ScrapsModel();
        $TasksModel = new TasksModel();

        $UserId = $this->Task->task_destination;

        $InstaClientSettings = [
            'base_uri'  =>  'https://www.instagram.com',
            'cookies'   =>  $cookie_jar = new FileCookieJar(
                APPPATH . 'Vendor/mgp25/instagram-php/sessions/' . $this->Account->account_username . '/' . $this->Account->account_username . '-cookies.dat',
                false
            )
        ];
        if(!empty($this->Account->account_proxy)) {
            $InstaClientSettings = array_merge($InstaClientSettings, [
                'proxy' =>  $this->Account->account_proxy
            ]);
        }

        $InstaClient = new Client($InstaClientSettings);

        if (empty($this->Task->task_pagination)) {
            $First = 50;
            $InstaRequest = [
                'id'    =>  $UserId,
                'include_reel' => 'true',
                'fetch_mutual'  =>  'false',
                'first' =>  $First
            ];
        } else {
            $InstaRequest = unserialize($this->Task->task_pagination);
            $First = $InstaRequest['first'];
        }

        $StopLooping = $HasCorrectedFollowersCount = false;
        $MaxResults = $this->Task->task_max;
        $DoneResults = $ScrapsModel->where('task_id', $this->Task->id)->countAllResults();

        do {
            $First = $First + 50;
            $FollowingsResponse = $InstaClient->request('GET', '/graphql/query/?'.http_build_query([
                    'query_hash'    =>  'd04b0a864b4b54837c0d870b0e77e076',
                    'variables'     =>  json_encode($InstaRequest)
                ]));
            $FollowingsObject = json_decode($FollowingsResponse->getBody(), true);

            if (!empty($FollowingsObject['data']['user']['edge_follow']['edges'])) {
                $PaginationInfos = $FollowingsObject['data']['user']['edge_follow']['page_info'];
                $FollowingsEdges = $FollowingsObject['data']['user']['edge_follow']['edges'];
                $FollowingsCount = $FollowingsObject['data']['user']['edge_follow']['count'];

                if ($FollowingsCount < $MaxResults && !$HasCorrectedFollowersCount) {
                    $MaxResults = $FollowingsCount;
                    $this->Task->task_max = $MaxResults;
                    $TasksModel->save($this->Task);
                    $HasCorrectedFollowersCount = true;
                }

                foreach ($FollowingsEdges as $FollowingsEdge) {
                    $FollowingNode = $FollowingsEdge['node'];
                    $DoneResults++;
                    if ($DoneResults > $MaxResults) {
                        $this->Task->task_finished = 1;
                        $TasksModel->save($this->Task);
                        $StopLooping = true;
                        break;
                    }

                    $ScrapsModel->insert([
                        'task_id'       => $this->Task->id,
                        'object_id'     => $FollowingNode['id'],
                        'object_value'  => $FollowingNode['username']
                    ]);
                }
            }

            if (!empty($PaginationInfos) && $PaginationInfos['has_next_page'] == true) {
                $InstaRequest = array_merge($InstaRequest, [
                    'first' =>  $First,
                    'after' =>  $PaginationInfos['end_cursor']
                ]);
            }
        } while($StopLooping == false);

        $this->data['Message'] = "Done";
        $this->data['Status'] = 1;
        return;
    }
    public function username_posts()
    {
        $TasksModel = new TasksModel();
        $ScrapsModel = new ScrapsModel();
        $ScrapsQueryBuilder = $this->QueryDb->table('scraps');

        $UserId = $this->Task->task_destination;
        helper('accounts');

        try {
            $ig = new \InstagramAPI\Instagram();
            if(!empty($this->Account->account_proxy)) {
                $ig->setProxy($this->Account->account_proxy);
            }
            $login = $ig->login($this->Account->account_username, $this->Account->account_password);

            $maxId = $this->Task->task_pagination;
            $StopTaskLoop = false;

            $MaxResults = $this->Task->task_max;
            $DoneResults = $ScrapsQueryBuilder->where('task_id', $this->Task->id)->countAllResults();
            $ScrapedFields = \get_item_model(true);
            do {
                sleep(1);
                $sResponse = $ig->timeline->getUserFeed($UserId, $maxId);

                if ($sResponse->hasItems()) {
                    foreach ($sResponse->getItems() as $_f_array) {
                        if (!empty($ScrapsQueryBuilder->where('task_id', $this->Task->id)->where('object_id', $_f_array->getPk())->countAllResults())) {
                            continue;
                        }

                        $DoneResults++;
                        if ($DoneResults > $MaxResults) {
                            $TasksModel->update($this->Task->id, [
                                'task_done' =>  1
                            ]);

                            $StopTaskLoop = true;
                            break;
                        }

                        $PostRecord = [];
                        foreach ($ScrapedFields as $FieldKey => $FieldType) {
                            $IsField = 'is'.$FieldKey;
                            $GetField = 'get'.$FieldKey;

                            if ($_f_array->{$IsField}()) {
                                if ($FieldType == 'Caption') {
                                    $PostRecord[$FieldKey] = utf8_encode($_f_array->getCaption()->getText());
                                } else if ($FieldType == 'string') {
                                    $PostRecord[$FieldKey] = utf8_encode($_f_array->{$GetField}());
                                    /*} else if ($FieldType = 'media_type') {
                                        $PostRecord[$FieldKey] = $this->MediaTypes[$_f_array->{$GetField}()] ?? 'OTHER';
                                    } */
                                } else {
                                    $PostRecord[$FieldKey] = $_f_array->{$GetField}();
                                }
                            } else {
                                $PostRecord[$FieldKey] = false;
                            }
                        }

                        $ScrapsModel->insert([
                            'task_id' => $this->Task->id,
                            'object_id' => $PostRecord['Pk'],
                            'object_value' => $PostRecord['Id'],
                            'object_extra'  =>  serialize($PostRecord),
                            'object_processed'  =>  1
                        ]);
                    }
                }

                if ($sResponse->isMoreAvailable()) {
                    $maxId = $sResponse->getNextMaxId();
                    $TasksModel->update($this->Task->id, [
                        'task_pagination'   =>  $maxId
                    ]);
                } else {
                    $maxId = null;
                    $TasksModel->update($this->Task->id, [
                        'task_done'   =>  1,
                        'task_max'    =>  $DoneResults
                    ]);
                    $StopTaskLoop = true;
                }
            } while($StopTaskLoop == false);

            $this->checkParentTask($this->Task);
        } catch (\InstagramAPI\Exception\ChallengeRequiredException $e) {
            $AccountsModel = new AccountsModel();

            $AccountsModel->update([
                'account_status'    =>  1
            ]);
        } catch (\InstagramAPI\Exception\ThrottledException $e) {
            $AccountsModel = new AccountsModel();

            $CurrentTime = new \Datetime();
            $CurrentTime->modify('+24 hours');

            $AccountsModel->update($this->Account->id, [
                $this->Task->task_action  => $CurrentTime->format('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            // Do Nothing for now
        }

        $this->data['Message'] = "Done";
        $this->data['Status'] = 1;
        return;
    }
    public function username_likes()
    {
        $TasksModel = new TasksModel();
        $ScrapsModel = new ScrapsModel();

        $ScrapsQueryBuilder = $this->QueryDb->table('scraps');

        helper('accounts');
        $UserId = $this->Task->task_destination;

        try {
            $ig = new \InstagramAPI\Instagram();
            if(!empty($this->Account->account_proxy)) {
                $ig->setProxy($this->Account->account_proxy);
            }
            $login = $ig->login($this->Account->account_username, $this->Account->account_password);

            $maxId = $this->Task->task_pagination;
            $MaxLikers = $this->Task->task_max;
            $DoneResults = $ScrapsQueryBuilder->where('task_id', $this->Task->id)->countAllResults();
            $StopLooping = false;

            do {
                $sResponse = $ig->timeline->getUserFeed($UserId, $maxId);

                if ($sResponse->hasItems()) {
                    foreach ($sResponse->getItems() as $_f_array) {
                        $lResponse = $ig->media->getLikers($_f_array->getPk());

                        foreach ($lResponse->getUsers() as $User) {
                            if (!empty($ScrapsQueryBuilder->where('task_id', $this->Task->id)->where('object_id', $User->getPk())->countAllResults())) {
                                continue;
                            }

                            $DoneResults++;
                            if ($DoneResults > $MaxLikers) {
                                $TasksModel->update($this->Task->id, [
                                    'task_finished' =>  1
                                ]);
                                $StopLooping = true;
                                break 2;
                            }

                            $ScrapsModel->insert([
                                'task_id'       => $this->Task->id,
                                'object_id'     => $User->getPk(),
                                'object_value'  => $User->getUsername(),
                            ]);
                        }
                    }

                } else {
                    $StopLooping = true;
                }

                if ($sResponse->isMoreAvailable() && !$StopLooping) {
                    $maxId = $sResponse->getNextMaxId();
                    $TasksModel->update($this->Task->id, [
                        'task_pagination'   =>  $maxId
                    ]);
                } else {
                    $maxId = null;
                    if ($DoneResults < $this->Task->task_max) {
                        $TasksModel->update($this->Task->id, [
                            'task_max'   =>  $DoneResults
                        ]);
                    }
                    $TasksModel->update($this->Task->id, [
                        'task_finished'   =>  1
                    ]);
                    $StopLooping = true;
                }
            } while($StopLooping == false);
        } catch (\InstagramAPI\Exception\ChallengeRequiredException $e) {
            $AccountsModel = new AccountsModel();

            $AccountsModel->update([
                'account_status'    =>  1
            ]);
        } catch (\InstagramAPI\Exception\ThrottledException $e) {
            $AccountsModel = new AccountsModel();

            $CurrentTime = new \Datetime();
            $CurrentTime->modify('+24 hours');

            $AccountsModel->update($this->Account->id, [
                $this->Task->task_action  => $CurrentTime->format('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            // Do Nothing for now
        }


        $this->data['Message'] = "Done";
        $this->data['Status'] = 1;
        return;
    }
    public function username_comments()
    {
        $TasksModel = new TasksModel();
        $ScrapsModel = new ScrapsModel();

        $ScrapsQueryBuilder = $this->QueryDb->table('scraps');

        helper('accounts');
        $UserId = $this->Task->task_destination;

        try {
            $ig = new \InstagramAPI\Instagram();
            if(!empty($this->Account->account_proxy)) {
                $ig->setProxy($this->Account->account_proxy);
            }
            $login = $ig->login($this->Account->account_username, $this->Account->account_password);

            $maxId = !empty($this->Task->task_pagination) ? unserialize($this->Task->task_pagination) : null;
            $QueueTask = $this->Task->task_fuids_queue == null ? [] : unserialize($this->Task->task_fuids_queue);
            $Stop = false;
            $DoneResults = $ScrapsQueryBuilder->where('task_id', $this->Task->id)->countAllResults();
            $ScrapedFields = \get_comment_model(true);

            if (empty($QueueTask)) {
                $MaxComments = $this->Task->task_max;
                $commentsMaxId = $this->Task->task_message;

                do {
                    $sResponse = $ig->timeline->getUserFeed($UserId, $commentsMaxId);

                    if ($sResponse->hasItems()) {
                        foreach ($sResponse->getItems() as $_f_array) {
                            $InstantScrapedComments = $_f_array->getCommentCount();
                            if ($InstantScrapedComments > 0) {
                                $StopComments = false;
                                $MediaId = $_f_array->getPk();
                                do {
                                    $Options = [];
                                    sleep(1);
                                    if (!empty($maxId)) {
                                        $Options['min_id'] = $maxId;
                                    }
                                    $commentResponse = $ig->media->getComments($MediaId, $Options);
                                    $hasCommentsDisabled = $commentResponse->hasCommentsDisabled() ?? false;
                                    if ($hasCommentsDisabled) {
                                        if ($commentResponse->getCommentsDisabled()) {
                                            $StopComments = true;
                                        }
                                    }

                                    if (!$StopComments) {
                                        foreach ($commentResponse->getComments() as $Comment) {
                                            if (!empty($ScrapsQueryBuilder->where('task_id', $this->Task->id)->where('object_id', $Comment->getPk())->countAllResults())) {
                                                continue;
                                            }

                                            $DoneResults++;
                                            if ($DoneResults > $MaxComments) {
                                                $TasksModel->update($this->Task->id, [
                                                    'task_finished'  =>  1
                                                ]);
                                                $Stop = $StopComments = true;
                                                break 3;
                                            }

                                            $CommentRecord = [];
                                            foreach ($ScrapedFields as $FieldKey => $FieldType) {
                                                $IsField = 'is'.$FieldKey;
                                                $GetField = 'get'.$FieldKey;

                                                if ($Comment->{$IsField}()) {
                                                    if ($FieldType == 'string') {
                                                        $CommentRecord[$FieldKey] = utf8_encode($Comment->{$GetField}());
                                                    } else {
                                                        $CommentRecord[$FieldKey] = $Comment->{$GetField}();
                                                    }
                                                } else {
                                                    $CommentRecord[$FieldKey] = false;
                                                }
                                            }

                                            $ScrapsModel->insert([
                                                'task_id' => $this->Task->id,
                                                'object_id' => $MediaId,
                                                'object_value' => $Comment->getUser()->getUsername(),
                                                'object_extra'  =>  serialize($CommentRecord),
                                            ]);
                                        }
                                    }

                                    if ($commentResponse->isNextMinId() && !$StopComments) {
                                        $maxId = $commentResponse->getNextMinId();
                                        $TasksModel->update($this->Task->id, [
                                            'task_pagination'  =>  serialize($maxId)
                                        ]);
                                    } else {
                                        $StopComments = true;
                                        $maxId = null;
                                    }
                                } while($StopComments == false);
                            }
                        }
                    } else {
                        $TasksModel->update($this->Task->id, [
                            'task_finished'  =>  1
                        ]);
                        $Stop = true;
                    }

                    if ($sResponse->isMoreAvailable() && !$Stop) {
                        $commentsMaxId = $sResponse->getNextMaxId();
                        $TasksModel->update($this->Task->id, [
                            'task_message'  =>  $commentsMaxId
                        ]);
                    } else {
                        if ($DoneResults < $this->Task->task_max) {
                            $TasksModel->update($this->Task->id, [
                                'task_max'  =>  $DoneResults
                            ]);
                        }
                        $commentsMaxId = null;
                    }
                } while($commentsMaxId !== null);
            }
        } catch (\InstagramAPI\Exception\ChallengeRequiredException $e) {
            $AccountsModel = new AccountsModel();

            $AccountsModel->update([
                'account_status'    =>  1
            ]);
        } catch (\InstagramAPI\Exception\ThrottledException $e) {
            $AccountsModel = new AccountsModel();

            $CurrentTime = new \Datetime();
            $CurrentTime->modify('+24 hours');

            $AccountsModel->update($this->Account->id, [
                $this->Task->task_action  => $CurrentTime->format('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            // Do nothing for now
        }


        $this->data['Message'] = "Done";
        $this->data['Status'] = 1;
        return;
    }

    // Hashtags Scraping Functions
    public function hashtag_posts()
    {
        $TasksModel = new TasksModel();
        $ScrapsModel = new ScrapsModel();

        $ScrapsQueryBuilder = $this->QueryDb->table('scraps');

        helper('accounts');
        $Hashtag = $this->Task->task_destination;

        try {
            $ig = new \InstagramAPI\Instagram();
            if(!empty($this->Account->account_proxy)) {
                $ig->setProxy($this->Account->account_proxy);
            }
            $login = $ig->login($this->Account->account_username, $this->Account->account_password);

            $maxId = $this->Task->task_pagination;
            $rankToken = \InstagramAPI\Signatures::generateUUID();
            $MaxResults = $this->Task->task_max;
            $DoneResults = $ScrapsQueryBuilder->where('task_id', $this->Task->id)->countAllResults();
            $StopLooping = false;

            $ScrapedFields = \get_item_model(true);
            do {
                sleep(1);
                $sResponse = $ig->hashtag->getFeed($Hashtag, $rankToken, $maxId);

                if ($sResponse->hasItems()) {
                    foreach ($sResponse->getItems() as $_f_array) {
                        if (!empty($ScrapsQueryBuilder->where('task_id', $this->Task->id)->where('object_id', $_f_array->getPk())->countAllResults())) {
                            continue;
                        }

                        $DoneResults++;
                        if ($DoneResults > $MaxResults) {
                            $TasksModel->update($this->Task->id, [
                                'task_done' =>  1
                            ]);

                            $StopLooping = true;
                            break;
                        }

                        $PostRecord = [];
                        foreach ($ScrapedFields as $FieldKey => $FieldType) {
                            $IsField = 'is'.$FieldKey;
                            $GetField = 'get'.$FieldKey;

                            if ($_f_array->{$IsField}()) {
                                if ($FieldType == 'Caption') {
                                    $PostRecord[$FieldKey] = utf8_encode($_f_array->getCaption()->getText());
                                } else if ($FieldType == 'string') {
                                    $PostRecord[$FieldKey] = utf8_encode($_f_array->{$GetField}());
                                    /*} else if ($FieldType = 'media_type') {
                                        $PostRecord[$FieldKey] = $this->MediaTypes[$_f_array->{$GetField}()] ?? 'OTHER';
                                    } */
                                } else {
                                    $PostRecord[$FieldKey] = $_f_array->{$GetField}();
                                }
                            } else {
                                $PostRecord[$FieldKey] = false;
                            }
                        }

                        $ScrapsModel->insert([
                            'task_id' => $this->Task->id,
                            'object_id' => $PostRecord['Pk'],
                            'object_value' => $PostRecord['Id'],
                            'object_extra'  =>  serialize($PostRecord),
                            'object_processed'  =>  1
                        ]);
                    }
                }

                if ($sResponse->isMoreAvailable()) {
                    $maxId = $sResponse->getNextMaxId();
                    $TasksModel->update($this->Task->id, [
                        'task_pagination'   =>  $maxId
                    ]);
                } else {
                    $maxId = null;
                    $StopLooping = true;
                    $TasksModel->update($this->Task->id, [
                        'task_done'   =>  1,
                        'task_max'    =>  $DoneResults
                    ]);
                }
            } while($StopLooping == false);

            $this->checkParentTask($this->Task);
        } catch (\InstagramAPI\Exception\ChallengeRequiredException $e) {
            $AccountsModel = new AccountsModel();

            $AccountsModel->update([
                'account_status'    =>  1
            ]);
        } catch (\InstagramAPI\Exception\ThrottledException $e) {
            $AccountsModel = new AccountsModel();

            $CurrentTime = new \Datetime();
            $CurrentTime->modify('+24 hours');

            $AccountsModel->update($this->Account->id, [
                $this->Task->task_action  => $CurrentTime->format('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            // Do Nothing for now
        }


        $this->data['Message'] = "Done";
        $this->data['Status'] = 1;
        return;
    }
    public function hashtag_comments()
    {
        $TasksModel = new TasksModel();
        $ScrapsModel = new ScrapsModel();

        $ScrapsQueryBuilder = $this->QueryDb->table('scraps');

        helper('accounts');
        $Hashtag = $this->Task->task_destination;

        try {
            $ig = new \InstagramAPI\Instagram();
            if(!empty($this->Account->account_proxy)) {
                $ig->setProxy($this->Account->account_proxy);
            }
            $login = $ig->login($this->Account->account_username, $this->Account->account_password);

            $maxId = !empty($this->Task->task_pagination) ? unserialize($this->Task->task_pagination) : null;
            $rankToken = \InstagramAPI\Signatures::generateUUID();
            $QueueTask = $this->Task->task_fuids_queue == null ? [] : unserialize($this->Task->task_fuids_queue);
            $Stop = false;
            $DoneResults = $ScrapsQueryBuilder->where('task_id', $this->Task->id)->countAllResults();
            $ScrapedFields = \get_comment_model(true);

            if (empty($QueueTask)) {
                $MaxComments = $this->Task->task_max;
                $commentsMaxId = $this->Task->task_message;

                do {
                    $sResponse = $ig->hashtag->getFeed($Hashtag, $rankToken, $commentsMaxId);

                    if ($sResponse->hasItems()) {
                        foreach ($sResponse->getItems() as $_f_array) {
                            $InstantScrapedComments = $_f_array->getCommentCount();
                            if ($InstantScrapedComments > 0) {
                                $StopComments = false;
                                $MediaId = $_f_array->getPk();

                                do {
                                    $Options = [];
                                    sleep(1);
                                    if (!empty($maxId)) {
                                        $Options['min_id'] = $maxId;
                                    }
                                    $commentResponse = $ig->media->getComments($MediaId, $Options);
                                    $hasCommentsDisabled = $commentResponse->hasCommentsDisabled() ?? false;
                                    if ($hasCommentsDisabled) {
                                        if ($commentResponse->getCommentsDisabled()) {
                                            $StopComments = true;
                                        }
                                    }

                                    if (!$StopComments) {
                                        foreach ($commentResponse->getComments() as $Comment) {
                                            if (!empty($ScrapsQueryBuilder->where('task_id', $this->Task->id)->where('object_id', $Comment->getPk())->countAllResults())) {
                                                continue;
                                            }

                                            $DoneResults++;
                                            if ($DoneResults > $MaxComments) {
                                                $TasksModel->update($this->Task->id, [
                                                    'task_finished'  =>  1
                                                ]);
                                                $Stop = $StopComments = true;
                                                break 3;
                                            }

                                            $CommentRecord = [];
                                            foreach ($ScrapedFields as $FieldKey => $FieldType) {
                                                $IsField = 'is'.$FieldKey;
                                                $GetField = 'get'.$FieldKey;

                                                if ($Comment->{$IsField}()) {
                                                    if ($FieldType == 'string') {
                                                        $CommentRecord[$FieldKey] = utf8_encode($Comment->{$GetField}());
                                                    } else {
                                                        $CommentRecord[$FieldKey] = $Comment->{$GetField}();
                                                    }
                                                } else {
                                                    $CommentRecord[$FieldKey] = false;
                                                }
                                            }

                                            $ScrapsModel->insert([
                                                'task_id' => $this->Task->id,
                                                'object_id' => $MediaId,
                                                'object_value' => $Comment->getUser()->getUsername(),
                                                'object_extra'  =>  serialize($CommentRecord),
                                            ]);
                                        }
                                    }

                                    if ($commentResponse->isNextMinId() && !$StopComments) {
                                        $maxId = $commentResponse->getNextMinId();
                                        $TasksModel->update($this->Task->id, [
                                            'task_pagination'  =>  serialize($maxId)
                                        ]);
                                    } else {
                                        $StopComments = true;
                                        $maxId = null;
                                    }
                                } while($StopComments == false);
                            }
                        }
                    } else {
                        $TasksModel->update($this->Task->id, [
                            'task_finished'  =>  1
                        ]);
                        $Stop = true;
                    }

                    if ($sResponse->isMoreAvailable() && !$Stop) {
                        $commentsMaxId = $sResponse->getNextMaxId();
                        $TasksModel->update($this->Task->id, [
                            'task_message'  =>  $commentsMaxId
                        ]);
                    } else {
                        if ($DoneResults < $this->Task->task_max) {
                            $TasksModel->update($this->Task->id, [
                                'task_max'  =>  $DoneResults
                            ]);
                        }
                        $commentsMaxId = null;
                    }
                } while($commentsMaxId !== null);
            }
        } catch (\InstagramAPI\Exception\ChallengeRequiredException $e) {
            $AccountsModel = new AccountsModel();

            $AccountsModel->update([
                'account_status'    =>  1
            ]);
        } catch (\InstagramAPI\Exception\ThrottledException $e) {
            $AccountsModel = new AccountsModel();

            $CurrentTime = new \Datetime();
            $CurrentTime->modify('+24 hours');

            $AccountsModel->update($this->Account->id, [
                $this->Task->task_action  => $CurrentTime->format('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            // Do Nothing For Now
        }


        $this->data['Message'] = "Done";
        $this->data['Status'] = 1;
        return;
    }
    public function hashtag_likes()
    {
        $TasksModel = new TasksModel();
        $ScrapsModel = new ScrapsModel();

        $ScrapsQueryBuilder = $this->QueryDb->table('scraps');

        helper('accounts');
        $Hashtag = $this->Task->task_destination;

        try {
            $ig = new \InstagramAPI\Instagram();
            if(!empty($this->Account->account_proxy)) {
                $ig->setProxy($this->Account->account_proxy);
            }
            $login = $ig->login($this->Account->account_username, $this->Account->account_password);

            $maxId = $this->Task->task_pagination;
            $MaxLikers = $this->Task->task_max;
            $rankToken = \InstagramAPI\Signatures::generateUUID();
            $DoneResults = $ScrapsQueryBuilder->where('task_id', $this->Task->id)->countAllResults();
            $StopLooping = false;

            do {
                $sResponse = $ig->hashtag->getFeed($Hashtag, $rankToken, $maxId);

                if ($sResponse->hasItems()) {
                    foreach ($sResponse->getItems() as $_f_array) {
                        $lResponse = $ig->media->getLikers($_f_array->getPk());

                        if ($lResponse->hasUsers()) {
                            foreach ($lResponse->getUsers() as $User) {
                                if (!empty($ScrapsQueryBuilder->where('task_id', $this->Task->id)->where('object_id', $User->getPk())->countAllResults())) {
                                    continue;
                                }

                                $DoneResults++;
                                if ($DoneResults > $MaxLikers) {
                                    $TasksModel->update($this->Task->id, [
                                        'task_finished' =>  1
                                    ]);
                                    $StopLooping = true;
                                    break 2;
                                }

                                $ScrapsModel->insert([
                                    'task_id'       => $this->Task->id,
                                    'object_id'     => $User->getPk(),
                                    'object_value'  => $User->getUsername(),
                                ]);
                            }
                        }
                    }
                } else {
                    $StopLooping = true;
                }

                if ($sResponse->isMoreAvailable() && !$StopLooping) {
                    $maxId = $sResponse->getNextMaxId();
                    $TasksModel->update($this->Task->id, [
                        'task_pagination'   =>  $maxId
                    ]);
                } else {
                    $maxId = null;
                    if ($DoneResults < $this->Task->task_max) {
                        $TasksModel->update($this->Task->id, [
                            'task_max'   =>  $DoneResults
                        ]);
                    }
                    $TasksModel->update($this->Task->id, [
                        'task_finished'   =>  1
                    ]);
                    $StopLooping = true;
                }
            } while($StopLooping == false);
        } catch (\InstagramAPI\Exception\ChallengeRequiredException $e) {
            $AccountsModel = new AccountsModel();

            $AccountsModel->update([
                'account_status'    =>  1
            ]);
        } catch (\InstagramAPI\Exception\ThrottledException $e) {
            $AccountsModel = new AccountsModel();

            $CurrentTime = new \Datetime();
            $CurrentTime->modify('+24 hours');

            $AccountsModel->update($this->Account->id, [
                $this->Task->task_action  => $CurrentTime->format('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            // Do Nothing For Now
        }


        $this->data['Message'] = "Done";
        $this->data['Status'] = 1;
        return;
    }

    // Location Scraping Functions
    public function location_posts()
    {
        $TasksModel = new TasksModel();
        $ScrapsModel = new ScrapsModel();

        $ScrapsQueryBuilder = $this->QueryDb->table('scraps');

        helper('accounts');
        $Location = $this->Task->task_destination;

        try {
            $ig = new \InstagramAPI\Instagram();
            if(!empty($this->Account->account_proxy)) {
                $ig->setProxy($this->Account->account_proxy);
            }
            $login = $ig->login($this->Account->account_username, $this->Account->account_password);

            $maxId = $this->Task->task_pagination;
            $rankToken = \InstagramAPI\Signatures::generateUUID();
            $MaxResults = $this->Task->task_max;
            $DoneResults = $ScrapsQueryBuilder->where('task_id', $this->Task->id)->countAllResults();
            $StopLooping = false;

            $ScrapedFields = \get_item_model(true);
            do {
                sleep(1);
                $sResponse = $ig->location->getFeed($Location, $rankToken, $maxId);

                if ($sResponse->hasItems()) {
                    foreach ($sResponse->getItems() as $_f_array) {
                        if (!empty($ScrapsQueryBuilder->where('task_id', $this->Task->id)->where('object_id', $_f_array->getPk())->countAllResults())) {
                            continue;
                        }

                        $DoneResults++;
                        if ($DoneResults > $MaxResults) {
                            $TasksModel->update($this->Task->id, [
                                'task_done' =>  1
                            ]);

                            $StopLooping = true;
                            break;
                        }

                        $PostRecord = [];
                        foreach ($ScrapedFields as $FieldKey => $FieldType) {
                            $IsField = 'is'.$FieldKey;
                            $GetField = 'get'.$FieldKey;

                            if ($_f_array->{$IsField}()) {
                                if ($FieldType == 'Caption') {
                                    $PostRecord[$FieldKey] = utf8_encode($_f_array->getCaption()->getText());
                                } else if ($FieldType == 'string') {
                                    $PostRecord[$FieldKey] = utf8_encode($_f_array->{$GetField}());
                                    /*} else if ($FieldType = 'media_type') {
                                        $PostRecord[$FieldKey] = $this->MediaTypes[$_f_array->{$GetField}()] ?? 'OTHER';
                                    } */
                                } else {
                                    $PostRecord[$FieldKey] = $_f_array->{$GetField}();
                                }
                            } else {
                                $PostRecord[$FieldKey] = false;
                            }
                        }

                        $ScrapsModel->insert([
                            'task_id' => $this->Task->id,
                            'object_id' => $PostRecord['Pk'],
                            'object_value' => $PostRecord['Id'],
                            'object_extra'  =>  serialize($PostRecord),
                            'object_processed'  =>  1
                        ]);
                    }
                }

                if ($sResponse->isMoreAvailable()) {
                    $maxId = $sResponse->getNextMaxId();
                    $TasksModel->update($this->Task->id, [
                        'task_pagination'   =>  $maxId
                    ]);
                } else {
                    $maxId = null;
                    $StopLooping = true;
                    $TasksModel->update($this->Task->id, [
                        'task_done'   =>  1,
                        'task_max'    =>  $DoneResults
                    ]);
                }
            } while($StopLooping == false);

            $this->checkParentTask($this->Task);
        } catch (\InstagramAPI\Exception\ChallengeRequiredException $e) {
            $AccountsModel = new AccountsModel();

            $AccountsModel->update([
                'account_status'    =>  1
            ]);
        } catch (\InstagramAPI\Exception\ThrottledException $e) {
            $AccountsModel = new AccountsModel();

            $CurrentTime = new \Datetime();
            $CurrentTime->modify('+24 hours');

            $AccountsModel->update($this->Account->id, [
                $this->Task->task_action  => $CurrentTime->format('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            // Do Nothing For Now
        }

        $this->data['Message'] = "Done";
        $this->data['Status'] = 1;
        return;

    }
    public function location_comments()
    {
        $TasksModel = new TasksModel();
        $ScrapsModel = new ScrapsModel();

        $ScrapsQueryBuilder = $this->QueryDb->table('scraps');

        helper('accounts');
        $Location = $this->Task->task_destination;

        try {
            $ig = new \InstagramAPI\Instagram();
            if(!empty($this->Account->account_proxy)) {
                $ig->setProxy($this->Account->account_proxy);
            }
            $login = $ig->login($this->Account->account_username, $this->Account->account_password);

            $maxId = !empty($this->Task->task_pagination) ? unserialize($this->Task->task_pagination) : null;
            $rankToken = \InstagramAPI\Signatures::generateUUID();
            $QueueTask = $this->Task->task_fuids_queue == null ? [] : unserialize($this->Task->task_fuids_queue);
            $DoneResults = $ScrapsQueryBuilder->where('task_id', $this->Task->id)->countAllResults();
            $Stop = false;

            $ScrapedFields = \get_comment_model(true);
            if (empty($QueueTask)) {
                $MaxComments = $this->Task->task_max;
                $commentsMaxId = $this->Task->task_message;
                do {
                    $sResponse = $ig->location->getFeed($Location, $rankToken, $commentsMaxId);

                    if ($sResponse->hasItems()) {
                        foreach ($sResponse->getItems() as $_f_array) {
                            $InstantScrapedComments = $_f_array->getCommentCount();
                            if ($InstantScrapedComments > 0) {
                                $StopComments = false;
                                $MediaId = $_f_array->getPk();

                                do {
                                    $Options = [];
                                    sleep(1);
                                    if (!empty($maxId)) {
                                        $Options['min_id'] = $maxId;
                                    }
                                    $commentResponse = $ig->media->getComments($MediaId, $Options);
                                    $hasCommentsDisabled = $commentResponse->hasCommentsDisabled() ?? false;
                                    if ($hasCommentsDisabled) {
                                        if ($commentResponse->getCommentsDisabled()) {
                                            $StopComments = true;
                                        }
                                    }

                                    if (!$StopComments) {
                                        foreach ($commentResponse->getComments() as $Comment) {
                                            if (!empty($ScrapsQueryBuilder->where('task_id', $this->Task->id)->where('object_id', $Comment->getPk())->countAllResults())) {
                                                continue;
                                            }

                                            $DoneResults++;
                                            if ($DoneResults > $MaxComments) {
                                                $TasksModel->update($this->Task->id, [
                                                    'task_finished'  =>  1
                                                ]);
                                                $Stop = $StopComments = true;
                                                break 3;
                                            }

                                            $CommentRecord = [];
                                            foreach ($ScrapedFields as $FieldKey => $FieldType) {
                                                $IsField = 'is'.$FieldKey;
                                                $GetField = 'get'.$FieldKey;

                                                if ($Comment->{$IsField}()) {
                                                    if ($FieldType == 'string') {
                                                        $CommentRecord[$FieldKey] = utf8_encode($Comment->{$GetField}());
                                                    } else {
                                                        $CommentRecord[$FieldKey] = $Comment->{$GetField}();
                                                    }
                                                } else {
                                                    $CommentRecord[$FieldKey] = false;
                                                }
                                            }

                                            $ScrapsModel->insert([
                                                'task_id' => $this->Task->id,
                                                'object_id' => $MediaId,
                                                'object_value' => $Comment->getUser()->getUsername(),
                                                'object_extra'  =>  serialize($CommentRecord),
                                            ]);
                                        }
                                    }

                                    if ($commentResponse->isNextMinId() && !$StopComments) {
                                        $maxId = $commentResponse->getNextMinId();
                                        $TasksModel->update($this->Task->id, [
                                            'task_pagination'  =>  serialize($maxId)
                                        ]);
                                    } else {
                                        $StopComments = true;
                                        $maxId = null;
                                    }
                                } while($StopComments == false);
                            }
                        }
                    } else {
                        $TasksModel->update($this->Task->id, [
                            'task_finished'  =>  1
                        ]);
                        $Stop = true;
                    }

                    if ($sResponse->isMoreAvailable() && !$Stop) {
                        $commentsMaxId = $sResponse->getNextMaxId();
                        $TasksModel->update($this->Task->id, [
                            'task_message'  =>  $commentsMaxId
                        ]);
                    } else {
                        if ($DoneResults < $this->Task->task_max) {
                            $TasksModel->update($this->Task->id, [
                                'task_max'  =>  $DoneResults
                            ]);
                        }
                        $commentsMaxId = null;
                    }
                } while($commentsMaxId !== null);
            }
        } catch (\InstagramAPI\Exception\ChallengeRequiredException $e) {
            $AccountsModel = new AccountsModel();

            $AccountsModel->update([
                'account_status'    =>  1
            ]);
        } catch (\InstagramAPI\Exception\ThrottledException $e) {
            $AccountsModel = new AccountsModel();

            $CurrentTime = new \Datetime();
            $CurrentTime->modify('+24 hours');

            $AccountsModel->update($this->Account->id, [
                $this->Task->task_action  => $CurrentTime->format('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            // Do Nothing For Now
        }

        $this->data['Message'] = "Done";
        $this->data['Status'] = 1;
        return;
    }
    public function location_likes()
    {
        $TasksModel = new TasksModel();
        $ScrapsModel = new ScrapsModel();

        $ScrapsQueryBuilder = $this->QueryDb->table('scraps');

        helper('accounts');
        $Location = $this->Task->task_destination;

        try {
            $ig = new \InstagramAPI\Instagram();
            $login = $ig->login($this->Account->account_username, $this->Account->account_password);

            $maxId = $this->Task->task_pagination;
            $MaxLikers = $this->Task->task_max;
            $rankToken = \InstagramAPI\Signatures::generateUUID();
            $DoneResults = $ScrapsQueryBuilder->where('task_id', $this->Task->id)->countAllResults();
            $StopLooping = false;

            do {
                $sResponse = $ig->location->getFeed($Location, $rankToken, $maxId);

                if ($sResponse->hasItems()) {
                    foreach ($sResponse->getItems() as $_f_array) {
                        $lResponse = $ig->media->getLikers($_f_array->getPk());

                        if ($lResponse->hasUsers()) {
                            foreach ($lResponse->getUsers() as $User) {
                                if (!empty($ScrapsQueryBuilder->where('task_id', $this->Task->id)->where('object_id', $User->getPk())->countAllResults())) {
                                    continue;
                                }

                                $DoneResults++;
                                if ($DoneResults > $MaxLikers) {
                                    $TasksModel->update($this->Task->id, [
                                        'task_finished' =>  1
                                    ]);
                                    $StopLooping = true;
                                    break 2;
                                }

                                $ScrapsModel->insert([
                                    'task_id'       => $this->Task->id,
                                    'object_id'     => $User->getPk(),
                                    'object_value'  => $User->getUsername(),
                                ]);
                            }

                        } else {
                            $StopLooping = true;
                        }

                    }
                }

                if ($sResponse->isMoreAvailable() && !$StopLooping) {
                    $maxId = $sResponse->getNextMaxId();
                    $TasksModel->update($this->Task->id, [
                        'task_pagination'   =>  $maxId
                    ]);
                } else {
                    $maxId = null;
                    if ($DoneResults < $this->Task->task_max) {
                        $TasksModel->update($this->Task->id, [
                            'task_max'   =>  $DoneResults
                        ]);
                    }
                    $TasksModel->update($this->Task->id, [
                        'task_finished'   =>  1
                    ]);
                    $StopLooping = true;
                }
            } while($StopLooping == false);
        } catch (\InstagramAPI\Exception\ChallengeRequiredException $e) {
            $AccountsModel = new AccountsModel();

            $AccountsModel->update([
                'account_status'    =>  1
            ]);
        } catch (\InstagramAPI\Exception\ThrottledException $e) {
            $AccountsModel = new AccountsModel();

            $CurrentTime = new \Datetime();
            $CurrentTime->modify('+24 hours');

            $AccountsModel->update($this->Account->id, [
                $this->Task->task_action  => $CurrentTime->format('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            // Do Nothing For Now
        }


        $this->data['Message'] = "Done";
        $this->data['Status'] = 1;
        return;
    }

    // Post Scraping Functions
    public function post_comments()
    {
        $TasksModel = new TasksModel();
        $ScrapsModel = new ScrapsModel();

        $ScrapsQueryBuilder = $this->QueryDb->table('scraps');

        helper('accounts');
        $MediaId = $this->Task->task_destination;

        try {
            $ig = new \InstagramAPI\Instagram();
            if(!empty($this->Account->account_proxy)) {
                $ig->setProxy($this->Account->account_proxy);
            }
            $login = $ig->login($this->Account->account_username, $this->Account->account_password);

            $maxId = !empty($this->Task->task_pagination) ? unserialize($this->Task->task_pagination) : null;
            $MaxComments = $this->Task->task_max;
            $StopComments = false;
            $DoneResults = $ScrapsQueryBuilder->where('task_id', $this->Task->id)->countAllResults();
            $ScrapedFields = \get_comment_model(true);

            do {
                $Options = [];
                sleep(1);
                if (!empty($maxId)) {
                    $Options['min_id'] = $maxId;
                }
                $commentResponse = $ig->media->getComments($MediaId, $Options);
                $hasCommentsDisabled = $commentResponse->hasCommentsDisabled() ?? false;
                if ($hasCommentsDisabled) {
                    if ($commentResponse->getCommentsDisabled()) {
                        $StopComments = true;
                    }
                }

                if (!$StopComments) {
                    foreach ($commentResponse->getComments() as $Comment) {
                        if (!empty($ScrapsQueryBuilder->where('task_id', $this->Task->id)->where('object_id', $Comment->getPk())->countAllResults())) {
                            continue;
                        }

                        $DoneResults++;
                        if ($DoneResults > $MaxComments) {
                            $TasksModel->update($this->Task->id, [
                                'task_finished'  =>  1
                            ]);
                            $StopComments = true;
                            break 2;
                        }

                        $CommentRecord = [];
                        foreach ($ScrapedFields as $FieldKey => $FieldType) {
                            $IsField = 'is'.$FieldKey;
                            $GetField = 'get'.$FieldKey;

                            if ($Comment->{$IsField}()) {
                                if ($FieldType == 'string') {
                                    $CommentRecord[$FieldKey] = utf8_encode($Comment->{$GetField}());
                                } else {
                                    $CommentRecord[$FieldKey] = $Comment->{$GetField}();
                                }
                            } else {
                                $CommentRecord[$FieldKey] = false;
                            }
                        }

                        $ScrapsModel->insert([
                            'task_id' => $this->Task->id,
                            'object_id' => $MediaId,
                            'object_value' => $Comment->getUser()->getUsername(),
                            'object_extra'  =>  serialize($CommentRecord),
                        ]);
                    }
                }

                if ($commentResponse->isNextMinId() && !$StopComments) {
                    $maxId = $commentResponse->getNextMinId();
                    $TasksModel->update($this->Task->id, [
                        'task_pagination'  =>  serialize($maxId)
                    ]);
                } else {
                    if ($DoneResults < $MaxComments) {
                        $TasksModel->update($this->Task->id, [
                            'task_max'  =>  $DoneResults
                        ]);
                    }
                    $StopComments = true;
                    $maxId = null;
                }
            } while($StopComments == false);
        } catch (\InstagramAPI\Exception\ChallengeRequiredException $e) {
            $AccountsModel = new AccountsModel();

            $AccountsModel->update([
                'account_status'    =>  1
            ]);
        } catch (\InstagramAPI\Exception\ThrottledException $e) {
            $AccountsModel = new AccountsModel();

            $CurrentTime = new \Datetime();
            $CurrentTime->modify('+24 hours');

            $AccountsModel->update($this->Account->id, [
                $this->Task->task_action  => $CurrentTime->format('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            // Do Nothing For Now
        }

        $this->data['Message'] = "Done";
        $this->data['Status'] = 1;
        return;
    }
    public function post_likes()
    {
        $TasksModel = new TasksModel();
        $ScrapsModel = new ScrapsModel();

        $ScrapsQueryBuilder = $this->QueryDb->table('scraps');

        helper('accounts');
        $MediaId = $this->Task->task_destination;

        try {
            $ig = new \InstagramAPI\Instagram();
            if(!empty($this->Account->account_proxy)) {
                $ig->setProxy($this->Account->account_proxy);
            }
            $login = $ig->login($this->Account->account_username, $this->Account->account_password);

            $DoneResults = $ScrapsQueryBuilder->where('task_id', $this->Task->id)->countAllResults();
            $MaxLikers = $this->Task->task_max;
            $lResponse = $ig->media->getLikers($MediaId);

            if ($lResponse->hasUsers()) {
                foreach ($lResponse->getUsers() as $User) {
                    if (!empty($ScrapsQueryBuilder->where('task_id', $this->Task->id)->where('object_id', $User->getPk())->countAllResults())) {
                        continue;
                    }

                    $DoneResults++;
                    if ($DoneResults > $MaxLikers) {
                        $TasksModel->update($this->Task->id, [
                            'task_finished' =>  1
                        ]);
                        break;
                    }

                    $ScrapsModel->insert([
                        'task_id'       => $this->Task->id,
                        'object_id'     => $User->getPk(),
                        'object_value'  => $User->getUsername(),
                    ]);
                }

                if ($DoneResults < $MaxLikers) {
                    $TasksModel->update($this->Task->id, [
                        'task_max' =>  $DoneResults
                    ]);
                }
            } else {
                $TasksModel->update($this->Task->id, [
                    'task_done' =>  1
                ]);
            }
        } catch (\InstagramAPI\Exception\ChallengeRequiredException $e) {
            $AccountsModel = new AccountsModel();

            $AccountsModel->update([
                'account_status'    =>  1
            ]);
        } catch (\InstagramAPI\Exception\ThrottledException $e) {
            $AccountsModel = new AccountsModel();

            $CurrentTime = new \Datetime();
            $CurrentTime->modify('+24 hours');

            $AccountsModel->update($this->Account->id, [
                $this->Task->task_action  => $CurrentTime->format('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            // Do Nothing For Now
        }

        $this->data['Message'] = "Done";
        $this->data['Status'] = 1;
        return;
    }

    // Misc Functions
    protected function checkParentTask($Task)
    {
        $TasksModel = new TasksModel();
        $TasksQueryBuilder = $this->QueryDb->table('tasks');

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
        }
    }
}