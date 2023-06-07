<?php

namespace Dcodegroup\PageBuilder\Http\Controllers;

use Dcodegroup\PageBuilder\Http\Requests\FolderRequest;
use Dcodegroup\PageBuilder\Models\Folder;
use Illuminate\Http\JsonResponse;

class FolderController
{
    public function index(): JsonResponse
    {
        return response()->json([
            'folders' => Folder::query()
                ->whereNull('parent_id')
                ->with(['attachments.media', 'children'])
                ->get(),
        ]);
    }

    public function show(Folder $folder): JsonResponse
    {
        return response()->json([
            'folder' => $folder->loadMissing(['attachments.media', 'children']),
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
