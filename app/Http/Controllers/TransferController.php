<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransferResource;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return TransferResource::collection(Transfer::all());
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
            'novcanik_iz_id'=>['required','integer','exists:novcanici,id'],
            'novcanik_u_id'=>['required','integer','exists:novcanici,id','different:novcanik_iz_id'],
            'iznos'=>['required','numeric','min:0'],
            'valuta'=>['required','string','size:3'],
            'provizija'=>['nullable','numeric','min:0'],
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
        $transfer=Transfer::create($data);
        return response()->json(new TransferResource($transfer),201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return new TransferResource(Transfer::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transfer $transfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $transfer=Transfer::findOrFail($id);
        $validator=Validator::make($request->all(),[
            'korisnik_id'=>['sometimes','integer','exists:users,id'],
            'novcanik_iz_id'=>['sometimes','integer','exists:novcanici,id'],
            'novcanik_u_id'=>['sometimes','integer','exists:novcanici,id','different:novcanik_iz_id'],
            'iznos'=>['sometimes','numeric','min:0'],
            'valuta'=>['sometimes','string','size:3'],
            'provizija'=>['nullable','numeric','min:0'],
            'datum'=>['sometimes','date'],
            'opis'=>['nullable','string']
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'Validacija nije prosla.',
                'errors'=>$validator->errors()
            ],422);
        }

        $data=$validator->validated();
        $transfer->update($data);
        return response()->json(new TransferResource($transfer),200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transfer=Transfer::findOrFail($id);
        $transfer->delete();
        return response()->json(['message'=>'Obrisan je transfer.'],200);
    }
}
