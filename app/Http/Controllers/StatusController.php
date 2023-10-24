<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusUpdateValidation;
use App\Http\Requests\StatusStoreValidation;
use Illuminate\Http\Request;
use App\Models\Status;

class StatusController extends Controller
{
    public function index()
    {
        $statuses = Status::orderby('created_at', 'desc')->paginate(5);
        return view("statuses.index", compact('statuses'));
    }

    public function create()
    {   

        $statuses = Status::get();
        return view("statuses.create", compact('statuses'));
    }

    public function store(StatusStoreValidation $request, Status $status)
    {
        $status->name = $request->name;

        $status->save();

        return redirect()->route("dashboard.statuses.index")->with('success', 'Status aangemaakt');
    }

    public function edit($id)
    {
        $status = Status::find($id);
        $statuses = Status::all();
        return view("statuses.edit", compact('statuses', 'status'));
    }
    


    public function update(StatusUpdateValidation $request, Status $status)
    {
        
        $status->name = $request->name;
        $status->save();

        return redirect()->route("dashboard.statuses.index")->with('success', 'Status aangepast');
    }

    public function destroy(Status $status)
    {

        $status->delete();

        return redirect()->route("dashboard.statuses.index")->with('success', 'Status verwijderd'); 
    }

    public function search(Request $request)
    {

        $query = $request->input('query');
        $statuses = Status::where('name', 'like', "%$query%")->paginate(5)->withQueryString();
        return view("statuses.index", ["statuses" => $statuses]);
    }
}
