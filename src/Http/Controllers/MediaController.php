<?php

namespace Dcodegroup\PageBuilder\Http\Controllers;

use Dcodegroup\PageBuilder\Http\Requests\MediaUploadRequest;
use Dcodegroup\PageBuilder\Models\Attachment;
use Dcodegroup\PageBuilder\Models\Media;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class MediaController
{
    use AuthorizesRequests;

    public function index(Request $request): JsonResponse
    {
        $mediaQuery = Media::query()
            ->isAttachment()
            ->when(! empty($request->input('search')), fn (Builder $builder) => $builder->name($request->input('search')))
            ->when(! empty($request->input('size')) && $request->input('size') > 0, fn (Builder $builder) => $builder->smallerThan($request->input('size')))
            ->when(! empty($request->input('type')), fn (Builder $builder) => $builder->type($request->input('type')))
            ->when(! empty($request->input('folder_id')), fn (Builder $builder) => $builder->hasFolder($request->input('folder_id')));

        $media = $mediaQuery->get();

        return response()->json([
            'media' => $media->toArray(),
        ]);
    }

    public function get(Request $request, Media $media)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'media' => $media,
            ]);
        } else {
            return response()->make(
                Storage::disk($media->disk)->get($media->getPath()),
                200,
                ['Content-Type' => $media->mime_type]
            );
        }
    }

    public function upload(MediaUploadRequest $request): JsonResponse
    {
        if (! $request->hasFile('file')) {
            return response()->json([
                'message' => 'Upload failed!',
                'status' => Response::HTTP_EXPECTATION_FAILED,
            ], Response::HTTP_EXPECTATION_FAILED);
        }

        $file = $request->file('file');

        $model = Attachment::query()->create([
            'folder_id' => $request->input('folder_id'),
        ]);

        $media = $model->addMediaFromRequest('file')
            ->usingFileName($file->hashName())
            ->withCustomProperties([
                'original_filename' => $file->getClientOriginalName(),
                'encoding_format' => $file->extension(),
            ])
            ->toMediaCollection();

        return response()->json([
            'message' => 'Successful upload!',
            'model' => $model,
            'media' => $media,
            'url' => $media->url,
            'thumb_url' => $media->thumb_url,
            'grid_url' => $media->grid_url,
            'status' => Response::HTTP_CREATED,
        ], Response::HTTP_CREATED);
    }
}
