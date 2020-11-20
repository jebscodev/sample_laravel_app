<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Role as RoleResource;
use App\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $created_by = DB::table('users as a')
            ->select(['a.first_name', 'a.last_name'])
            ->leftJoin('users as b','b.created_by', '=', 'a.id')
            ->where('a.id', $this->created_by)
            ->first();

        $updated_by = DB::table('users as a')
            ->select(['a.first_name', 'a.last_name'])
            ->leftJoin('users as b','b.updated_by', '=', 'a.id')
            ->where('a.id', $this->updated_by)
            ->first();

        return [
            'id' => $this->id,
            'name' => $this->first_name.' '.$this->last_name,
            'email_address' => $this->email_address,
            'username' => $this->username,
            'role' => new RoleResource(Role::find($this->role_id)),
            'status' => $this->status ? 'Active' : 'Inactive',
            'created_by' => $created_by->first_name.' '.$created_by->last_name,
            'updated_by' => $updated_by->first_name.' '.$updated_by->last_name,
            'created_date' => Carbon::parse($this->created_date)->toDateTimeString(),
            'updated_date' => Carbon::parse($this->updated_date)->toDateTimeString()
        ];
    }
}
