<?php

namespace App\Http\Controllers;

use App\Content;
use App\Topic;
use Illuminate\Http\Request;

use Auth;

class ContentsController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $menu_active='contents';
        $contents = null;
        if($user->hasRole('Lecturer'))
        {
            $contents=Content::whereHas('topic',function($query) use($user) {
                $query->whereHas('course',function($q) use($user) {
                    $q->where('lecturer_id',$user->id);
                });
            })->paginate(10);
        }
        else
        {
            $contents=Content::paginate(10);
        }
        return view('backEnd.contents.index',compact('menu_active','contents'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $menu_active='contents';
        $topics = null;
        if($user->hasRole('Lecturer'))
        {
            $topics=Topic::whereHas('course',function($query) use($user) {
                $query->where('lecturer_id',$user->id);
            })->get();
        }
        else
        {
            $topics=Topic::all();
        }
        return view('backEnd.contents.create',compact('topics','menu_active'));
    }

    
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'topic_id' => ['required'],
            'sequence' => ['required','numeric'],
            'video_file' => ['required'],
            'video_file.*' => ['mimes:mp4'],
        ]);
        $file_name = str_replace(' ','-',$request->title).time();
        
        if($request->file('video_file'))
        {
            $file = $request->file('video_file');
            if($file->isValid())
            {
                $file->move(storage_path('app/public/ContentsVideos/'),$file_name.'.mp4');
            }
        }
        
        $appendix = false;
        if($request->file('appendix'))
        {
            $file = $request->file('appendix');
            if($file->isValid())
            {
                $appendixFile = $file_name.'.'.$file->getClientOriginalExtension();
                $file->move(storage_path('app/public/ContentsAppendixFiles/'),$appendixFile);
                $appendix = true;
            }
        }
        
        $data=$request->all();
        $data['video_file'] = $file_name.'.mp4';

        if($appendix)
            $data['appendix'] = $appendixFile;

        $content = Content::create($data);
        return redirect()->route('contents.index')->with('message','Added Success!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $menu_active='contents';
        $topics = null;
        if($user->hasRole('Lecturer'))
        {
            $topics=Topic::whereHas('course',function($query) use($user) {
                $query->where('lecturer_id',$user->id);
            })->get();
        }
        else
        {
            $topics=Topic::all();
        }
        $content=Content::findOrFail($id);
        return view('backEnd.contents.edit',compact('content','menu_active','topics'));
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
        $content=Content::findOrFail($id);
        $this->validate($request,[
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'topic_id' => ['required'],
            'sequence' => ['required','numeric'],

            'video_file' => ['required_if:countOldVideo,0'],
            'video_file.*' => ['mimes:mp4'],
        ]);
        
        $file_name = str_replace(' ','-',$request->title).time();
        $vedio = false;
        if($request->file('video_file'))
        {
            $file = $request->file('video_file');
            if($file->isValid())
            {
                $file->move(storage_path('app/public/ContentsVideos/'),$file_name.'.mp4');
                $vedio = true;
            }
        }

        $appendix = false;
        if($request->file('appendix'))
        {
            $file = $request->file('appendix');
            if($file->isValid())
            {
                $appendixFile = $file_name.'.'.$file->getClientOriginalExtension();
                $file->move(storage_path('app/public/ContentsAppendixFiles/'),$appendixFile);
                $appendix = true;
            }
        }
        $input_data=$request->all();
        if($appendix)
            $input_data['appendix'] = $appendixFile;
        if($vedio)
            $input_data['video_file'] = $file_name.'.mp4';

        $content->update($input_data);
        return redirect()->route('contents.index')->with('message','Updated Success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $content=Content::findOrFail($id);
        if($content->video_file != 'null')
        {
            unlink(storage_path('app/public/ContentsVideos/'.$content->video_file));
        }

        if($content->appendix)
        {
            unlink(storage_path('app/public/ContentsAppendixFiles/'.$content->appendix));
        }

        $content->delete();
        return redirect()->route('contents.index')->with('message','Delete Success!');
    }

    public function deleteVideo($id)
    {
        $content=Content::findOrFail($id);
        $input_data['video_file'] = 'null';
        $vedio = storage_path('app/public/ContentsVideos/'.$content->video_file);
        
        if($content->update($input_data)){
            ////// delete file ///
            unlink($vedio);
        }
        
        return back();
    }

    public function deleteAppendix($id)
    {
        $content=Content::findOrFail($id);
        $input_data['appendix'] = NULL;
        $file = storage_path('app/public/ContentsAppendixFiles/'.$content->appendix);
        
        if($content->update($input_data)){
            ////// delete file ///
            unlink($file);
        }
        
        return back();
    }

    public function getContentsByTopic($topic_id)
    {
        $menu_active = 'contents'; 
        $contents=Content::where('topic_id',$topic_id)->get();
        return view('backEnd.contents.index',compact('menu_active','contents'));
    }

}
