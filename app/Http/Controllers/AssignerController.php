<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Interfaces\AssignerRepositoryInterface;
use App\Http\Resources\AssignerResource;
use App\Http\Requests\AssignerRequest;
use Carbon\Carbon;

class AssignerController extends Controller
{
    private AssignerRepositoryInterface $assignerRepository;
    public function __construct(AssignerRepositoryInterface $assignerRepository)
    {
        $this->assignerRepository = $assignerRepository;
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
            "data" => new AssignerResource($this->assignerRepository->getAllAssigners())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssignerRequest $request): JsonResponse
    {
        // store 前即檢查
        $storeData = $request->only([
            'name',
        ]);
        $assigner = $this->assignerRepository->createAssigner($storeData);

        if (is_null($assigner)) {
            throw new \Exception('Can not store assigner data.');
        }
        
        return response()->json([
            "message" => "ok",
            "data" => new AssignerResource($assigner)
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

        $assigner = $this->assignerRepository->getAssignerById($id);
        if (is_null($assigner)) {
            throw new \Exception('Can not get assigner data.');
        }

        return response()->json([
            "message" => "ok",
            "data" => new AssignerResource($assigner)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AssignerRequest $request, $id)
    {
        // update 前即檢查
        $updateData = $request->only([
            'name',
            'assigner',
            'is_deleted',
            'deleted_at',
        ]);
        $now = Carbon::now();
        if (!$updateData['is_deleted']) {
            $updateData['deleted_at'] = null;
        }
        if ($updateData['is_deleted'] && is_null($updateData['deleted_at'])) {
            $updateData['deleted_at'] = $now;
        }
        $updateData['updated_at'] = $now;
        $result = $this->assignerRepository->updateAssigner($id, $updateData);
        if (!$result) {
            throw new \Exception('Can not update assigner data.');
        }
        $assigner = $this->assignerRepository->getAssignerById($id);
        return response()->json([
            "message" => "ok",
            "data" => new AssignerResource($assigner)
        ]);
    }

    /**
     * get activeAssigners
     *
     * @return \Illuminate\Http\Response
     */
    public function activeAssigners()
    {
        return response()->json([
            "message" => "ok",
            "data" => new AssignerResource($this->assignerRepository->getAllActiveAssigners())
        ]);
    }
}
