<?php
namespace App\Repositories;

use App\Interfaces\TodoRepositoryInterface;
use App\Models\Todo;

class TodoRepository implements TodoRepositoryInterface
{
    public function get_all_todos()
    {
        return Todo::all();
    }

    public function get_todo_by_id($todoId)
    {
        return Todo::findOrFail($todoId);
    }

    public function create_todo($todo)
    {
        return Todo::create($todo);
    }

    public function update_todo($todo_id, $todo)
    {
        return Todo::whereId($todo_id)->update($todo);
    }
}