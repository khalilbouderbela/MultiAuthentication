<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Validator;
use App\Models\Project;

class ProjectController extends Controller
{

    
    function deleteByAdmin($id){
        $project = Project::findOrFail($id);
        $image=$project->image;
        $video=$project->video;
        $document=$project->document;
        if($project->delete()){
            File::delete(env('PROJECT_UPLOAD_FOLDER').$image);
            File::delete(env('PROJECT_UPLOAD_FOLDER').$video);
            if($document)
                File::delete(env('PROJECT_UPLOAD_FOLDER').$document);

        }

            
        return redirect()->route('admin.profile');

    }


    function update(Request $request,$project_id){
        
        $project = Project::findOrFail($project_id);
        $request->validate([
            'projectname' => 'required',
            'projectimage' => 'image|mimes:jpeg,png,jpg',
            'projectvideo'=>'mimes:mp4,mov,avi,mkv',
            'additionaldocument',
            'projectdescription'=>'required',
            'projectgit'=>'required|url',
            'projectstatus'=>'required',
            'additionaldocument'=>'mimes:pdf,doc,docx',
         ]);
         $project->name = $request->projectname;
         
         if($request->hasfile('projectimage'))
         {
            File::delete(env('PROJECT_UPLOAD_FOLDER').$project->image);

             $file = $request->file('projectimage');
             $extention = $file->getClientOriginalExtension();
             $filename = time().'.'.$extention;
             $file->move('uploads/projects/', $filename);
             $project->image = $filename;
         }
         if($request->hasfile('projectvideo'))
         {
            File::delete(env('PROJECT_UPLOAD_FOLDER').$project->video);

             $file = $request->file('projectvideo');
             $extention = $file->getClientOriginalExtension();
             $filename = time().'.'.$extention;
             $file->move('uploads/projects/', $filename);
             $project->video = $filename;
         }
         if($request->hasfile('additionaldocument'))
         {
            if($project->document)
                File::delete(env('PROJECT_UPLOAD_FOLDER').$project->document);

             $file = $request->file('additionaldocument');
             $extention = $file->getClientOriginalExtension();
             $filename = time().'.'.$extention;
             $file->move('uploads/projects/', $filename);
             $project->document = $filename;
         }

         $project->description = $request->projectdescription;
         $project->git = $request->projectgit;
         $project->status = $request->projectstatus;
         
         if( $project->save() ){

            return redirect()->back()->with('success','Project updated successfully');
         }else{
             return redirect()->back()->with('error','Failed to update project');
         }
    }
    
    function viewUpdateAdmin(Request $request,$project_id){
        $project = Project::findOrFail($project_id);
        return view('dashboards.users.update',compact('project'));
    }
    function viewUpdateUser(Request $request,$project_id){
        $project = Project::findOrFail($project_id);
        if( $project->user_id != Auth()->user()->id )
            return redirect()->route('user.dashboard');

        return view('dashboards.users.update',compact('project'));
    }

    public function createProject(Request $request){
        $request->validate([
            'projectname' => 'required',
            'projectimage' => 'required|image|mimes:jpeg,png,jpg',
            'projectvideo'=>'required|mimes:mp4,mov,avi,mkv',
            'additionaldocument',
            'projectdescription'=>'required',
            'projectgit'=>'required|url',
            'projectstatus'=>'required',
            'additionaldocument'=>'mimes:pdf,doc,docx',
         ]);
         $project = new Project();
         $project->name = $request->projectname;
         $project->user_id = Auth()->user()->id;
         
         if($request->hasfile('projectimage'))
         {
             $file = $request->file('projectimage');
             $extention = $file->getClientOriginalExtension();
             $filename = time().'.'.$extention;
             $file->move('uploads/projects/', $filename);
             $project->image = $filename;
         }
         if($request->hasfile('projectvideo'))
         {
             $file = $request->file('projectvideo');
             $extention = $file->getClientOriginalExtension();
             $filename = time().'.'.$extention;
             $file->move('uploads/projects/', $filename);
             $project->video = $filename;
         }
         if($request->hasfile('additionaldocument'))
         {
             $file = $request->file('additionaldocument');
             $extention = $file->getClientOriginalExtension();
             $filename = time().'.'.$extention;
             $file->move('uploads/projects/', $filename);
             $project->document = $filename;
         }

         $project->description = $request->projectdescription;
         $project->git = $request->projectgit;
         $project->status = $request->projectstatus;
         
         if( $project->save() ){

            return redirect()->back()->with('success','Project created successfully');
         }else{
             return redirect()->back()->with('error','Failed to create project');
         }
    }
}
