<?php

namespace App\Http\Controllers;

use App\Models\Descrip;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DescripController extends Controller
{
    public function index()
    {
        $posts = Descrip::orderBy('created_at', 'desc')
            ->with('user:id,name')
            ->get();

        return response()->json(['descrips' => $posts], 200);
    }

    public function create(Request $request)
    {
        if ($request->id == 0) {
            $desc = new Descrip();
        } else {
            $desc = Descrip::find($request->id);
        }
        try {
            $desc->drescription = $request->drescription;
            $desc->intereses = $request->intereses;
            $desc->user_id = Auth::user()->id;

            $desc->save();
            return $desc;
        } catch (Exception $e) {
            Log::debug('Metodo INSERT clase DESCRIPCONTROLLER->' . $e->getMessage());
        }
    }

    public function desc(Request $request)
    {
        //Segundo Try-Catch
        try {
            $desc = Descrip::find($request->id);
            return $desc;
        } catch (Exception $e) {
            Log::error('Metodo show clase DESCRIPController->' . $e->getMessage());
        }
    }



    public function showInfoByUser($id)
    {
        $user = User::find($id);

        // Check if user exists
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Retrieve descriptions associated with the user
        $descrips = Descrip::where('user_id', $id)
            ->with('user:id,name') // Eager load user relationship
            ->orderBy('created_at', 'desc')
            ->get();

        // Return JSON response with descriptions
        return response()->json(['descrips' => $descrips, 'user' => $user], 200);
    }


    public function delete($id)
    {
        // Detail 
        $desc = Descrip::find($id);
        if (!$desc) {
            return response()->json([
                'message' => 'desc Not Found.'
            ], 404);
        }

        // Delete Product
        $desc->delete();

        // Return Json Response
        return response()->json([
            'message' => "desc successfully deleted."
        ], 200);
    }
}
