<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LinkValidation;
use App\Http\Response\LinkResponse;
use App\Models\Url;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{
    public function index()
    {
        //If auth user is admin show all url
        if(Auth::user()->is_admin){
            $urls = Url::with('user')->orderBy('created_at', 'desc')->paginate(10);
            return response(['urls'=> $urls]);

        }
        //If auth user is not admin show url which create this user
        else{
            $urls = Url::with('user')
                ->where('user_id',Auth::user()->id)
                ->orderBy('created_at', 'desc')->paginate(10);
            return response(['urls'=> $urls]);
            }   
    }

    public function store(LinkValidation $request)
    {
        $data = [
            'url' => $request->url,
            'code' => $request->code ? Str::slug($request->code) : Str::random(6),
            'expires_at' => $request->expires_at ? Carbon::parse($request->expires_at)->toDateTimeString() : Carbon::now()->addDay()->toDateTimeString(),
            'user_id' => optional(auth()->user())->id,
        ];
        $url = Url::create($data);

        return new LinkResponse($url);
    }
}
