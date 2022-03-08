<?php
namespace App\Repositories;

use App\Interfaces\TodoRepositoryInterface;
use App\Models\Todo;

class TodoRepository implements TodoRepositoryInterface
{
    public function getAllTodos()
    {
        return Todo::all();
    }

    public function getTodoById($todoId)
    {
        return Todo::findOrFail($todoId);
    }

    public function createTodo(array $todo)
    {
        return Todo::create($todo);
    }

    public function updateTodo($todoId, array $todo)
    {
        return Todo::whereId($todoId)->update($todo);
    }
}