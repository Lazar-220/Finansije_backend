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


    public function moje(Request $request){
        $userId=$request->user()->id;

        $transakcije=Transakcija::where('korisnik_id',$userId)
            ->orderByDesc('datum')
            ->get();

        return response()->json(TransakcijaResource::collection($transakcije),200);
    }

    public function mojiPrilivi(Request $request){
        $userId=$request->user()->id;

        $transakcije=Transakcija::where('korisnik_id',$userId)
            ->where('tip','priliv')
            ->orderByDesc('datum')
            ->get();

        return response()->json(TransakcijaResource::collection($transakcije),200);
    }

    public function mojiOdlivi(Request $request){
        $userId=$request->user()->id;

        $transakcije=Transakcija::where('korisnik_id',$userId)
            ->where('tip','odliv')
            ->orderByDesc('datum')
            ->get();

        return response()->json(TransakcijaResource::collection($transakcije),200);
    }


    public function mojiPriliviPaginated(Request $request){

        $userId=$request->user()->id;

        $perPage=(int)$request->get('per_page',10);

        $query=Transakcija::where('korisnik_id',$userId)
            ->where('tip','priliv')
            ->orderByDesc('datum');
                                    //ne sme get sa paginacijom!              // ->get();

        $paginator=$query->paginate($perPage);

        // return response()->json(TransakcijaResource::collection($paginator),200);  //ne sme response pre 
        return TransakcijaResource::collection($paginator);
    }

    public function mojiOdliviPaginatedFiltered(Request $request){

        $userId=$request->user()->id;

        $perPage=$request->get('per_page',10);

        $query=Transakcija::where('korisnik_id',$userId)
            ->where('tip','odliv');

        if($request->filled('kategorija_id')){
            $query->where('kategorija_id',$request->get('kategorija_id'));//isto kao $query=$query->where...
        }
        if($request->filled('novcanik_id')){
            $query->where('novcanik_id',$request->get('novcanik_id'));//isto kao $query=$query->where...
        }
        if($request->filled('date_from')){
            $query->whereDate('datum','>=',$request->get('date_from'));//isto kao $query=$query->where...
        }
        if($request->filled('date_to')){
            $query->whereDate('datum','<=',$request->get('date_to'));//isto kao $query=$query->where...
        }
        if($request->filled('min_iznos')){
            $query->where('iznos','>=',$request->get('min_iznos'));//isto kao $query=$query->where...
        }
        if($request->filled('max_iznos')){
            $query->where('iznos','<=',$request->get('max_iznos'));//isto kao $query=$query->where...
        }


        $query->orderByDesc('datum');

        $paginator=$query->paginate($perPage);

        return TransakcijaResource::collection($paginator);
    }

    public function exportCsv(Request $request){

        $userId=$request->user()->id;

        $transakcije=Transakcija::with(['kategorija','novcanik'])
        ->where('korisnik_id',$userId)
        ->orderBy('datum','asc')
        ->get();

        $columns=
        [
        'id',
        'datum',
        'tip',
        'iznos',
        'opis',
        'novcanik',
        'kategorija'
        ];

        $callback=function () use ($transakcije,$columns){
            
            $file=fopen('php://output','w'); //zar nije bolje 'a'?

            fputcsv($file,$columns,';');//header

            foreach($transakcije as $t){
                fputcsv($file,[
                    $t->id,
                    $t->datum ? $t->datum->format('Y-m-d') : null,
                    $t->tip,
                    $t->iznos,
                    $t->opis,
                    optional($t->novcanik)->naziv,
                    optional($t->kategorija)->naziv,

                ],';');
            }
            fclose($file);
        };

        $fileName='transakcije_' . $userId . '_' . now()->format('Ymd_His') . '.csv';

        return response()->stream($callback,200,[
            'Content-Type'=>'text/csv,charset=UTF-8',
            'Content-Disposition'=>'attachment;filename="' . $fileName . '"'
        ]);

    }

}
