<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Query;
use App\Notifications\NewClientQuery;

class QueryController extends Controller
{
    public function create($business_id)
    {
        return view('client.query.create', compact('business_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'business_id' => 'required|exists:businesses,id',
            'message' => 'required|string',
        ]);

        $query = Query::create([
            'client_id' => Auth::id(),
            'business_id' => $request->business_id,
            'message' => $request->message,
        ]);

        // Notify business owner
        if ($query->business && $query->business->owner) {
            $query->business->owner->notify(new \App\Notifications\NewClientQuery($query));
        }

        return redirect()->route('client.dashboard')->with('success', 'Query sent!');
    }


    public function show($id)
    {
        $query = \App\Models\Query::findOrFail($id);

        // Mark as read if business has replied
        if ($query->response && !$query->read_by_client) {
            $query->update(['read_by_client' => true]);
        }

        return view('client.query.show', compact('query'));
    }
}
