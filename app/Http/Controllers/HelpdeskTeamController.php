<?php

namespace App\Http\Controllers;

use App\Models\HelpdeskTeam;
use Illuminate\Http\Request;

class HelpdeskTeamController extends Controller
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
        return view('teams.index', ['teams' => HelpdeskTeam::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teams.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'email_host' => 'required',
            'email_user' => 'required',
            'email_pass' => 'present',
            'email_encryption' => 'required'
        ]);

        $team = HelpdeskTeam::create($request->all());
        return redirect(route('teams.show', ['team' => $team->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HelpdeskTeam  $team
     * @return \Illuminate\Http\Response
     */
    public function show(HelpdeskTeam $team)
    {
        return view('teams.show', ['team' => $team]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HelpdeskTeam  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(HelpdeskTeam $team)
    {
        return view('teams.edit', ['team'=> $team]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HelpdeskTeam  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HelpdeskTeam $team)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'email_host' => 'required',
            'email_user' => 'required',
            'email_pass' => 'present',
            'email_encryption' => 'required'
        ]);
        $team->save($request->all());
        
        return redirect(route('teams.show',['team' => $team->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HelpdeskTeam  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(HelpdeskTeam $team)
    {
        //
    }
}
