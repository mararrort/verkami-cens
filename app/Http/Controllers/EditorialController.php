<?php

namespace App\Http\Controllers;

use App\Models\Editorial;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class EditorialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $editorials = Editorial::withCount('presales')
            ->orderBy('presales_count', 'DESC')
            ->orderBy('name', 'ASC')
            ->get();

        return view('editorial.index', ['editorials' => $editorials]);
    }
}
