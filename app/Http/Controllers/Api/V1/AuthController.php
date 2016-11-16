<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\User;
use Illuminate\Http\Request;
use Validator;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

use JWTAuth;
use Mockery\CountValidator\Exception;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends ApiController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Response
     */

    public function SignUp(Request $request){
        try{
            $input = $request->only(['name','email','password','password_confirmation']);

            //validate inputs

            $validator = Validator::make($input, [
                'email' => 'required|email|unique:users|max:255',
                'name' => 'required|max:255',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->setStatusCode(422)->respondWithError($validator->messages());
            } else {
                

                $name = Input::get('name');
                $email = Input::get('email');
                $password = Input::get('password');
                $password = bcrypt($password);
                User::create(['name'=>$name,'email'=>$email,'password'=>$password]);

                return $this->authenticate($request);
            }

        }catch(Exception $e){
            return $this->setStatusCode(500)->respondWithError($e->messages());
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return $this->setStatusCode(500)->respondWithError('could_not_create_token');
        }

        // if no errors are encountered we can return a JWT
        return response()->json(compact('token'));
    }
}
