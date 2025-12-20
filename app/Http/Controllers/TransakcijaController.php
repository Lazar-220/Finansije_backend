<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransakcijaResource;
use App\Models\Transakcija;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransakcijaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TransakcijaResource::collection(Transakcija::all());
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
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'korisnik_id'=>['required','integer','exists:users,id'],
            'novcanik_id'=>['required','integer','exists:novcanici,id'],
            'kategorija_id'=>['required','integer','exists:kategorije,id'],
            'tip'=>'required|in:priliv,odliv',
            'iznos'=>['required','numeric','min:0'],
            'datum'=>['required','date'],
            'opis'=>['nullable','string']
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'Validacija nije prosla.',
                'errors'=>$validator->errors()
            ],422);
        }

        $data=$validator->validated();
        $transakcija=Transakcija::create($data);
        return response()->json(new TransakcijaResource($transakcija),201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return new TransakcijaResource(Transakcija::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transakcija $transakcija)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $transakcija=Transakcija::findOrFail($id);


        $validator=Validator::make($request->all(),[
            'korisnik_id'=>['required','integer','exists:users,id'],
            'novcanik_id'=>['required','integer','exists:novcanici,id'],
            'kategorija_id'=>['required','integer','exists:kategorije,id'],
            'tip'=>'required|in:priliv,odliv',
            'iznos'=>['required','numeric','min:0'],
            'datum'=>['required','date'],
            'opis'=>['nullable','string']
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'Validacija nije prosla.',
                'errors'=>$validator->errors()
            ],422);
        }

        $data=$validator->validated();
        $transakcija->update($data);
        return response()->json(new TransakcijaResource($transakcija),200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transakcija=Transakcija::findOrFail($id);
        $transakcija->delete();
        return response()->json(['message'=>'Obrisana je transakcija.'],200);
    }
}
