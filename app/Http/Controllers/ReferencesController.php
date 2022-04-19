<?php

namespace App\Http\Controllers;

use App\Reference;
use Storage;

use Illuminate\Http\Request;

class ReferencesController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu_active='references';
        $references=Reference::paginate(10);
        return view('backEnd.references.index',compact('menu_active','references'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menu_active='references';
        return view('backEnd.references.create',compact('menu_active'));
    }

    
    public function store(Request $request)
    {
        $att = ['title' => 'Title',
                'author' => 'Author Name',
                'publisher' => 'Publisher Name',
                'publish_year' => 'Publish Year',
                'category' => 'Category',
                'description' => 'Description',
                'pdf_file' => 'PDF File',
                'image' => 'required',
                'image.*' => 'mimes:jpg,jpeg,png'
        ];
        $error_msg = ['title.required' => 'The title is required',
                      'title.unique' => 'This references with this title is already exists',
        ];
        $this->validate($request,[
            'title' => 'required|unique:references|string',
            'author' => 'required|regex:/^[a-z A-Z]+$/u',
            'publisher' => 'required|regex:/^[a-z A-Z]+$/u',
            'publish_year' => 'required|digits:4|integer|min:1900|max:'.date('Y'),
            'category' => 'required|string',
            'description' => 'required|string',
            // 'pdf_file' => 'required',
            // 'pdf_file.*' => 'mimes:pdf'
        ],$error_msg,$att);

        $file_name = str_replace(' ','-',$request->title_en).time();
        if($request->file('pdf_file')){
            $file = $request->file('pdf_file');
            if($file->isValid())
            {
                $file->move(storage_path('app/public/PDFfiles/'),$file_name.'.pdf');
                $ispdf = true;
            }
        }
        $data=$request->all();
        if($request->file('image')){
            $file = $request->file('image');
            if($file->isValid()){
                $imageExtension=['jpeg','jpg','png'];
                $fileName=time().'-'.str_slug($file->getClientOriginalName(),"-").'.'.$file->getClientOriginalExtension();
                
                if(in_array($file->getClientOriginalExtension(),$imageExtension))
                {
                    $image=public_path('photos/references/').$fileName;
                    //Resize Image
                    Image::make($file)->save($image);
                    $data['image']=$fileName;
                }
            }       
        }
        $data['pdf_file'] = $file_name.'.pdf';
        $reference = Reference::create($data);
        return redirect()->route('references.index')->with('message','Added Success!');
    }


/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu_active='references';
        $reference=Reference::findOrFail($id);
        return view('backEnd.references.edit',compact('reference','menu_active'));
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
        $reference=Reference::findOrFail($id);

        $att = ['title' => 'Title',
                'author' => 'Author Name',
                'publisher' => 'Publisher Name',
                'publish_year' => 'Publish Year',
                'category' => 'Category',
                'description' => 'Description',
                'pdf_file' => 'PDF File',
                'image' => 'required_if:countOldMedia,0',
                'image.*' => 'mimes:jpg,jpeg,png'
        ];

        $error_msg = ['title.required' => 'The Title is required',
                      'title.unique' => 'This references with this title is already exists',
        ];

        $this->validate($request,[
            'title' => 'required'|'string',
            'author' => 'required'|'string',
            'publisher' => 'required'|'string',
            // 'publish_year' => 'required'|'date_format:Y',
            'publish_year' => 'required|digits:4|integer|min:1900|max:'.date('Y'),
            'category' => 'required'|'string',
            'description' => 'required'|'string',
            'pdf_file' => 'required_if:countOldPDF,0',
            'pdf_file.*' => 'mimes:pdf'
        ],error_msg);
        
        $file_name = str_replace(' ','-',$request->title_en).time();
        if($request->file('pdf_file')){
            $file = $request->file('pdf_file');
            if($file->isValid())
            {
                $file->move(storage_path('app/public/PDFfiles/'),$file_name.'.pdf');
                $ispdf = true;
            }
        }
        $input_data=$request->all();
        $input_data['pdf_file'] = $file_name.'.pdf';
        if($request->file('image')){
            $file = $request->file('image');
            if($file->isValid()){
                $imageExtension=['jpeg','jpg','png'];
                $fileName=time().'-'.str_slug($file->getClientOriginalName(),"-").'.'.$file->getClientOriginalExtension();
                
                if(in_array($file->getClientOriginalExtension(),$imageExtension))
                {
                    $image=public_path('photos/references/').$fileName;
                    //Resize Image
                    Image::make($file)->save($image);
                    $input_data['image']=$fileName;
                }
            }       
        }
        $reference->update($input_data);
        return redirect()->route('references.index')->with('message','Updated Success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reference=Reference::findOrFail($id);

        if($reference->pdf_file)
        {
            unlink(storage_path('app/public/PDFfiles/'.$reference->pdf_file));
        }

        $reference->delete();
        return redirect()->route('references.index')->with('message','Delete Success!');
    }

    public function deleteImage($id)
    {
        $event=Event::findOrFail($id);
        $input_data['image'] = null;
        
        $image=public_path('photos/references/').$event->image;
        if($event->update($input_data)){
            ////// delete image ///
            unlink($image);
        }
        
        return back();
    }
}
