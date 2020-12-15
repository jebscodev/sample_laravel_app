<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreUser;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::collection(User::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
        $payload = $request->json()->all();
        $payload['password'] = bcrypt($request->password);
        $user = new User($payload);

        // $user->user_lock_count = 0;
        // $user->user_is_blocked = 0;

        $user->created_by = $this->loggedInUser()->id;
        $user->updated_by = $this->loggedInUser()->id;

        $user->save();
        return new UserResource(User::findOrFail($user->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // not needed for now
        // Validator::make($request, [
        //     'email' => [
        //         'required',
        //         Rule::unique('users')->ignore($this->user),
        //     ],
        // ]);

        $payload = $request->json()->all();
        $user = User::findOrFail($id);

        $user->updated_by = $this->loggedInUser()->id;
        $user->updated_date = $this->getCurDate();

        foreach ($payload as $field => $value) {
            $user->$field = $value;
        }

        $user->save();
        return new UserResource(User::findOrFail($user->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return $this->sendResponse([
            "message" => "Record deleted successfully."
        ]);
    }

    /**
     * Remove a number of resources from storage.
     *
     * @param  array  $ids
     * @return \Illuminate\Http\Response
     */
    public function destroyMany(Request $request)
    {
        User::whereIn('id', $request->ids)->delete();
        return $this->sendResponse([
            "message" => "Records are deleted successfully."
        ]);
    }
}
