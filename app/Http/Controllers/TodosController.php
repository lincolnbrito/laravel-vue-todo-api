<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;

class TodosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Todo::where('user_id', auth()->user()->id)->get();
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

        $data = $request->validate([
            'title' => 'required|string',
            'completed' => 'required|boolean'
        ]);

        $todo = Todo::create([
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'completed'=> $request->completed
        ]);

        return response()->json($todo, 201);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        if($todo->user_id != auth()->user()->id) {
            return response()->json('Unauthorize',401);
        }

        $data = $request->validate([
            'title' => 'required|string',
            'completed' => 'required|boolean'
        ]);

        $todo->update($data);

        return response()->json($todo, 200);
    }


    public function updateAll(Request $request)
    {
        $data = $request->validate([
            'completed' => 'required|boolean'
        ]);

        Todo::where('user_id', auth()->user()->id)->update($data);

        return response()->json(['message'=>'Updated', 'success'=>true], 200);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        if($todo->user_id != auth()->user()->id) {
            return response()->json('Unauthorize',401);
        }

        $todo->delete();

        return response()->json(['message'=>'Deleted todo item', 'success'=>true], 200);
    }

    public function destroyCompleted(Request $request)
    {

        $todosToDelete = $request->todos;

        $userTodoIds = auth()->user()->todos->map(function($todo){
            return $todo->id;
        });

        $valid = collect($todosToDelete)->every(function($value, $key) use($userTodoIds){
            return $userTodoIds->contains($value);
        });

        if(!$valid) {
            return response()->json('Unauthorized', 401);
        }



        $data = $request->validate([
            'todos' => 'required|array'
        ]);

        Todo::destroy($request->todos);

        return response()->json(['message'=>'Deleted completed todos', 'success'=>true], 200);
    }
}
