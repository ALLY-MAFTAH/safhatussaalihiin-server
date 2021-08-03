<?php

namespace App\Http\Controllers;

use App\Models\Stream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as REQ;
use Illuminate\Support\Facades\Validator;

class StreamController extends Controller
{
    public function getLiveStream()
    {
        $streams = Stream::all();

        if (REQ::is('api/*'))
            return response()->json(['streams' => $streams]);
        return view('live_stream')->with('streams', $streams);
    }

    public function postLiveStream(Request $request)
    {

        $attributes = $this->validate($request, [
            'cover' => ['required', 'file'],
            'url' => 'required',
            'type' => 'required',
        ]);

        $cover = $attributes['cover'];
        $attributes['cover'] = $cover->storeAs(
            'streams',
            time() . '.' . $cover->getClientOriginalExtension(),
            'public'
        );
        $attributes['status'] = true;
        Stream::create($attributes);

        return back()->with('message', 'Stream Added successfully');



        // $this->cover_path = null;

        // $validator = Validator::make($request->all(), [
        //     'url' => 'required',
        //     'cover' => 'required',
        //     'type' => 'required',

        // ]);

        // if ($validator->fails()) {

        //     return redirect()->back()->with('message', $validator->errors()->first());
        // }
        // if ($request->hasFile('cover')) {
        //     $this->cover_path = $request->file('cover')->store('streams');
        // } else return back()->with('message', 'Add a Cover file');

        // $stream = new Stream();
        // $stream->url = $request->input('url');
        // $stream->type = $request->input('type');
        // $stream->cover = $this->cover_path;

        // $stream->save();

        // if (REQ::is('api/*'))
        //     return response()->json(['stream' => $stream], 200);
        // return back()->with('message', 'Stream Added successfully');
    }

    public function toggleStatus(Request $request, Stream $stream)
    {
        $attributes = $this->validate($request, [
            'status' => ['required', 'boolean'],
        ]);

        $stream->update($attributes);

        return back();
    }

    public function putLiveStream(Request $request, $streamId)
    {
        $stream = Stream::find($streamId);
        if (!$stream) {
            return response()->json(['error' => 'Stream not found'], 404);
        }


        if ($request->hasFile('cover')) {
            $this->cover_path = $request->file('cover')->store('s$streams');
        } else {
            $this->cover_path = $stream->cover;
        }
        $stream->update([
            'url' => $request->input('url'),
            'type' => $request->input('type'),
            'cover' => $this->cover_path
        ]);

        $stream->save();

        if (REQ::is('api/*'))
            return response()->json(['stream' => $stream], 200);
        return back()->with('message', 'Stream edited successfully');
    }

    public function deleteLiveStream($streamId)
    {
        $stream = Stream::find($streamId);
        if (!$stream) {
            return response()->json(['error' => 'Stream does not exist'], 404);
        }

        $stream->delete();
        if (REQ::is('api/*'))
            return response()->json(['message' => 'Stream deleted successfully'], 200);
        return back()->with('message', 'Stream deleted successfully');
    }
    public function viewCoverFile($streamId)
    {
        $stream = Stream::find($streamId);
        if (!$stream) {
            return response()->json(['error' => 'Stream not exists'], 404);
        }
        $pathToFile = storage_path('/app/public/' . $stream->cover);
        return response()->download($pathToFile);
    }
}
