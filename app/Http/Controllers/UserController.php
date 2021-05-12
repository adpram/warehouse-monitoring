<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.user', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // cek email 
        $email = User::where('email', $request->email)->get();
        if ( count($email) > 0 ) {
            return response()->json([
                'message' => 'email',
            ], 500);
        } else {
            if ( $request->password != $request->password_confirmation ) {
                return response()->json([
                    'message' => 'password',
                ], 500);
            } else {
                DB::beginTransaction();
                try {
                    $user = new User();
                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->password = Hash::make($request->password);
                    $user->save();
                    DB::commit();
                    return response()->json([
                        'message' => 'success',
                    ], 200);
                } catch (Exception $e) {
                    DB::rollBack();
                    return response()->json([
                        'message' => $e->getMessage()
                    ], 500);
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return json_encode($user);
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
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->update();
            DB::commit();
            return response()->json([
               'message' => 'success',
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

    }

    /**
     * change password user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request, $id)
    {
        if ( $request->password != $request->password_confirmation ) {
            return response()->json([
                'message' => 'password',
            ], 500);
        } else {
            DB::beginTransaction();
            try {
                $user = User::findOrFail($id);
                $user->password = Hash::make($request->password);
                $user->update();
                DB::commit();
                return response()->json([
                    'message' => 'success',
                ], 200);
            } catch (Exception $e) {
                DB::rollBack();
                return response()->json([
                    'message' => $e->getMessage()
                ], 500);
            }
        }

    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ( $id != 1 ) {
            $user = User::find($id);
            $user->delete();
            return response()->json([
                'message' => 'success',
            ], 200);
        }
    }
}
