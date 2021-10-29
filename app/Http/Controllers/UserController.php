<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    function index(){

        $projectsStatus = DB::table('projects')
        ->select('status', DB::raw('count(*) as nb'))
        ->where('user_id','=',Auth::user()->id)
        ->groupBy('status')
        ->get();
        
        return view('dashboards.users.index',compact('projectsStatus'));
       }
    
       function profile(){
        $project = Project::all();
           return view('dashboards.users.profile',compact('project'));
       }
       function settings(){
           return view('dashboards.users.settings');
       }
       

       function delete($id){
        $user = User::find($id);
        if($user->role != 1)
            $user->delete();
            
        return redirect()->route('admin.profile');

    }

       function edit($id){
           $user = User::find($id);
           if($user->role == 1)
            return redirect()->route('admin.profile');
           return view('dashboards.admins.createUser',compact('user'));

       }

       function update(Request $request,$id){
        $user = User::findOrFail($id);
        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'phone'=>'required',
            'role'=>'required'
         ]);
         
        $user->name = $request->username;
        $user->email = $request->email;
        $user->role =$request->role;
        $user->phone = $request->phone;
        if( $user->save() ){

           return redirect()->back()->with('success','update successfully');
        }else{
            return redirect()->back()->with('error','Failed to update');
        }

        
    }


       function changePassword(Request $request){
        //Validate form
        $validator = \Validator::make($request->all(),[
            'oldpassword'=>[
                'required', function($attribute, $value, $fail){
                    if( !\Hash::check($value, Auth::user()->password) ){
                        return $fail(__('The current password is incorrect'));
                    }
                },
                'min:8',
                'max:30'
             ],
             'newpassword'=>'required|min:8|max:30',
             'cnewpassword'=>'required|same:newpassword'
         ],[
             'oldpassword.required'=>'Enter your current password',
             'oldpassword.min'=>'Old password must have atleast 8 characters',
             'oldpassword.max'=>'Old password must not be greater than 30 characters',
             'newpassword.required'=>'Enter new password',
             'newpassword.min'=>'New password must have atleast 8 characters',
             'newpassword.max'=>'New password must not be greater than 30 characters',
             'cnewpassword.required'=>'ReEnter your new password',
             'cnewpassword.same'=>'New password and Confirm new password must match'
         ]);

        if( !$validator->passes() ){
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
             
         $update = User::find(Auth::user()->id)->update(['password'=>\Hash::make($request->newpassword)]);

         if( !$update ){
             return response()->json(['status'=>0,'msg'=>'Something went wrong, Failed to update password in db']);
         }else{
             return response()->json(['status'=>1,'msg'=>'Your password has been changed successfully']);
         }
        }
    }
}
