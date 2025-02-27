<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\New_;
use App\Http\Requests\InternRequest;

class InternController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Intern::all());
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
    public function store(InternRequest $request)
    {
        //
        $data = $request->all();
        try {
            $intern = Intern::create($data);
            return response()->json($intern);

        } catch (\Throwable $th) {
            return response()->json(["msg" => "Erro ao criar o estagiário"]);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Intern $intern)
    {
        return Intern::find($intern);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Intern $intern)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Intern $intern)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Intern $intern)
    {
        //
    }
}
