<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use App\Http\Resources\User as UserResource;

class AuthController extends BaseController
{
	/**
	 * Login user and create token
	 *
	 * @param  [string] email
	 * @param  [string] password
	 * @param  [boolean] remember_me
	 * @return [string] access_token
	 * @return [string] token_type
	 * @return [string] expires_at
	 */
	public function login(Request $request)
	{
		$request->validate([
			'username' => 'required|string',
			'password' => 'required|string',
			'remember_me' => 'boolean'
		]);

		$credentials = request(['username', 'password']);

		if (!Auth::attempt($credentials)) {
			return $this->sendError(['error' => 'Unauthorized.'], 401);
		}

		$user = $request->user();
		$tokenResult = $user->createToken('Personal Access Token');
		$token = $tokenResult->token;

		if ($request->remember_me)
			$token->expires_at = Carbon::now()->addWeeks(1);

		$token->save();

		$result = [
			'access_token' => $tokenResult->accessToken,
			'token_type' => 'Bearer',
			'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
			'id' => $user->id,
			'name' => $user->first_name . ' ' . $user->last_name,
			'username' => $user->username,
			'success' => true
		];

		return $this->sendResponse($result);
	}

	/**
	 * Logout user (Revoke the token)
	 *
	 * @return [string] message
	 */
	public function logout(Request $request)
	{
		$request->user()->token()->revoke();
		return $this->sendResponse([
			'message' => 'Successfully logged out.'
		]);
	}
}
