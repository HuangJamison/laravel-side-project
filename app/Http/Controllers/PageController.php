<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CrawlerService;
use Illuminate\Routing\Redirector;

class PageController extends Controller
{
    public function ptt_crawler(Request $request)
    {
        $data = [
            'title' => 'PTT Crawler',
            'crawler_wbsite' => $this->get_crawler_website()
        ];
        return view('crawler/index', $data);
    }

    private function get_crawler_website()
    {
        return [
            [
                'name' => 'Movies',
                'url' => 'https://www.ptt.cc/bbs/movie/index.html'
            ],
            [
                'name' => 'NBA',
                'url' => 'https://www.ptt.cc/bbs/NBA/index.html'
            ],
            [
                'name' => 'Soft Job',
                'url' => 'https://www.ptt.cc/bbs/Soft_Job/index.html'
            ]
        ];
    }

    public function crawler_titles(Request $request, CrawlerService $service)
    {
        $post_data = $request->only([
            'url',
            'page_count'
        ]);
        $crawler_result = $service->ptt_crawler($post_data['url'], $post_data['page_count']);
        return response()->json([
            "message" => "ok",
            "data" => $crawler_result
        ]);
    }
}
