<?php
namespace App\Models;

class Task
{
    function __construct($description, $task_owner) {
        $this->desc = $description;
        $this->owner = $task_owner;
        $this->done = false;
    }
}