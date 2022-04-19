<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lib_project;
use App\Subject;
use App\User;
use Auth;
class LibProjectsController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $menu_active='lib_projects';
        $lib_projects = null;
        if($user->hasRole('Lecturer'))
        {
            $lib_projects=Lib_project::whereHas('supervisors',function($query) use($user){
                $query->where('lecturer_id',$user->id);
            })->paginate(10);
        }
        else
        {
            $lib_projects=Lib_project::paginate(10);
        }
        return view('backEnd.lib_projects.index',compact('menu_active','lib_projects'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $menu_active='lib_projects';
        $supervisors = User::whereRoleIs('Lecturer')->get();
        $students = User::whereRoleIs('Internal_student')->get();
        $subjects=Subject::whereIn('collage_id',$user->LecturerRegistredAtCollage)->get();
        return view('backEnd.lib_projects.create',compact('menu_active','supervisors','students','subjects'));
    }

    
    public function store(Request $request)
    {
        $this->validate($request,[
            'title_ar' => ['required','string'],
            'title_en' => ['required','string'],
            'study_year' => ['required','string'],
            'subject_id' => ['required'],
            'pdf_file' => ['required'],
            'pdf_file.*' => ['mimes:pdf']
        ]);
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
        $data['pdf_file'] = $file_name.'.pdf';
        $lib_project = Lib_project::create($data);
        $lib_project->students()->sync($request->students);
        $lib_project->supervisors()->sync($request->supervisors);
        return redirect()->route('lib_projects.index')->with('message','Added Success!');
    }

/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu_active='lib_projects';
        $lib_project=Lib_project::findOrFail($id);
        $supervisors = User::whereRoleIs('Lecturer')->get();
        $students = User::whereRoleIs('Internal_student')->get();
        $subjects=Subject::all();
        return view('backEnd.lib_projects.edit',compact('lib_project','menu_active','supervisors','students','subjects'));
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
        $lib_project=Lib_project::findOrFail($id);
        $this->validate($request,[
            'title_ar' => ['required','string'],
            'title_en' => ['required','string'],
            'study_year' => ['required','string'],
            'subject_id' => ['required'],
            'pdf_file' => ['required_if:countOldPDF,0'],
            'pdf_file.*' => ['mimes:pdf']
        ]);
        
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
        $lib_project->update($input_data);
        $lib_project->students()->sync($request->students);
        $lib_project->supervisors()->sync($request->supervisors);
        return redirect()->route('lib_projects.index')->with('message','Updated Success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lib_project=Lib_project::findOrFail($id);

        if($lib_project->pdf_file)
        {
            unlink(storage_path('app/public/PDFfiles/'.$lib_project->pdf_file));
        }

        $lib_project->delete();
        return redirect()->route('lib_projects.index')->with('message','Delete Success!');
    }

    public function deletefile($id)
    {
        $lib_project=Lib_project::findOrFail($id);
        $input_data['pdf_file'] = 'null';
        $pdf = storage_path('app/public/PDFfiles/'.$lib_project->pdf_file);
        // dd($pdf);
        if($lib_project->update($input_data)){
            ////// delete file ///
            unlink($pdf);
        }
        
        return back();
    }

}
