<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use Illuminate\Validation\Rule;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        //
        $games = Game::orderBy('id', 'desc')->paginate(15);
        return view('admin.games.index', compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.games.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validated_data = $request->validate(
            [
                'title'=>'required | unique:games',
                'description' => 'nullable',
                'cover' => 'nullable',
                'is_available' => 'nullable'

            ]
            );

        Game::create($validated_data);

        return redirect()->route('admin.games.index')->with('feedback', 'Game succesfully added');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        //
        return view('games.show', compact('game'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game)
    {
        //
        return view('admin.games.edit', compact('game'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        //
        $validated_data = $request->validate(
            [
                'title' => [
                    'required',
                    Rule::unique('games')->ignore($game->id),
                ],
                'description' => 'nullable',
                'cover' => 'nullable',
                'is_available' => 'nullable'

            ]
            );

        $game->update($validated_data);

        return redirect()->route('admin.games.index')->with('feedback', 'Game succesfully modified');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        //
        $game->delete();
        return redirect()->route('admin.games.index')->with('feedback', 'Game succesfully removed');
    }
}
