<?php

namespace App\Http\Controllers;

use App\Models\Month;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as REQ;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    public function getAllVideos(Request $request)
    {
        $date = null;

        if ($request['date']) {
            $date = $request['date'] ??  null;
        }
        $videos = Video::all();
        if ($date == null) {
            $filteredVideos = $videos;
        } else {
            $filteredVideos = $videos->filter(function ($video) use ($date) {
                return $video->date == $date;
            });
        }

        if (REQ::is('api/*'))
            return response()->json(['videos' => $videos], 200);
        return view('videos')->with(['videos' => $filteredVideos, 'date' => $date]);
    }

    // Get a single video
    public function getSingleVideo($videoId)
    {
        $video = Video::find($videoId);
        if (!$video) {
            return response()->json(['error' => "Video not found"], 404);
        }
        return response()->json(['video' => $video], 200);
    }

    // Post video
    public function postVideo(Request $request, $monthId)
    {
        $month = Month::find($monthId);

        if (!$month) return back()->with('message', 'Month not found');

        $this->file_path = null;

        // Validate if the request sent contains this parameters
        $validator = Validator::make($request->all(), [
            'file' => 'required',
            'date' => 'required',
            'title' => 'required',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('message', $validator->errors()->first());
        }

        if ($request->hasFile('file')) {
            $this->file_path = $request->file('file')->store('videos');
        } else return back()->with('message', 'Add a video file');

        $video = new Video();
        $video->date = $request->input('date');
        $video->title = $request->input('title');
        $video->file = $this->file_path;

        $month->videos()->save($video);

        if (REQ::is('api/*'))

            return response()->json(['video' => $video], 201);
        return back()->with('message', 'Video added successfully');
    }

    public function putVideo(Request $request, $videoId)
    {
        $video = Video::find($videoId);
        if (!$video) {
            return response()->json(['error' => 'Video not found'], 404);
        }
        $this->file_path = null;
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('message', $validator->errors()->first());
        }

        if ($request->hasFile('file')) {
            $this->file_path = $request->file('file')->store('videos');
        } else {
            $this->file_path = $video->file;
        }


        $video->update([
            'date' => $request->input('date'),
            'title' => $request->input('title'),
            'file' => $this->file_path
        ]);

        $video->save();

        if (REQ::is('api/*'))
            return response()->json(['video' => $video], 200);
        return back()->with('message', 'Video edited successfully');
    }

    // Delete video
    public function deleteVideo($videoId)
    {
        $video = Video::find($videoId);
        if (!$video) {
            return response()->json(['error' => 'Video does not exist'], 204);
        }

        $video->delete();

        if (REQ::is('api/*'))
            return response()->json(['video' => 'Video deleted successfully'], 200);
        return back()->with('message', 'Video deleted successfully');
    }

    public function viewVideoFile($videoId)
    {
        $video = Video::find($videoId);
        if (!$video) {
            return response()->json(['error' => 'Video not exists'], 404);
        }
        $pathToFile = storage_path('/app/public/' . $video->file);
        return response()->download($pathToFile);
    }
}
