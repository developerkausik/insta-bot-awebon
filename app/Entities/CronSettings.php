<?php namespace App\Entities;

use CodeIgniter\Entity;

class CronSettings extends Entity
{
    protected $cron_name;
    protected $cron_value;
    protected $cron_type;
}