<?php

namespace App\Http\Controllers;

use App\Models\SuperAdmin;
use Illuminate\Http\Request;

class SuperadminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {

      //
      return view('healthversations.superadmin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(SuperAdmin $superadmin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuperAdmin $superadmin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuperAdmin $superadmin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuperAdmin $superadmin)
    {
        //
    }
}