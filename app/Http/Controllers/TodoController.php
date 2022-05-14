<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Interfaces\TodoRepositoryInterface;
use App\Http\Resources\TodoResource;
use App\Http\Requests\TodoRequest;
use App\Interfaces\AssignerRepositoryInterface;
use Carbon\Carbon;

class TodoController extends Controller
{
    private TodoRepositoryInterface $todoRepository;

    public function __construct(TodoRepositoryInterface $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        return response()->json([
            "message" => "ok",
            "data" => new TodoResource($this->todoRepository->getAllTodos())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TodoRequest $request, AssignerRepositoryInterface $assignerRepository): JsonResponse
    {
        try {
            // store 前即檢查
            $storeData = $request->only([
                'content',
                'assigner_id',
                'deadline',
                'working_hours',
                'assign_method'
            ]);
            // automatic, random 幫其填上 assigner_id
            if ($storeData['assign_method'] === 'automatic') {
                $effortlessAssigner = $assignerRepository->getMinWorkloadAssigner()->toArray();
                $storeData['assigner_id'] = $effortlessAssigner['id'];
            } elseif ($storeData['assign_method'] === 'random') {
                $activeAssigners = $assignerRepository->getAllActiveAssigners()->toArray();
                $assignerIds = array_column($activeAssigners, 'id');
                $chosen_index = rand(0, count($assignerIds) - 1);
                $storeData['assigner_id'] = $assignerIds[$chosen_index];
            }
            unset($storeData['assign_method']);
            if (empty($storeData['assigner_id'])) {
                throw new \Exception('Plz choose an assigner!');
            }
            $todo = $this->todoRepository->createTodo($storeData);
            if (is_null($todo)) {
                throw new \Exception('Can not store todo data.');
            }
        } catch (\Exception $e) {
            throw new \Exception('Call GET api/todo/ with something wrong.');
        }

        return response()->json([
            "message" => "ok",
            "data" => new TodoResource($todo)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!is_numeric($id)) {
            throw new \Exception('input id is not numeric');
        }

        $todo = $this->todoRepository->getTodoById($id);
        if (is_null($todo)) {
            throw new \Exception('Can not get todo data.');
        }

        return response()->json([
            "message" => "ok",
            "data" => new TodoResource($todo)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TodoRequest $request, $id)
    {
        // update 前即檢查
        $updateData = $request->only([
            'content',
            'assigner_id',
            'working_hours',
            'deadline',
            'is_completed',
            'is_deleted',
            'completed_at',
            'deleted_at',
        ]);
        $now = Carbon::now();
        if (!$updateData['is_completed']) {
            $updateData['completed_at'] = null;
        }
        if (!$updateData['is_deleted']) {
            $updateData['deleted_at'] = null;
        }
        if ($updateData['is_completed'] && is_null($updateData['completed_at'])) {
            $update_data['completed_at'] = $now;
        }
        if ($updateData['is_deleted'] && is_null($updateData['deleted_at'])) {
            $updateData['deleted_at'] = $now;
        }
        $updateData['updated_at'] = $now;
        $result = $this->todoRepository->updateTodo($id, $updateData);
        if (!$result) {
            throw new \Exception('Can not update todo data.');
        }
        $todo = $this->todoRepository->getTodoById($id);
        return response()->json([
            "message" => "ok",
            "data" => new TodoResource($todo)
        ]);
    }
}
