<?php

namespace App\Repositories;

use App\Interfaces\AssignerRepositoryInterface;
use App\Models\Assigner;
use Illuminate\Support\Facades\DB;

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

    public function getMinWorkloadAssigner()
    {
        $effortless_assigner = Assigner::withCount(['todos as assigner_total_working_hours' => function ($query) {
            $query->select(DB::raw('sum(todos.working_hours)'));
        }])->where('is_deleted', 0)->orderBy('assigner_total_working_hours', 'asc')->first();
        return $effortless_assigner;
    }
}
