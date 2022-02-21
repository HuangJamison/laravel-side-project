<?php
namespace App\Interfaces;

interface TodoRepositoryInterface
{
    public function get_all_todos();
    public function get_todo_by_id($todo_id);
    public function create_todo(array $todo);
    public function update_todo($todo_id, array $todo);
}