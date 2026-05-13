<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'subject' => $this->subject,
            'body' => $this->body,
            'status' => $this->status,
            'replied_at' => $this->replied_at?->toISOString(),
            'created_at' => $this->created_at->toISOString(),
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'files' => $this->getMedia('attachments')->map(fn ($media) => [
                'name' => $media->file_name,
                'url' => $media->getUrl(),
                'size' => $media->size,
            ]),
        ];
    }
}
