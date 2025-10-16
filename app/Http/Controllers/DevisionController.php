<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Helpers\PaginateHelper;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;
use App\Interfaces\DevisionInterface;
use App\Http\Requests\Devision\DevisionRequest;
use App\Resource\Devision\DevisionPaginateResource;
use App\Resource\Devision\DevisionResource;

class DevisionController extends Controller
{
    protected DevisionInterface $repository;

    public function __construct(DevisionInterface $repository)
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
                DevisionPaginateResource::make($data, PaginateHelper::getPaginate($data)),
                trans('alert.fetch_data_success'),
                pagination: true
            );
        } catch (Exception $e) {
            return ResponseHelper::error(message: $e->getMessage());
        }
    }

    public function store(DevisionRequest $request)
    {
        $payload = $request->validated();
        DB::beginTransaction();
        try {
            $data = $this->repository->store($payload);
            DB::commit();
            return ResponseHelper::success(new DevisionResource($data), __('alert.add_success'));
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseHelper::error(message: __('alert.add_failed') . " => " . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $data = $this->repository->show($id);

            return ResponseHelper::success(new DevisionResource($data), __('alert.fetch_data_success'));
        } catch (Exception $e) {
            return ResponseHelper::error(message: $e->getMessage());
        }
    }

    public function update(DevisionRequest $request, string $id)
    {
        $payload = $request->validated();
        DB::beginTransaction();
        try {
            $data = $this->repository->update($id, $payload);
            return ResponseHelper::success(new DevisionResource($data), __('alert.updat_success'));
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
