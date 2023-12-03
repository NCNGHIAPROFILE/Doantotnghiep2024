<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $admins;
    public function __construct(Admin $admins){
        $this->admins = $admins;
    }
    public function index(){
        $admins = Admin::all();
        $adminsCount = $admins->count();
        return response()->json([
            'status' => 200,
            'Recoure' => $adminsCount,
            'Admins' => $admins
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
