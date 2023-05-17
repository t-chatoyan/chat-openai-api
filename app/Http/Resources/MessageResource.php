<?php

namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

/**
 * @property mixed id
 * @property mixed is_user
 * @property mixed chat_id
 * @property mixed created_at
 * @property mixed customer_id
 * @property mixed customer
 * @property mixed message
 * @property mixed type
 */
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
//           'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
           'created_at' => $this->created_at,
           'customer_id' => $this->customer_id,
           'customer' => $this->customer,
           'message' => $this->message,
           'type' => $this->type,
        ];
    }
}
