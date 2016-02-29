<?php

namespace App\Acme\Transformers;

class TaskTransformer extends Transformer
{
    public function transform($task)
    {
        return [
            'name' => $task['name'],
            'Learn Laravel' => (boolean)$task['done'],
            'priority' => $task['priority'],
        ];
    }
}
