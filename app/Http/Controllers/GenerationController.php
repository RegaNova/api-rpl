<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Helpers\PaginateHelper;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;
use App\Interfaces\GenerationInterface;
use App\Http\Handlers\GenerationHandler;
use App\Resource\Generation\GenerationResource;
use App\Http\Requests\Generation\GenerationRequest;
use App\Resource\Generation\GenerationPaginateResource;

class GenerationController extends Controller
{
    protected GenerationInterface $repository;
    protected GenerationHandler $handler;

    public function __construct(
        GenerationInterface $repository,
        GenerationHandler $handler
    ) {
        $this->repository = $repository;
        $this->handler = $handler;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $filters = $request->only([
            'sort_by',
            'sort_dir',
            'search',
            'date_from',
            'date_to'
        ]);
        try {
            $data = $this->repository->getWithFilters($filters, $perPage);

            return ResponseHelper::success(
                GenerationPaginateResource::make($data, PaginateHelper::getPaginate($data)),
                trans('alert.fetch_data_success'),
                pagination: true
            );
        } catch (Exception $e) {
            return ResponseHelper::error(message: $e->getMessage());
        }
    }

    public function store(GenerationRequest $request)
    {
        $payload = $request->validated();
        DB::beginTransaction();
        try {
            $data = $this->handler->handleStore($payload, $request);
            DB::commit();
            return ResponseHelper::success(new GenerationResource($data), __('alert.add_success'));
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseHelper::error(message: __('alert.add_failed') . " => " . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $data = $this->repository->show($id);

            return ResponseHelper::success(new GenerationResource($data), __('alert.fetch_data_success'));
        } catch (Exception $e) {
            return ResponseHelper::error(message: $e->getMessage());
        }
    }

    public function update(GenerationRequest $request, string $id)
    {
        $payload = $request->validated();
        DB::beginTransaction();
        try {
            $data = $this->handler->handleUpdate($payload, $request,$id);
            return ResponseHelper::success(new GenerationResource($data), __('alert.updat_success'));
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseHelper::error(message: __('alert.update_failed') . " => " . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $this->repository->delete($id);
            DB::commit();
            return responseHelper::success(message: __('alert.delete_success'));
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseHelper::error(message: __('alert.delete_failed') . " => " . $e->getMessage());
        }
    }
}
