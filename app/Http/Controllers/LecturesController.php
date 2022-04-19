<?php

namespace App\Http\Controllers;

use App\Lecture;
use App\_Class;
use Image;
use DNS2D;
use Storage;
use Illuminate\Http\Request;
use Auth;

class LecturesController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $menu_active='lectures';
        $lectures = null;
        if($user->hasRole('Lecturer'))
        {
            $lectures=Lecture::whereHas('_class',function($query) use($user){
                $query->where('lecturer_id',$user->id);
            })->paginate(10);
        }
        else
        {
            $lectures=Lecture::paginate(10);
        }
        return view('backEnd.lectures.index',compact('menu_active','lectures'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $menu_active='lectures';
        if($user->hasRole('Lecturer'))
        {
            $classes=_Class::where('lecturer_id',$user->id)->get();
        }
        else
        {
            $classes = _Class::all();
        }
        return view('backEnd.lectures.create',compact('classes','menu_active'));
    }

    
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => ['required','string'],
            'date' => ['required','date'],
            'class_id' => ['required'],
            'pdf_file.*' => ['mimes:pdf']
        ]);
        $file_name = str_replace(' ','-',$request->title).time();
        $ispdf = false;
        if($request->file('pdf_file')){
            $file = $request->file('pdf_file');
            if($file->isValid())
            {
                $file->move(storage_path('app/public/PDFfiles/'),$file_name.'.pdf');
                $ispdf = true;
            }
        }
        // $url = route('/checkInLec'); To do later ^_^
        $url = 'https://'.$file_name;
        Storage::disk('public')->put('/QR-codes/'.$file_name.'.png',base64_decode(DNS2D::getBarcodePNG($url, "QRCODE")));
        $data=$request->all();
        if($ispdf)
            $data['pdf_file'] = $file_name.'.pdf';
        $data['qr_code'] = $file_name.'.png';
        $lecture = Lecture::create($data);
        return redirect()->route('lectures.index')->with('message','Added Success!');
    }

/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu_active='lectures';
        $lecture=Lecture::findOrFail($id);
        return view('backEnd.lectures.edit',compact('lecture','menu_active'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $lecture=Lecture::findOrFail($id);
        $this->validate($request,[
            'title' => ['required','string'],
            'date' => ['required','date'],
            'class_id' => ['required'],
        ]);
        $ispdf = false;
        $file_name = str_replace(' ','-',$request->title).time();
        if($request->file('pdf_file')){
            $file = $request->file('pdf_file');
            if($file->isValid())
            {
                $file->move(storage_path('app/public/PDFfiles/'),$file_name.'.pdf');
                $ispdf = true;
            }
        }
        $input_data=$request->all();
        if($ispdf)
            $input_data['pdf_file'] = $file_name.'.pdf';
        $lecture->update($input_data);
        return redirect()->route('lectures.index')->with('message','Updated Success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lecture=Lecture::findOrFail($id);
        if($lecture->qr_code != 'null')
        {
            unlink(storage_path('app/public/QR-codes/'.$lecture->qr_code));
        }

        if($lecture->pdf_file)
        {
            unlink(storage_path('app/public/PDFfiles/'.$lecture->pdf_file));
        }

        $lecture->delete();
        return redirect()->route('lectures.index')->with('message','Delete Success!');
    }

    public function deletefile($id)
    {
        $lecture=Lecture::findOrFail($id);
        $input_data['pdf_file'] = NULL;
        $pdf = storage_path('app/public/PDFfiles/'.$lecture->pdf_file);
        // dd($pdf);
        if($lecture->update($input_data)){
            ////// delete file ///
            unlink($pdf);
        }
        
        return back();
    }

    public function getLecturesByClass($cla_id)
    {
        $menu_active = 'lectures'; 
        $lectures=Lecture::where('class_id',$cla_id)->get();
        return view('backEnd.lectures.index',compact('menu_active','lectures'));
    } 
}
