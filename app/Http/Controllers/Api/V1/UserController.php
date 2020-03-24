<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data  = $request->all();
        $token = Str::random(80);
        return User::forceCreate([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'api_token' => Hash::make($token),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /** @var User $photo */
        $user = User::findOrFail($id);
        $user->update($request->all());
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var User $photo */
        $user = User::findOrFail($id);
        return $user->delete();
    }

    public function login(Request $request)
    {
        $status   = 401;
        $response = ['error' => 'Not valid username or password'];

        if (Auth::attempt($request->only(['email', 'password']))) {
            $status   = 200;
            $response = [
                'user'  => Auth::user(),
                'token' => Auth::user()->createToken('likes')->accessToken,
            ];
        }

        return response()->json($response, $status);
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name'     => 'required|max:50',
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['is_admin'] = 0;
        //В целях теста
        if ($request->get('is_admin'))
            $validatedData['is_admin'] = 1;
        $user = User::create($validatedData);


        return response()->json([
            'user'  => $user,
            'token' => $user->createToken('likes')->accessToken,
        ]);
    }
}
