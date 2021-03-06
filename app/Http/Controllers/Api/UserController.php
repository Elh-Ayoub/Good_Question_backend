<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Mail;

class UserController extends Controller
{
    public function index(){
        return User::all();
    }

    public function show($id){
        return User::find($id);
    }
    public function showUserPosts($id){
        return Post::where('author', $id)->get();
    }
    public function profile(){
        $user = Auth::user();
        return ['profile' => $user];
    }
    public function updateAvatar(Request $request){
        $validator = Validator::make($request->all(), [
            'image' => 'mimes:jpg,png|max:20000',
        ]);
        if($validator->fails()){
            return json_decode($validator->errors()->toJson());
        }
        if(Auth::user()){
          $user = Auth::user();  
        }
        if($request->user){
            $user = $this->show($request->user);
        }
        $image = $request->file('image');
        if($image){
            $fileName =str_replace(' ', '-', $user->login) . '.png';
            $image = $request->file('image')->store('public');
            $image1 = $request->file('image')->move(public_path('/profile-pictures'), $fileName);
            $user->profile_photo  = url('/profile-pictures/' . $fileName);
            DB::update('update users set profile_photo = ? where id = ?', [url('/profile-pictures/' . $fileName), $user->id]);
            return ['success' => 'Profile picture updated successfully!'];
        }
        return response()->json('error', 404);
    }
    public function deleteAvatar(Request $request){
        $user = Auth::user();  
        if($request->user){
            $user = User::find($request->user);
        }
        $name = substr($user->login, 0, 2);
        $defaulImgae = 'https://ui-avatars.com//api//?name='.$name.'&color=7F9CF5&background=EBF4FF';
        $user->update(['profile_photo' => $defaulImgae]);
        return ['success' => 'Avatar deleted successfully!'];
    }
    public function update(Request $request, $id){
        //return $request->all();
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'login' => 'string|between:5,30',
            'full_name' => 'string|between:5,30',
            'email' => 'string|email|max:100',
        ]);
        if($validator->fails()){
            return json_decode($validator->errors()->toJson());
        }
        $profile_photo = $user->profile_photo;
        if($user->login != $request->login && User::where('login', $request->login)->first()){
            return ['fail' => 'Login already exist!'];
        }
        if($user->email != $request->email && User::where('email', $request->email)->first()){
            return ['fail' => 'Email already exist!'];
        }
        if($request->login && !$request->file('profile_photo') && $user->login !== $request->login ){
            if(str_contains(parse_url($user->profile_photo, PHP_URL_PATH), '.png')){
                $filename = str_replace(' ', '-', $request->input('login')) . '.png';
                Storage::move(parse_url($user->profile_photo, PHP_URL_PATH),
                '/profile-pictures/' . $filename);
                $profile_photo = url('profile-pictures/'. $filename);
            }else{
                $profile_photo = 'https://ui-avatars.com//api//?name='.substr($request->login, 0, 2).'&color=7F9CF5&background=EBF4FF';
            }
        }
        $user->update(array_merge($request->all(), ['profile_photo' => $profile_photo]));
        return ['success' => 'Account Updated successfully!'];
    }
    public function updatePassword(Request $request, $id){
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string|min:8',
            'password' => 'required|string|confirmed|min:8',
        ]);
        if($validator->fails()){
            return json_decode($validator->errors()->toJson());
        }
        if(Hash::check($request->current_password, $user->password)){
            $user->update([
                'password' => bcrypt($request->password)
            ]);
            return ['success' => "Password updated successfully!"];
        }else{
            return ['error' => 'Password incorrect!'];
        }
    }
    public function sendemail(Request $request){
       // return $request->all();
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|between:5,30',
            'email' => 'required|string|email|max:100',
            'subject' => 'required|string|max:200',
            'message' => 'required|string',
        ]);
        if($validator->fails()){
            return json_decode($validator->errors()->toJson());
        }
        $data = array('name'=> $request->full_name,
          'email'=> $request->email,
          'subject' => $request->subject,
          'content' => $request->message,
        );
        Mail::send('Admin.Email.contactMail',$data, function($message ) use($data) {
            $message->to(env('MAIL_USERNAME'), 'Contact')->subject($data['subject']);
            $message->from($data['email'], $data['name']);
        });
        return ['success' => 'Email sent successfully!'];
    }
    public function destroy($id)
    {
        if(User::find($id)){
            User::destroy($id);
            return ['success' => 'Account deleted successfully!'];
        }else{
            return ['fail' => 'User account not found!'];
        }
    }
}
