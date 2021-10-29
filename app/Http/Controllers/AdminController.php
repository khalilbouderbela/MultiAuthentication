<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
        function index(){

            $projectsStatus = DB::table('projects')
                 ->select('status', DB::raw('count(*) as nb'))
                 ->groupBy('status')
                 ->get();
                 
            $userssRoles = DB::table('users')
            ->select('role', DB::raw('count(*) as nb'))
            ->groupBy('role')
            ->get();
            foreach( $userssRoles as $us){
                switch($us->role){
                    case 1:$us->role="Admin";break;
                    case 2:$us->role="User";break;
                    case 3:$us->role="Manager";break;
                }
            }
            
            return view('dashboards.admins.index', compact('projectsStatus','userssRoles'));
       }
    
       function profile(){
        $user = User::where("role","!=",1)->get();
        $project = Project::all();
           return view('dashboards.admins.profile',compact('user','project'));
       }
       function settings(){
           return view('dashboards.admins.settings');
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
