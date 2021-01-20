<?php

namespace App\Http\Resources;

use App\Models\UserWin;
use Illuminate\Http\Resources\Json\JsonResource;

class UserWinResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'status'        => $this->status,
            'statusName'    => UserWin::getStatusName($this->status),
            'type'          => $this->type,
            'userBalance'   => $this->user->balance
        ];
    }
}
