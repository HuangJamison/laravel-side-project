<?php
namespace App\Repositories;

use App\Interfaces\AssignerRepositoryInterface;
use App\Models\Assigner;

class AssignerRepository implements AssignerRepositoryInterface
{
    public function getAllAssigners()
    {
        return Assigner::all();
    }

    public function getAllActiveAssigners()
    {
        return Assigner::where('is_deleted', 0)->get();
    }

    public function getAssignerById($assignerId)
    {
        return Assigner::findOrFail($assignerId);
    }

    public function createAssigner($assigner)
    {
        return Assigner::create($assigner);
    }

    public function updateAssigner($assignerId, $assigner)
    {
        return Assigner::whereId($assignerId)->update($assigner);
    }
}