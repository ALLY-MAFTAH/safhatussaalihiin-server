<?php

namespace App\Http\Controllers;

use App\Models\RadioName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request as REQ;


class RadioNameController extends Controller
{
    public function getAllRadioNames()
    {
        $radioNames = RadioName::latest()->get();
        foreach($radioNames as $radioName){
            $radioName->months;
        }

        if (REQ::is('api/*'))
            return response()->json(['radioNames' => $radioNames]);
        return view('radio_names')->with('radioNames', $radioNames);
    }

    public function postRadioName(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required | unique:radio_names',
            'description' => 'required',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->with('message', $validator->errors()->first());
        }

        $radioName = new RadioName();
        $radioName->name = $request->input('name');
        $radioName->description = $request->input('description');

        $radioName->save();

        if (REQ::is('api/*'))
            return response()->json(['radioName' => $radioName], 200);
        return back()->with('message', 'RadioName Added successfully');
    }

    public function putRadioName(Request $request, $radioNameId)
    {
        $radioName = RadioName::find($radioNameId);
        if (!$radioName) {
            return response()->json(['error' => 'RadioName not found'], 404);
        }

        $radioName->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        $radioName->save();

        if (REQ::is('api/*'))
            return response()->json(['radioName' => $radioName], 200);
        return back()->with('message', 'RadioName edited successfully');
    }

    public function deleteRadioName($radioNameId)
    {
        $radioName = RadioName::find($radioNameId);
        if (!$radioName) {
            return response()->json(['error' => 'RadioName does not exist'], 404);
        }

        $radioName->delete();
        if (REQ::is('api/*'))
            return response()->json(['message' => 'RadioName deleted successfully'], 200);
        return back()->with('message', 'Radio Name deleted successfully');
    }
}
