<?php

namespace Csvimport\Http\Controllers;

use Illuminate\Http\Request;
use Csvimport\Import;
use Csvimport\Lead;
use Csvimport\Jobs\ImportCsv;
use Illuminate\Support\Facades\Storage;
use Excel;



class HomeController extends Controller
{

    protected $fileimport;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

         return view('home');
    }


    public function upload(Request $request)
    {
        if ($request->file('fileimport'))
        {
            $upload = $request->file('fileimport')->store('uploads');

            $import = Import::create([
                'user_id'=> \Auth::user()->id,
                'filename'=>$upload,
                'has_header'=>$request->input('has_header'),
                'status'=>'uploaded',
            ]);
            return response()->json(array('success'=>true, 'file'=>$upload, 'id'=>$import->id));
        }else{
            return response()->json(array('success'=>false, 'message'=>'Ocorreu um erro no upload'));
        }


    }

    public function savemap(Request $request)
    {
        $import = Import::find($request->input('id'));
        $import->mapping = json_encode($request->input('mapping'));
        $import->status = 'mapped';
        $import->save();

        ImportCsv::dispatch($import);

        return response()->json(array('success'=>true));
    }


}
