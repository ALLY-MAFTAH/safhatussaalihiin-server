<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use App\Models\Stream;
use App\Models\Video;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class HomeController extends Controller
{
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $date = Carbon::now('GMT+3')->toDateString();
        // dd($date);

        if ($request['date']) {
            $date = $request['date'] ??  null;
        }
        $pictures = Picture::all();
        if ($date == null) {
            $filteredPictures = $pictures;
        } else {
            $filteredPictures = $pictures->filter(function ($picture) use ($date) {
                return $picture->date == $date;
            });
        }
        $videos = Video::all();
        if ($date == null) {
            $filteredVideos = $videos;
        } else {
            $filteredVideos = $videos->filter(function ($video) use ($date) {
                return $video->date == $date;
            });
        }
        $streams = Stream::all();
        foreach ($streams as $stream) {
            if ($stream->status == 0) {
                $stream->url = "";
            }
        }
        return view('home')->with(['videos' => $filteredVideos, 'pictures' => $filteredPictures, 'date' => $date, 'streams' => $streams,]);
    }

    public function changePasswordRoute()
    {
        return view('change_password');
    }

    public function changePassword(Request $request)
    {

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
        }

        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            //Current password and new password are same
            return redirect()->back()->with("error", "New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user_id = Auth::User()->id;
        $user = User::find($user_id);

        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect('home')->with('message', "Password Successfully Changed");
    }
}
