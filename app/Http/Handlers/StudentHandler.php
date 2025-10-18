<?php

namespace App\Http\Handlers;

use App\Helpers\FileHelper;
use App\Interfaces\StudentInterface;

class StudentHandler
{
    protected StudentInterface $repository;

    public function __construct(StudentInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handleStore(array $data, $request)
    {
        if ($request->hasFile('image')) {
            $path = FileHelper::uploadImage($request->file('image'), 'generation');
            $data['image'] = $path;
        }

        return $this->repository->store($data);
    }

    /**
     * Handle update
     */
    public function handleUpdate(array $data, $request, $id)
    {
        $old = $this->repository->show($id);

        if ($request->hasFile('image')) {
            // Hapus file lama jika ada
            if (!empty($old->image)) {
                FileHelper::deleteFile($old->image);
            }

            // Upload file baru
            $path = FileHelper::uploadImage($request->file('image'), 'generation');
            $data['image'] = $path;
        }

        $this->repository->update($id, $data);
        return $old->refresh();
    }

    /**
     * Handle delete
     */
    public function handleDelete($id)
    {
        $old = $this->repository->show($id);

        if (!empty($old->image)) {
            FileHelper::deleteFile($old->image);
        }

        return $this->repository->delete($id);
    }
}
