<?php

namespace Dcodegroup\PageBuilder\Http\Controllers\Media;

use Dcodegroup\PageBuilder\Http\Requests\UploadRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UploadController
{
    use AuthorizesRequests;

    public function __invoke(UploadRequest $request): JsonResponse
    {
        if (! $request->hasFile('file')) {
            return response()->json([
                'message' => __('attachments::media.status.upload_failed'),
                'status' => Response::HTTP_EXPECTATION_FAILED,
            ], Response::HTTP_EXPECTATION_FAILED);
        }

        $file = $request->file('file');
        $modelClass = $request->input('modelClass');
        $modelId = $request->input('modelId');
        $model = $modelClass::findOrFail($modelId);

        $media = $model->addMediaFromRequest('file')
            ->usingFileName($file->hashName())
            ->withCustomProperties([
                'original_filename' => $file->getClientOriginalName(),
                'encoding_format' => $file->extension(),
            ])
            ->toMediaCollection($request->input('field'));

        return response()->json([
            'message' => __('attachments::media.status.upload_success'),
            'model' => $model,
            'media' => $media,
            'url' => $media->url,
            'thumb_url' => $media->thumb_url,
            'grid_url' => $media->grid_url,
            'status' => Response::HTTP_CREATED,
        ], Response::HTTP_CREATED);
    }
}
