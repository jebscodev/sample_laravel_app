<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\InnolandUser;

class InnolandEmployee extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $innoland_user = InnolandUser::where('employee_id', $this->id)->first();

        return [
            'id' => $this->user_id,
            'name' => $this->fname.' '.$this->lname,
            'username' => $innoland_user->username
        ];
    }
}
