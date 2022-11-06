<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkValidation;
use App\Http\Response\LinkResponse;
use App\Models\Url;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //If auth user is admin show all url
        if(Auth::user()->is_admin){
            $urls = Url::with('user')->orderBy('created_at', 'desc')->paginate(10);
            return view('urls.index', compact('urls'));
        }
        //If auth user is not admin show url which create this user
        else{
            $urls = Url::with('user')
                ->where('user_id',Auth::user()->id)
                ->orderBy('created_at', 'desc')->paginate(10);
            return view('urls.index', compact('urls'));
        }   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('urls.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\LinkValidation $request
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $url = Url::findOrFail($id);

        return view('urls.edit', compact('url'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\LinkValidation  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LinkValidation $request, $id)
    {
        $url = Url::findOrFail($id);
        Cache::forget("url.{$url['code']}");

        $data = [
            'url' => $request->url,
            'code' => $request->code ? Str::slug($request->code) : Str::random(6),
            'expires_at' => $request->expires_at ?? Carbon::parse($request->expires_at)->toDateTimeString(),
            'user_id' => optional(auth()->user())->id,
        ];

        $url->update($data);

        return new LinkResponse($url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $url = Url::findOrFail($id);

        Cache::forget("url.{$url['code']}");

        $url->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return back()
            ->with('short_url', true);
    }

    /**
     * Redirect to url by its code.
     *
     * @param string $code
     *
     * @return \Illuminate\Http\Response
     */
    public function redirect($code)
    {
        $url = Cache::rememberForever("url.$code", function () use ($code) {
            return Url::whereCode($code)->first();
        });

        if ($url !== null) {
            if ($url->hasExpired()) {
                abort(404);
            }

            $url->increment('counter');

            return redirect()->away($url->url, $url->couldExpire() ? 302 : 301);
        }

        abort(404);
    }
}
