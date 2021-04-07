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
        return view('TODO.create');
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
            'text' => 'string|max:64',
            'type' => [Rule::in(['private', 'public', 'undefined'])]
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
    public function edit(TODO $TODO)
    {
        return view('TODO.edit', ['todo' => $TODO]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TODO  $tODO
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TODO $TODO)
    {
        $valid = $request->validate([
            'text' => 'string|max:64',
            'type' => [Rule::in(['private', 'public', 'undefined'])]
        ]);

        $TODO->text = $request->text;
        $TODO->type = $request->type;

        $TODO->save();

        return redirect()->route('info');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TODO  $tODO
     * @return \Illuminate\Http\Response
     */
    public function destroy(TODO $TODO)
    {
        $TODO->delete();

        return redirect()->route('info');
    }
}
