<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Query;
use App\Models\Business\Business;
use App\Notifications\ClientQueryReply;

class QueryController extends Controller
{
    public function index()
    {
        $business = Business::where('owner_id', Auth::id())->firstOrFail();
        $queries = Query::with('client')->where('business_id', $business->id)->latest()->get();

        return view('business.query.index', compact('queries'));
    }

    public function show($id)
    {
        $query = Query::with('client')->findOrFail($id);
        return view('business.query.show', compact('query'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate(['response' => 'required|string']);
        $query = Query::findOrFail($id);
        $query->update(['response' => $request->response]);

        if ($query->client) {
            $query->client->notify(new \App\Notifications\ClientQueryReply($query));
        }

        return back()->with('success', 'Reply sent!');
    }
}
