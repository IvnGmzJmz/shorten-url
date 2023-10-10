<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;


class LinkService
{
    const SHORT_URL_LENGTH = 9;
    const RANDOM_BYTES = 32;

    public function generateShortUrl() {
        $shortenedUrl = substr(
            base64_encode(
                sha1(
                    uniqid(
                        random_bytes(self::RANDOM_BYTES),
                        true
                    )
                )
            ),
            0,
            self::SHORT_URL_LENGTH
        );
    
        return $shortenedUrl;
    }
    

    public function hasShortUrl($inputShortUrl){
        return $inputShortUrl == null?$this->generateShortUrl():$inputShortUrl;
    }

    public function isUserAuthorized($link,$user){
        return $link->user_id !== $user->id;
    }

    public function validateLink($input) {
        $validator = Validator::make($input, [
            'title' => 'required',
            'url' => 'required'
        ]);   

        return $validator;
    }

    public function visitLink($numVisits) {
        return $numVisits + 1;
    }

    public function constructPaginationObject($link){
        return [
            'current_page' => $link->currentPage(),
            'last_page' => $link->lastPage(),
            'per_page' => $link->perPage(),
            'total' => $link->total()
        ];
    }

}