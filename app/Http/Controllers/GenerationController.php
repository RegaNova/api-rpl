<?php

namespace App\Http\Controllers;

use App\Models\generation;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\GenerationRequest;
use App\Repositories\GenerationInterface;

class GenerationController extends Controller
{
    private GenerationInterface $generationRepository;
    public function __construct(
        GenerationInterface $generationRepository
    ) {
        $this->generationRepository = $generationRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $generations = $this->generationRepository->get();

            return ResponseHelper::success(
                data: $generations,
                message: trans('alert.success_fetching'),
                code: 200
            );
        } catch (\Exception $e) {
            return ResponseHelper::error(
                message: trans('alert.error' . ' : ' . $e->getMessage()),
                code: 400
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GenerationRequest $request)
    {
        $validation = $request->validated();
        DB::beginTransaction();
        try {
            $generation = $this->generationRepository->store($validation);
            DB::commit();
            return ResponseHelper::success(
                data: $generation,
                message: trans('alert.success_fetching' . ' : Generasi berhasil ditambahkan'),
                code: 201
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::error(
                message: trans('alert.error' . ' : ' . $e->getMessage()),
                code: 400
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $generation = $this->generationRepository->show($id);

            return ResponseHelper::success(
                data: $generation,
                message: trans('alert.success_fetching' . ' : Berhasil mengambil data generasi'),
                code: 200
            );
        } catch (\Exception $e) {
            return ResponseHelper::error(
                message: trans('alert.error' . ' : ' . $e->getMessage()),
                code: 400
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(generation $generation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GenerationRequest $request, string $id)
    {
        $validation = $request->validated();
        DB::beginTransaction();
        try {
            $generation = $this->generationRepository->update($id, $validation);
            DB::commit();
            return ResponseHelper::success(
                data: $generation,
                message: trans('alert.success_fetching' . ' : Generasi berhasil diubah'),
                code: 200
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::error(
                message: trans('alert.error' . ' : ' . $e->getMessage()),
                code: 400
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $this->generationRepository->delete($id);
            DB::commit();
            return ResponseHelper::success(
                message: trans('alert.success_fetching' . ' : Generasi berhasil dihapus'),
                code: 200
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::error(
                message: trans('alert.error' . ' : ' . $e->getMessage()),
                code: 400
            );
        }
    }
}
