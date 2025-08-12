<?php

namespace App\Http\Controllers;

use App\Models\SchoolReview;
use App\Models\School;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(){
        $total_school = School::count();
        $total_reviews = SchoolReview::count();
        $unread_messages = Message::whereDoesntHave('reads', function ($query) {
            $query->where('user_id', Auth::id());
        })
        ->count();

        return view('dashboard.index')->with([
            'total_school' => $total_school,
            'total_reviews' => $total_reviews,
            'unread_messages' => $unread_messages,
        ]);
    }

    public function changePassword(){

        return view('modules.user.profile.change_password');
    }

    public function passwordUpdate(Request $request){

        $request->validate([
            'old_password'    => 'required|string',
            'new_password'    => 'required|string',
            'password_confirmation'   =>'required|string|same:new_password',
        ]);

        $id = Auth::user()->id;
        //dd($id);
        $password_check = User::where('id',$id)->first();

        $check = \Hash::check($request->old_password, $password_check->password);
        if(@$check)
        {
            $user = User::where('id',$id)->update([
            'password'      => \Hash::make($request->new_password),
            ]);
            return redirect()->back()->with('success','Password changed successfully.');
        }
        else
        {
            return redirect()->back()->with('error','Wrong current password');
        }
    }
}
