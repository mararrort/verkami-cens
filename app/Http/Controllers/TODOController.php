<?php

namespace App\Http\Controllers;

use App\Models\TODO;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;

class TODOController extends Controller
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
        return view('todo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = $request->validate([
            'text' => 'string|max:128',
            'type' => [Rule::in(['private', 'public', 'undecided'])],
        ]);

        $todo = new TODO();

        $todo->id = UUID::uuid4();
        $todo->text = $request->text;
        $todo->type = $request->type;

        $todo->save();

        return redirect()->route('info');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TODO  $tODO
     * @return \Illuminate\Http\Response
     */
    public function show(TODO $tODO)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TODO  $tODO
     * @return \Illuminate\Http\Response
     */
    public function edit(TODO $todo)
    {
        return view('todo.edit', ['todo' => $todo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TODO  $tODO
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TODO $todo)
    {
        $valid = $request->validate([
            'text' => 'string|max:128',
            'type' => [Rule::in(['private', 'public', 'undecided'])],
        ]);

        $todo->text = $request->text;
        $todo->type = $request->type;

        $todo->save();

        return redirect()->route('info');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TODO  $tODO
     * @return \Illuminate\Http\Response
     */
    public function destroy(TODO $todo)
    {
        $todo->delete();

        return redirect()->route('info');
    }
}
