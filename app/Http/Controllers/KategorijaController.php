<?php

namespace App\Http\Controllers;

use App\Http\Resources\KategorijaResource;
use App\Models\Kategorija;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategorijaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return KategorijaResource::collection(Kategorija::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'korisnik_id'=>'required|integer|exists:users,id', //isto kao 'korisnik_id'=>['required','integer','exists:users,id']
            'naziv'=>'required|string|max:255',
            'tip'=>'required|in:priliv,odliv',
            'roditelj_id'=>'nullable|integer|exists:kategorije,id',
            'boja'=>'nullable|string|max:30',
            'ikonica'=>'nullable|string|max:50',
            'aktivna'=>'required|boolean'
        ]);

        if($validator->fails()){
            return response()->json([
                'message'=>'Validacija nije prosla.',
                'errors'=>$validator->errors()
            ],422);
        }

        $data=$validator->validated();
        $kategorija=Kategorija::create($data);
        return response()->json(new KategorijaResource($kategorija),201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return new KategorijaResource(Kategorija::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategorija $kategorija)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kategorija=Kategorija::findOrFail($id);

        $validator=Validator::make($request->all(),[
            'korisnik_id'=>['sometimes','integer','exists:users,id'],
            'naziv'=>'sometimes|string|max:255',
            'tip'=>'sometimes|in:priliv,odliv',
            'roditelj_id'=>'nullable|integer|exists:kategorije,id',
            'boja'=>'nullable|string|max:30',
            'ikonica'=>'nullable|string|max:50',
            'aktivna'=>'sometimes|boolean'
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'Validacija nije prosla.',
                'errors'=> $validator->errors()
            ],422);
        }

        $data=$validator->validated();
        $kategorija->update($data);

        return response()->json(new KategorijaResource($kategorija),200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kategorija=Kategorija::findOrFail($id);

        $kategorija->delete();
        return response()->json(['message'=>'Kategorija je obrisana'],200);
    }
}
