<?php

namespace App\Http\Controllers;

use App\Area;
use App\Bin;
use App\BinLocation;
use App\Item;
use App\Mutation;
use App\Rack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Auth;


class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas = Area::all();
        return view('main', compact('areas'));
    }

    /**
     * Display rack.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRack($area)
    {
        $racks = Rack::where('area_id', $area)->get();
        return json_encode($racks);
    }

    /**
     * Display bin location.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBinLocation($rack)
    {
        $binlocations = BinLocation::where('rack_id', $rack)->get();
        return json_encode($binlocations);
    }

    /**
     * Display bin.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBin($binlocation)
    {
        $query = '
        SELECT
            bins.*,
            items.* 
        FROM
            bins
            LEFT JOIN items ON bins.id_bin = items.bin_id 
        WHERE
            bins.bin_location_id = %s
        ORDER BY
            bins.id_bin ASC
        ';
        $sql = sprintf($query, $binlocation);
        $bins = DB::select($sql);
        return json_encode($bins);
    }

    /**
     * Display info item.
     *
     * @return \Illuminate\Http\Response
     */
    public function infoItem($id)
    {
        $query = '
        SELECT
            * 
        FROM
            items i
            LEFT JOIN mutations m ON i.id_item = m.item_id
            LEFT JOIN bins b ON i.bin_id = b.id_bin
            LEFT JOIN bin_locations bl ON b.bin_location_id = bl.id_bin_location
            LEFT JOIN racks r ON bl.rack_id = r.id_rack
            LEFT JOIN areas a ON r.area_id = a.id_area 
        WHERE
            b.id_bin = %s
        ';
        $sql = sprintf($query, $id);
        $items = DB::select($sql);
        return json_encode($items);
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
     * Store a newly created resource item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeItem(Request $request)
    {
        // cek kode item apakah sama
        $item_code = Item::where('item_code', $request->item_code)->get();
        if ( count($item_code) > 0 ) {
            return response()->json([
                'message' => 'kode',
            ], 500);
        } else {
            DB::beginTransaction();
            try {
                $item = new Item();
                $item->bin_id = $request->bin_id;
                $item->item_code = $request->item_code;
                $item->item_name = $request->item_name;
                $item->unit = $request->unit;
                $item->save();
                
                $mutation = new Mutation();
                $mutation->item_id = $item->id_item;
                $mutation->user_id = Auth::user()->id;
                $mutation->qty = $request->qty;
                $mutation->transtype = 'in';
                $mutation->save();

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
