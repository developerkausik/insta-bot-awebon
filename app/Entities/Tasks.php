<?php namespace App\Entities;

use CodeIgniter\Entity;

class Tasks extends Entity
{
    protected $task_parent;
    protected $task_name;
    protected $task_action;
    protected $task_fuids_queue;
    protected $task_fuids_done;
    protected $task_userid;
    protected $task_typeid;
    protected $task_typecat; 
    protected $task_type;
    protected $task_pagination;
    protected $task_message;
    protected $task_done;
    protected $task_finished;
    protected $task_stop;
    protected $task_failed;
    protected $task_failed_reason;
    protected $task_threads;
    protected $task_max;
    protected $task_processing;
    protected $task_scrap_elements;
    protected $task_destination;
    protected $to_delete;
    protected $processing;
    protected $created_at;
    protected $updated_at;
}
