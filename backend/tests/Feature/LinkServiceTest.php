<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Services\LinkService;

class LinkServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_generate_short_url(){
        $linkService = new LinkService();
        $shortUrl = $linkService->generateShortUrl();

        $this->assertIsString($shortUrl);
        $this->assertEquals(LinkService::SHORT_URL_LENGTH,strlen($shortUrl));
    }

    public function test_has_short_url() {
        $linkService = new LinkService();
        $inputShortUrl = 'customShortUrl';
        $result = $linkService->hasShortUrl($inputShortUrl);

        $this->assertEquals($inputShortUrl,$result);
        $result = $linkService->hasShortUrl(null);

        $this->assertIsString($result);
        $this->assertEquals(LinkService::SHORT_URL_LENGTH,strlen($result));
    }
}
