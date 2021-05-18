<?php

namespace App\Http\Controllers;

use App\Bin;
use App\BinLocation;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class BinController extends Controller
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
        $bins = Bin::orderBy('bin_location_id', 'ASC')->get();
        $binlocations = BinLocation::all();
        return view('admin.bin', compact('bins', 'binlocations'));
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
            $bin = new Bin();
            $bin->bin_location_id = $request->bin_location_id;
            $bin->bin_name = $request->bin_name;
            $bin->save();
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
        $bin = Bin::find($id);
        return json_encode($bin);
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
            $bin = Bin::findOrFail($id);
            $bin->bin_location_id = $request->bin_location_id;
            $bin->bin_name = $request->bin_name;
            $bin->update();
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
        // cek isi bin 
        $item = Item::where('bin_id', $id)->get();
        if ( count($item) > 0 ) {
            return response()->json([
                'message' => 'item',
            ], 500);
        } else {
            $bin = Bin::find($id);
            $bin->delete();
            return response()->json([
                'message' => 'success',
            ], 200);
        }
    }
}
