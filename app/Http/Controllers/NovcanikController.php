<?php

namespace App\Http\Controllers;

use App\Http\Resources\NovcanikResource;
use App\Models\Novcanik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NovcanikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //GET
    // /novcanici
    public function index()
    {
        return NovcanikResource::collection(Novcanik::all());
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
            'korisnik_id'=>'required|integer|exists:users,id',
            'naziv'=>'required|string|max:255',
            'tip'=>'required|in:banka,kes,stednja,kripto,ostalo',
            'valuta'=>'required|in:RSD,EUR,USD',
            'pocetno_stanje'=>'nullable|numeric|min:0',
            'trenutno_stanje'=>'nullable|numeric|min:0',
            'aktivan'=>'nullable|boolean'
        ]);

        if($validator->fails()){
            return response()->json([
                'message'=>'Validacija nije prosla.',
                'errors'=>$validator->errors()
            ],422);
        }

        $data=$validator->validated();
        $novcanik=Novcanik::create($data);
        return response()->json(new NovcanikResource($novcanik),201);
    }

    /**
     * Display the specified resource.
     */
    //GET
    // /novcanici/{id}
    public function show($id)
    {
        return new NovcanikResource(Novcanik::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Novcanik $novcanik)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $novcanik=Novcanik::find($id); //findOrFail

        //
        if(!$novcanik){    //umesto ovog if moze samo findOrFail
            return response()->json(['message'=>'Novcanik nije pronadjen.'],404);
        }
        //

        $validator=Validator::make($request->all(),[
            'korisnik_id'=>'sometimes|integer|exists:users,id',
            'naziv'=>'sometimes|string|max:255',
            'tip'=>'sometimes|in:banka,kes,stednja,kripto,ostalo',
            'valuta'=>'sometimes|in:RSD,EUR,USD',
            'pocetno_stanje'=>'nullable|numeric|min:0',
            'trenutno_stanje'=>'nullable|numeric|min:0',
            'aktivan'=>'nullable|boolean'
        ]);
        //sometimes sluzi da se zaobidje validacija podataka koji nisu prosledjeni, tj koji se ne menjanju

        if($validator->fails()){
            return response()->json([
                'message'=>'Validacija nije prosla.',
                'errors'=>$validator->errors()
            ],422);
        }

        $data=$validator->validated();
        $novcanik->update($data);
        return response()->json(new NovcanikResource($novcanik),200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $novcanik=Novcanik::find($id);

        if(!$novcanik){
            return response()->json([
                "message"=>'Novcanik nije pronadjen.'
            ],404);
        }

        $novcanik->delete();

        return response()->json([
            'message'=>'Novcanik je obrisan.'
        ],200);
    }
}
