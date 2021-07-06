<?php

namespace App\Tests;

use App\Bridge;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ShortUrlServiceTest extends WebTestCase
{
    public function testBasicCreate()
    {
        $shortUrlService = Bridge::getService('App\Services\ShortUrlService');

        $startUrl = "http://" . time() . ".com";
        $shortUrl = $shortUrlService->create($startUrl);

        $this->assertIsString($shortUrl);
        $this->assertEquals(filter_var($shortUrl, FILTER_VALIDATE_URL), $shortUrl);

        $this->validateRedirection($shortUrl, $startUrl);

        $this->removeShortUrl($shortUrl);
    }

    public function testCreateWithSlug()
    {
        $shortUrlService = Bridge::getService('App\Services\ShortUrlService');
        $t = time();
        $startUrl = "https://guguel" . $t . ".com/";
        $expectedSlug = "guguel" . $t;
        $shortUrl = $shortUrlService->create($startUrl, $expectedSlug);

        $this->assertIsString($shortUrl);
        $this->assertEquals(filter_var($shortUrl, FILTER_VALIDATE_URL), $shortUrl);
        $this->assertEquals($shortUrl, $expectedSlug);

        $this->validateRedirection($shortUrl, $startUrl);

        $this->removeShortUrl($shortUrl);
    }

    public function testGetLinkBySlug()
    {
        $shortUrlService = Bridge::getService('App\Services\ShortUrlService');

        $startUrl = "http://" . time() . ".com";
        $shortUrl = $shortUrlService->create($startUrl);

        $this->assertIsString($shortUrl);
        $this->assertEquals(filter_var($shortUrl, FILTER_VALIDATE_URL), $shortUrl);

        $originalLink = $shortUrlService->fetchOriginalLink($shortUrl);
        $this->assertIsString($originalLink);
        $this->assertEquals($originalLink, $startUrl);

        $this->removeShortUrl($shortUrl);
    }

    private function validateRedirection(string $shortUrl, string $startUrl)
    {
        Utils::curl($shortUrl);
        $this->assertEquals(Utils::$lastRequestHeaders['location'], $startUrl);
    }
}
