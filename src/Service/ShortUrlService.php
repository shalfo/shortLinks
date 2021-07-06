<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\ShortUrl;
use App\Utils\UrlEncoder;
use App\Repository\ShortUrlRepository;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class ShortUrlService
{
    //should be a config param, added here for visibility purposes
    public const APP_URL = "https://www.koahealth.com/";

    private $shortUrlRepository;
    private $cache;

    public function __construct(ShortUrlRepository $shortUrlRepository, CacheInterface $cache)
    {
        $this->shortUrlRepository = $shortUrlRepository;
        $this->cache = $cache;
    }

    public function create(string $url) 
    {
        //must make sure we receive a valid URL
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \Exception("invalid url");
        }

        $entry = new ShortUrl();
        $entry->setUrl($url)->setCreated(new \DateTime());

        //store entity in our database, build the encoded url from the inserted ID
        $shortUrlId = $this->shortUrlRepository->save($entry);
        return $this->buildShortUrl($shortUrlId);
    }

    public function fetchOriginalLink(string $shortUrl): ?string
    {
        $originalUrl = $this->cache->get($this->getCacheKey($shortUrl), function (ItemInterface $item) use ($shortUrl) {
            return $this->shortUrlRepository->find(UrlEncoder::decodeToId($shortUrl));
        });

        return !empty($originalUrl) ? $originalUrl : null;
    }

    public function buildShortUrl(int $itemId)
    {
        return self::APP_URL . "/" . UrlEncoder::encodeToShortString($itemId);
    }

    private function getCacheKey(string $slug)
    {
        return "short_url_" . $slug;
    }
}
