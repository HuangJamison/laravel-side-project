<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Spatie\Crawler;
use App\Services\MyCrawler;

class CrawlerService
{
    private $next_url = '';
    /**
     * getOrCreate
     *
     * @param Laravel\Socialite\Two\User $auth_user
     * @param string $identify_provider
     * @return void
     */
    public function ptt_crawler($url, $page_count)
    {
        $count = 0;
        $this->next_url = $url;
        $crawlerData = [];
        while ($count < $page_count && $this->next_url !== '') {
            $res = $this->ptt_crawler_single($this->next_url);
            $this->next_url = $res['next_url'];
            $crawlerData[] = $res['titles'];
            $count ++;
        }
        return $crawlerData;
    }

    private function ptt_crawler_single($url)
    {
        $myCrawler = new MyCrawler();
        Crawler\Crawler::create()
            ->setCrawlObserver($myCrawler)
            ->setDelayBetweenRequests(500)
            ->setCurrentCrawlLimit(1)
            ->startCrawling($url);
        return $myCrawler->data;
    }
}
