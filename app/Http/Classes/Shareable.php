<?php

namespace App\Http\Classes;

trait Shareable
{
    public function getShareUrl($type = 'facebook')
    {
        if ($type == 'facebook') {
            $query = urldecode(http_build_query([
                'app_id' => '3007092402689514',
                'href' => route('saudipens.post', $this->id),
                'display' => 'page',
                'title' => \Str::limit($this->name, 120)
                //'title' => urlencode($this->{\Arr::get($this->shareOptions, 'columns.title')})
            ]));

            return 'https://www.facebook.com/dialog/share?' . $query;
        }

        if ($type == 'twitter') {
            $query = urldecode(http_build_query([
                'url' => route('saudipens.post', $this->id),
                'text' => urlencode(\Str::limit($this->name, 120))
            ]));

            return 'https://x.com/intent/tweet?' . $query;
        }

        if ($type == 'whatsapp') {
            $query = urldecode(http_build_query([
                'text' => urlencode($this->name . ' ' . route('saudipens.post', $this->id)),
                'href' => route('saudipens.post', $this->id),
            ]));

            return 'https://wa.me/?' . $query;
        }

        if ($type == 'linkedin') {
            $query = urldecode(http_build_query([
                'url' => route('saudipens.post', $this->id),
                'summary' => urlencode($this->name)
            ]));

            return 'https://www.linkedin.com/shareArticle?mini=true&' . $query;
        }

        if ($type == 'pinterest') {
            $query = urldecode(http_build_query([
                'url' => route('saudipens.post', $this->id),
                'description' => urlencode($this->name)
            ]));

            return 'https://pinterest.com/pin/create/button/?media=&' . $query;
        }

        if ($type == 'google') {
            $query = urldecode(http_build_query([
                'url' => route('saudipens.post', $this->id),
            ]));

            return 'https://plus.google.com/share?' . $query;
        }
        
        if ($type == 'telegram') {
            $query = urldecode(http_build_query([
                'url' => route('saudipens.post', $this->id),
                'text' => urlencode($this->name . ' ' . route('saudipens.post', $this->id)),
            ]));

            return 'https://telegram.me/share/url?'.$query;
        }
        
    }
}