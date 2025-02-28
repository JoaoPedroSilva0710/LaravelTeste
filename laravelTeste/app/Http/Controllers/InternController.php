<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\New_;
use App\Http\Requests\InternRequest;
use App\Models\Phone;

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
        $validated = $request->validated();
        $dataIntern = ['name' => $validated['name'], 'gender' => $validated['gender'], 'birth' => $validated['birth'], 'cpf' => $validated['cpf']];
        
        try {
            $intern = Intern::create($dataIntern);

            $dataPhone = ['number' => $validated['phone'], 'intern_id' => $intern->id];

            $phone = Phone::create($dataPhone);

            return response()->json([ 'Estagiário' => $intern, 'Telefone' => $phone]);

        } catch (\Throwable $th) {
            return response()->json(["message" => $th->getMessage()]);
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
