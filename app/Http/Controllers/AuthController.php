<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Arr;

class AuthController extends Controller
{
    public function register(Request $request) {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = auth()->login($user);
        
        return $this->respondWithToken($token);
    }

    public function login(Request $request) {

        $credentials = $request->only(['email','password']);

        if(!$token = auth()->attempt($credentials)) {
            return response()->json(['status' => 'false', 'message' => 'Unauthorized'], 401);
        }
        
        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    //find current user
    public function getAuthUser(Request $request)
    {
        return response()->json(auth()->user());
    }
    
    //logout
    public function logout()
    {
        auth()->logout();
        return response()->json(['status' => true, 'message' => 'Successfully logged out'], 200);
    }

    public function test() {

         //create 10 users
         $user = factory(User::class,10)->create();
         return $id_arr = Arr::pluck($user , 'id'); // get user id array
         $shuffle_id = Arr::shuffle($id_arr);
         for($i=0; $i<3; $i++) {
            echo $user_id = $shuffle_id[$i]; echo "<br>";
         }

         exit();
         // create 2 book for each user
         $user->each(function ($user) {
             $book = $user->books()->saveMany(factory(App\Book::class,2)->make());
             
             $book->each(function ($book) {
                 for($i=0; $i<3; $i++) {
                     $user_id = $shuffle_id[$i]; // get id of first 3 of suffle_id array
                     $book->ratings()->saveMany(factory(App\Rating::class,3)->make(['user_id' => $user_id]));
                 }
             });
 
         });
    }
}
