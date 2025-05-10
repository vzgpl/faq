<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReaderRequest;
use App\Http\Requests\UpdateReaderRequest;
use App\Models\Reader;

class ReaderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreReaderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Reader $reader)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reader $reader)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReaderRequest $request, Reader $reader)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reader $reader)
    {
        //
    }
}
