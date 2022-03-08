<?php
namespace App\Interfaces;

interface TodoRepositoryInterface
{
    public function getAllTodos();
    public function getTodoById($todoId);
    public function createTodo(array $todo);
    public function updateTodo($todoId, array $todo);
}