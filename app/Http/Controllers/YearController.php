<?php

namespace App\Http\Controllers;

use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as REQ;
use Illuminate\Support\Facades\Validator;

class YearController extends Controller
{
    public function getAllYears()
    {
        $years = Year::latest()->get();
        foreach($years as $year){
            $year->months;
        }

        if (REQ::is('api/*'))
            return response()->json(['years' => $years]);
        return view('media')->with('years', $years);
    }

    public function postYear(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->with('message', $validator->errors()->first());
        }

        $year = new Year();
        $year->name = $request->input('name');

        $year->save();

        if (REQ::is('api/*'))
            return response()->json(['year' => $year], 200);
        return back()->with('message', 'Year Added successfully');
    }

    public function putYear(Request $request, $yearId)
    {
        $year = Year::find($yearId);
        if (!$year) {
            return response()->json(['error' => 'Year not found'], 404);
        }

        $year->update([
            'name' => $request->input('name'),
        ]);

        $year->save();

        if (REQ::is('api/*'))
            return response()->json(['year' => $year], 200);
        return back()->with('message', 'Year edited successfully');
    }

    public function deleteYear($yearId)
    {
        $year = Year::find($yearId);
        if (!$year) {
            return response()->json(['error' => 'Year does not exist'], 404);
        }

        $year->delete();
        if (REQ::is('api/*'))
            return response()->json(['message' => 'Year deleted successfully'], 200);
        return back()->with('message', 'Year deleted successfully');
    }
}
