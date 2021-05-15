<?php

namespace App\Http\Controllers;

use App\Bin;
use App\BinLocation;
use App\Rack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class BinLocationController extends Controller
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
        $sql = "
        SELECT DISTINCT
            racks.*,
            areas.*,
            bin_locations.*,
            ( SELECT count( bins.id_bin ) FROM bins WHERE bins.bin_location_id = bin_locations.id_bin_location ) AS jumlahbin 
        FROM
            bin_locations
            LEFT JOIN racks ON racks.id_rack = bin_locations.rack_id
            LEFT JOIN areas ON areas.id_area = racks.area_id
            LEFT JOIN bins ON bins.bin_location_id = bin_locations.id_bin_location 
        ORDER BY
            areas.id_area ASC
        ";
        $binlocations = DB::select($sql);
        $racks = Rack::all();
        return view('admin.bin-location', compact('binlocations', 'racks'));
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
            $binlocation = new BinLocation();
            $binlocation->rack_id = $request->rack_id;
            $binlocation->bin_location_name = $request->bin_location_name;
            $binlocation->save();
            if ( !empty($request->bin_qty) ) {
                for ( $i=1; $i <= $request->bin_qty; $i++ ) {
                    $bin = new Bin();
                    $bin->bin_location_id = $binlocation->id_bin_location;
                    $bin->bin_name = $i;
                    $bin->save();
                }
            }
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
        $binlocation = BinLocation::find($id);
        return json_encode($binlocation);
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
            $binlocation = BinLocation::findOrFail($id);
            $binlocation->rack_id = $request->rack_id;
            $binlocation->bin_location_name = $request->bin_location_name;
            $binlocation->update();
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
        // cek isi bin location
        $bin = Bin::where('bin_location_id', $id)->get();
        if ( count($bin) > 0 ) {
            return response()->json([
                'message' => 'bin',
            ], 500);
        } else {
            $binlocation = BinLocation::find($id);
            $binlocation->delete();
            return response()->json([
                'message' => 'success',
            ], 200);
        }
    }
}
