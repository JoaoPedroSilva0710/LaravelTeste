<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\New_;
use App\Http\Requests\InternRequest;
use App\Models\Phone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

use function Illuminate\Log\log;

class InternController extends Controller
{
    const GENERIC_ERROR = 'Erro, contate os administradores para entender o ocorrido';
    const CPF_DUPLICATED = 'Este CPF já está cadastrado no sistema';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Intern::with('phones')->paginate(15));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(InternRequest $request)
    {
        
        $validated = $request->validated();

        $cpf = preg_replace( '/[^0-9]/is', '', $validated['cpf'] );

        $dataIntern = ['name' => $validated['name'], 'gender' => $validated['gender'], 'birth' => $validated['birth'], 'cpf' => $cpf];
        
        try {
            $intern = Intern::create($dataIntern);

            $dataPhone = ['number' => $validated['phone'], 'intern_id' => $intern->id];

            $phone = Phone::create($dataPhone);

            return response()->json([ 'Estagiário' => $intern, 'Telefone' => $phone], 201);

        } catch (\Throwable $th) {
            if (!str_contains($th->getMessage(), "interns_cpf_unique")) {
                return $this->sendSweetalert('error',self::GENERIC_ERROR, 400);
            }

            return $this->sendSweetalert('error', self::CPF_DUPLICATED, 422);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Intern $intern)
    {
        return Intern::find($intern);
    }


    public function showByName(string $name)
    {
        $response = Intern::whereRaw("ts_vector_search_name @@ to_tsquery(?)", [$name])->paginate(15);


        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InternRequest $request, Intern $intern, Phone $phone)
    {
        $validated = $request->validated();

        $cpf = preg_replace( '/[^0-9]/is', '', $validated['cpf'] );

        $dataIntern = ['name' => $validated['name'], 'gender' => $validated['gender'], 'birth' => $validated['birth'], 'cpf' => $cpf];
        
        try {
            $intern->update($dataIntern);

            $dataPhone = ['number' => $validated['phone']];

            $phone->update($dataPhone);

            return response()->json([ 'Estagiário' => $intern, 'Telefone' => $phone], 201);

        } catch (\Throwable $th) {
            if (!str_contains($th->getMessage(), "interns_cpf_unique")) {
                Log::info($th->getMessage());
                return $this->sendSweetalert('error',self::GENERIC_ERROR, 400);
            }

            return $this->sendSweetalert('error', self::CPF_DUPLICATED, 422);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Intern $intern)
    {
        //
        try {
            $intern->update(['deleted_at' => date('Y-m-d')]);
            return $this->sendSweetalert('success', 'Estagiário deletado com sucesso');

        } catch (\Throwable $th) {
            Log::info($th->getMessage(), [$th]);
            return $this->sendSweetalert('error', self::GENERIC_ERROR, 400);
        }
    }
}
