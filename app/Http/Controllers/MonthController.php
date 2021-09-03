<?php

namespace App\Http\Controllers;

use App\Models\Month;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as REQ;
use Illuminate\Support\Facades\Validator;

class MonthController extends Controller
{
    public function getAllMonths($yearId)
    {

        $year = Year::find($yearId);
        if (!$year) return back() - with('message', 'Year not found');

        $months = Month::where('year_id', $year->id)->latest()->get();

        if (REQ::is('api/*'))
            return response()->json(['months' => $months]);
        return view('year')->with(['months' => $months, 'year' => $year]);
    }

    public function postMonth(Request $request, $yearId)
    {
        $year = Year::find($yearId);

        if (!$year) return back()->with('message', 'Year not found');

        $validator = Validator::make($request->all(), [
            'name' => 'required | unique:months',
        ]);

        if ($validator->fails()) {

            return  back()->withErrors($validator)->withInput();
        }

        $month = new Month();
        $month->name = $request->input('name');

        $year->months()->save($month);

        if (REQ::is('api/*'))
            return response()->json(['month' => $month], 200);
        return back()->with('message', 'Month Added successfully');
    }

    public function putMonth(Request $request, $monthId)
    {
        $month = Month::find($monthId);
        if (!$month) {
            return response()->json(['error' => 'Month not found'], 404);
        }

        $month->update([
            'name' => $request->input('name'),
        ]);

        $month->save();

        if (REQ::is('api/*'))
            return response()->json(['month' => $month], 200);
        return back()->with('message', 'Month edited successfully');
    }

    public function deleteMonth($monthId)
    {
        $month = Month::find($monthId);
        if (!$month) {
            return response()->json(['error' => 'Month does not exist'], 404);
        }

        $month->delete();
        if (REQ::is('api/*'))
            return response()->json(['message' => 'Month deleted successfully'], 200);
        return back()->with('message', 'Month deleted successfully');
    }


    public function getAllMedia($monthId)
    {
        $month = Month::find($monthId);
        if (!$month) return back()->with('message', 'Month not found');

        $pictures = $month->pictures;
        $videos = $month->videos;

        $year = Year::find($month->year_id);
        if (!$year) return back()->with('message', 'Year not found');
        $thisYear = $year->name;
        return view('month')->with(['month' => $month, 'thisYear' => $thisYear,   'pictures' => $pictures, 'videos' => $videos]);
    }
}
