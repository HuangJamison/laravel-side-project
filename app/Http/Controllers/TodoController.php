<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Interfaces\TodoRepositoryInterface;
use App\Http\Resources\TodoResource;
use App\Http\Requests\TodoRequest;
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
            "data" => new TodoResource($this->todoRepository->get_all_todos())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TodoRequest $request): JsonResponse
    {
        // store 前即檢查
        $store_data = $request->only([
            'content',
            'assigner',
            'deadline'
        ]);
        $todo = $this->todoRepository->create_todo($store_data);

        if (is_null($todo)) {
            throw new \Exception('Can not store todo data.');
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

        $todo = $this->todoRepository->get_todo_by_id($id);
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
        $update_data = $request->only([
            'content',
            'assigner',
            'deadline',
            'is_completed',
            'is_deleted',
            'completed_at',
            'deleted_at',
        ]);
        $now = Carbon::now();
        if (!$update_data['is_completed']) {
            $update_data['completed_at'] = null;
        }
        if (!$update_data['is_deleted']) {
            $update_data['deleted_at'] = null;
        }
        if ($update_data['is_completed'] && is_null($update_data['completed_at'])) {
            $update_data['completed_at'] = $now;
        }
        if ($update_data['is_deleted'] && is_null($update_data['deleted_at'])) {
            $update_data['deleted_at'] = $now;
        }
        $update_data['updated_at'] = $now;
        $result = $this->todoRepository->update_todo($id, $update_data);
        if (!$result) {
            throw new \Exception('Can not update todo data.');
        }
        $todo = $this->todoRepository->get_todo_by_id($id);
        return response()->json([
            "message" => "ok",
            "data" => new TodoResource($todo)
        ]);
    }
}
