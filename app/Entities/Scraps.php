<?php namespace App\Entities;

use CodeIgniter\Entity;

class Scraps extends Entity
{
    protected $task_id;
    protected $object_id;
    protected $object_value;
    protected $object_extra;
    protected $object_processed;
    protected $object_processing;
    protected $created_at;
    protected $updated_at;
}