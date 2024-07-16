<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    //Register user
    public function register(Request $request)
    {
        //validate fields
        $attrs = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);


        //create user
        $user = User::create([
            'name' => $attrs['name'],
            'email' => $attrs['email'],
            'password' => bcrypt($attrs['password'])
        ]);

        //return user & token in response
        return response([
            'user' => $user,
            'token' => $user->createToken('secret')->plainTextToken
        ], 200);
    }

    public function usa()
    {
        $currentUser = Auth::user();

        $users = User::where('id', '!=', $currentUser->id)->get();

        return response()->json([
            'users' => $users
        ], 200);
    }

    // login user
    public function login(Request $request)
    {
        //validate fields
        $attrs = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // attempt login
        if (!Auth::attempt($attrs)) {
            return response([
                'message' => 'Invalid credentials.'
            ], 403);
        }

        //return user & token in response
        return response([
            'user' => auth()->user(),
            'token' => auth()->user()->createToken('secret')->plainTextToken
        ], 200);
    }

    // logout user
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response([
            'message' => 'Logout success.'
        ], 200);
    }

    // get user details
    public function user()
    {
        return response([
            'user' => auth()->user()
        ], 200);
    }

    // update user
    public function update(Request $request)
    {
        $attrs = $request->validate([
            'name' => 'required|string'
        ]);

        $image = $this->saveImage($request->image, 'profiles');

        auth()->user()->update([
            'name' => $attrs['name'],
            'image' => $image
        ]);

        return response([
            'message' => 'User updated.',
            'user' => auth()->user()
        ], 200);
    }


    //pendiente
    public function updateus(Request $request, $id)
    {
        if($request->id == 0){
            $user = new User();
        }
        else {  
            $user = User::find($request->id);
        }
        try {
            //$user = new user();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->user_id = Auth::user()->id;
            //if($request->file('foto')!=null){
            $user->image = $request->file('image')->store('profiles', 'public');
            //}
            $user->save();
            return $user;
        } catch (Exception $e) {
            Log::debug('Metodo INSERT clase userCONTROLLER->' . $e->getMessage());
        }
    }

    public function userid(Request $request){
        //Segundo Try-Catch
        try{
            $user = Auth::find($request->id);
            return $user;
        }catch(Exception $e){
            Log::error('Metodo user clase UserController->' .$e->getMessage());
        
        }

    }

    //editar perfil de usuario
    public function updateProfile(Request $request, $id)
    {
        try {
            $user = Auth::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            //Valida si existe una modificación de la imagen, sino no realizara modificación ni eliminación de imagen anterior
            if ($request->file('image') != null) {
                /*A continuación, deberás validar el correcto funcionamiento de la eliminación de la imagen anterior
                , la vez anterior no funciono por la ruta relativa que nos arroja*/
                Storage::disk('public')->delete($user->image);
                /**/
                $user->image = $request->file('image')->store('profile', 'public');
            }
            $user->save();
        } catch (Exception $e) {
            Log::debug('Metodo UPDATE clase userCONTROLLER->' . $e->getMessage());
        }
    }

    public function usuario(Request $request){
        //Segundo Try-Catch
        try{
            $user = Auth::find($request->id);
            return $user;
        }catch(Exception $e){
            Log::error('Metodo show clase AuthController->' .$e->getMessage());
        
        }

    }


    //ver usuario iniciado
    public function getUser()
    {
        $user = Auth::user();

        return response()->json([
            'users' => $user
        ], 200);
    }


    public function regus(Request $request)
    {
        //validate fields
        $attrs = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        $imagePath = $request->file('image')->store('profiles', 'public');
        //create user
        $user = User::create([
            'name' => $attrs['name'],
            'email' => $attrs['email'],
            'password' => bcrypt($attrs['password']),
            'image' => $imagePath
        ]);

        //return user & token in response
        return response([
            'user' => $user,
            'token' => $user->createToken('secret')->plainTextToken
        ], 200);
    }
}
