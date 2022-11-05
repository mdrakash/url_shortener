<?php

namespace App\Http\Response;

use Illuminate\Contracts\Support\Responsable;

class LinkResponse implements Responsable
{
    /**
     * @var Url
     */
    protected $url;

    /**
     * Create a new instance.
     *
     * @param Url $url
     *
     * @return void
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        $shortUrl = route('url.redirect', ['code' => $this->url->code]);

        if ($request->wantsJson()) {
            return response([
                'id'          => $this->url->id,
                'code'        => $this->url->code,
                'url'         => $this->url->url,
                'short_url'   => $shortUrl,
                'counter'     => $this->url->counter,
                'expires_at'  => $this->url->expires_at,
                'user_id'     => optional($this->url->user)->id,
            ], 201);
        }

        return back()
            ->with('short_url', $shortUrl);
    }
}
