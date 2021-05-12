<?php

namespace App\Http\Controllers;

use App\Area;
use App\Rack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class RackController extends Controller
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
        $racks = Rack::all();
        $areas = Area::all();
        return view('admin.rack', compact('racks', 'areas'));
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
        DB::beginTransaction();
        try {
            $rack = new Rack();
            $rack->area_id = $request->area_id;
            $rack->rack_name = $request->rack_name;
            $rack->save();
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
        $rack = Rack::find($id);
        return json_encode($rack);
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
            $rack = Rack::findOrFail($id);
            $rack->area_id = $request->area_id;
            $rack->rack_name = $request->rack_name;
            $rack->update();
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // tambah kondisi jika rack ada bin location nya
        $rack = Rack::find($id);
        $rack->delete();
        return response()->json([
            'message' => 'success',
        ], 200);
    }
}
