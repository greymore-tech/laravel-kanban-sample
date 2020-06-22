<?php

namespace App\Http\Controllers;

use App\Board;
use Illuminate\Http\Request;
use Illuminate\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BoardResource;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        //  fetch all boards based on current user id
        $boards = Board::all()->where('user_id', $user_id);

        //  return boards as a resource
        return BoardResource::collection($boards);
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
    public function store(Request $request, $user_id)
    {
        //  store new board in the database
        $board = new Board;
        $board->user_id = $user_id;
        $board->name = $request->input('name');

        if ($board->save()) {
            //  if saved then return board as a resource
            return new BoardResource($board);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function show($id, $user_id)
    {
        //  fetch board based on current user id and board id
        $board = Board::where('user_id', $user_id)->FindOrFail($id);

        //  return board as a resource
        return new BoardResource($board);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function edit(Board $board)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id)
    {
        //  update existing board data based on current user id and board id
        $board = Board::where('user_id', $user_id)->FindOrFail($request->board_id);
        $board->user_id = $user_id;
        $board->name = $request->input('name');

        if ($board->save()) {
            //  if saved then return board as a resource
            return new BoardResource($board);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $user_id)
    {
        //  fetch board based on current user id and board id
        $board = Board::where('user_id', $user_id)->FindOrFail($id);

        if ($board->delete()) {
            //  id deleted then return board as a resource
            return new BoardResource($board);
        }
    }
}
