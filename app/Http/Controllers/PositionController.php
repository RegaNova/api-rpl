<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Helpers\PaginateHelper;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;
use App\Interfaces\PositionInterface;
use App\Http\Requests\Position\PositionRequest;
use App\Resource\Position\PositionPaginateResource;
use App\Resource\Position\PositionResource;

class PositionController extends Controller
{
    protected PositionInterface $repository;

    public function __construct(PositionInterface $repository)
    {
        $this->repository = $repository;
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
                PositionPaginateResource::make($data, PaginateHelper::getPaginate($data)),
                trans('alert.fetch_data_success'),
                pagination: true
            );
        } catch (Exception $e) {
            return ResponseHelper::error(message: $e->getMessage());
        }
    }

    public function store(PositionRequest $request)
    {
        $payload = $request->validated();
        DB::beginTransaction();
        try {
            $data = $this->repository->store($payload);
            DB::commit();
            return ResponseHelper::success(new PositionResource($data), __('alert.add_success'));
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseHelper::error(message: __('alert.add_failed') . " => " . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $data = $this->repository->show($id);

            return ResponseHelper::success(new PositionResource($data), __('alert.fetch_data_success'));
        } catch (Exception $e) {
            return ResponseHelper::error(message: $e->getMessage());
        }
    }

    public function update(PositionRequest $request, string $id)
    {
        $payload = $request->validated();
        DB::beginTransaction();
        try {
            $data = $this->repository->update($id, $payload);
            return ResponseHelper::success(new PositionResource($data), __('alert.updat_success'));
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
