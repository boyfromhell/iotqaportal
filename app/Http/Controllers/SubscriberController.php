<?php

namespace App\Http\Controllers;

use App\MovieGenre;
use App\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        Log::debug($request->all());
        $genreArray = $request->inputObject;



        foreach (MovieGenre::all() as $genre) {
            if (($genreArray[$genre])!=null) {

                $SubscriberGenre = MovieGenre::first(['genere' => $genre]);
                $subscriber = Subscriber::firstOrCreate(['session_id' => $request->sessionId]);
                $subscriber->movieGenres()->attach($SubscriberGenre->id);
            }
        }

        return response()->json([
            'activeStatus' => 1
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Subscriber $subscriber
     * @return \Illuminate\Http\Response
     */
    public function show(Subscriber $subscriber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Subscriber $subscriber
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscriber $subscriber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Subscriber $subscriber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscriber $subscriber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Subscriber $subscriber
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscriber $subscriber)
    {
        return response()->json([
            'activeStatus' => 1
        ]);
    }
}
