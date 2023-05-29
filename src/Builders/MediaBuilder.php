<?php

namespace Dcodegroup\PageBuilder\Builders;

use Dcodegroup\PageBuilder\Models\Attachment;
use Illuminate\Database\Eloquent\Builder;

class MediaBuilder extends Builder
{
    public function isAttachment(): self
    {
        return $this->whereHasMorph('model', Attachment::class);
    }

    public function name(string $name): self
    {
        return $this->where("name", "LIKE", "%$name%");
    }

    public function smallerThan(int $size): self
    {
        return $this->where('size', '<=', $size);
    }

    public function biggerThan(int $size): self
    {
        return $this->where('size', '>=', $size);
    }

    public function type(string $type): self
    {
        return $this->where('mime_type', '=', $type);
    }

    public function hasFolder(int $folderId): self
    {
        return $this->whereHasMorph('model', Attachment::class, function(Builder $builder, $type) use ($folderId) {
            $builder->where('folder_id', $folderId);
        });
    }
}