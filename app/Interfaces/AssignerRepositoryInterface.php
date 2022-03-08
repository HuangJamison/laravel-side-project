<?php
namespace App\Interfaces;

interface AssignerRepositoryInterface
{
    public function getAllAssigners();
    public function getAllActiveAssigners();
    public function getAssignerById(int $assignerId);
    public function createAssigner(array $assigner);
    public function updateAssigner(int $assignerId, array $assigner);
}