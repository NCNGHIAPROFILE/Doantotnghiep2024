<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producer;

class ProducerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $producers;
    public function __construct(Producer $producers){
        $this->producers = $producers;
    }
    public function index()
    {
        $producers = Producer::all();
        $producersCount = Producer::all()->count();
        return response()->json([
            'status' => 200,
            'Recoure' => $producersCount,
            'Producers' => $producers
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataCreate = $request->all();
        $dataProducer = Producer::where('NameNXB', $dataCreate['NameNXB']);
        if ($dataProducer->exists()) {
            return response()->json([
                'status' => 400,
                'message' => "Producers already exists!"
            ], 400);
        }
        $producers = $this->producers->create($dataCreate);
        return response()->json([
            'status' => 201,
            'message' => "Producers Created successfully!",
            'producers' => $producers
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // SKIP
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $producers = Producer::where('id', $id)->get();
        if($producers->count() > 0){
            $producers = array();
            $producers['NameNXB'] = $request->NameNXB;
            $producers['AddressNXB'] = $request->AddressNXB;
            $producers['Note'] = $request->Note;
            $udapetProducer = Producer::where('id', $id)->update($producers);
            return response()->json([
                'status' => 200,
                'message' => "Producers Update Successfully!",
                'producers' => $udapetProducer
            ], 200);
        }
        else{
            return response()->json([
                'status' => 500,
                'message' => "Producers Update Failed!"
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $affectedRows = Producer::Where('id', $id)->delete();
        if ($affectedRows > 0) {
            return response()->json([
                'status' => 200,
                'message' => "Tickets Deleted Successfully",
            ], 200);
        }  
        else {
            return response()->json([
                'status' => 500,
                'message' => "Tickets Deleted Failed!",
            ], 500);
        }
    }
}
