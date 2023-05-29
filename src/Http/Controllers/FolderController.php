<?php

namespace Dcodegroup\PageBuilder\Http\Controllers;

use Dcodegroup\PageBuilder\Http\Requests\FolderRequest;
use Dcodegroup\PageBuilder\Models\Folder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

class FolderController
{
    public function index(): JsonResponse
    {
        return response()->json([
            'folders' => Folder::query()
                ->with('attachments.media')
                ->get(),
        ]);
    }

    public function show(Folder $folder): JsonResponse
    {
        return response()->json([
            'folder' => $folder->loadMissing('attachments.media'),
        ]);
    }

    public function store(FolderRequest $request): JsonResponse
    {
        $folder = Folder::query()
            ->firstOrCreate($request->validated());

        return response()->json([
            'folder' => $folder,
        ]);
    }

    public function destroy(Folder $folder): JsonResponse
    {
        $folder->attachments()->delete();
        $folder->delete();

        return response()->json();
    }
}