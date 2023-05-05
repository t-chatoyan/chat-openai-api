<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     *
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
           'id' => $this->id,
           'is_user' => $this->is_user,
           'chat_id' => $this->chat_id,
           'created_at' => Carbon::parse($this->created_at)->format('M d Y'),
           'customer_id' => $this->customer_id,
           'customer' => $this->customer,
           'message' => $this->message,
           'type' => $this->type,
        ];
    }
}
