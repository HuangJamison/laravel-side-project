<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use GuzzleHttp\Exception\RequestException;
use Spatie\Crawler;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;

class MyCrawler extends Crawler\CrawlObservers\CrawlObserver {

    public $data =[];

    public function crawled(UriInterface $url, ResponseInterface $response, ?UriInterface $foundOnUrl = null)
    {
        $parse_url = parse_url($url);
        $domain = $parse_url['host']; 
        $domCrawler = new DomCrawler((string) $response->getBody());
        $titles = $domCrawler->filter('div[class="r-ent"]')->filter('div[class="title"]')->filter('a')->each(function ($tree, $i) {
            return $tree->text();
        });
        $next_url = $domCrawler->filter('div[class="btn-group btn-group-paging"]')->filter('a')->eq(1)->first()->attr('href');
        if (!empty($next_url)) {
            $next_url = 'https://' . $domain . $next_url;
        }

        $this->data = [
            'titles' => $titles,
            'next_url' => $next_url
        ];
    }

    public function crawlFailed(UriInterface $url, RequestException $requestException, ?UriInterface $foundOnUrl = null)
    {
        echo $requestException->getMessage() . PHP_EOL;
    }
}