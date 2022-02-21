<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Route;
use App\Services\CrawlerService;
use GuzzleHttp\Client;
use Throwable;

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

    public function todo_page()
    {
        $data = [
            'title' => 'Todo List practice using RESTful API'
        ];
        return view('todo/index', $data);
    }

    public function todos()
    {
        try {
            // take all todos
            $req = Request::create(url('api/todo'), 'GET');
            $res = Route::dispatch($req);
            $res = json_decode($res->getContent());
            $todos = $res->data;
        } catch (\Exception $e) {
            throw new \Exception('Call GET api/todo/ with something wrong.');
        }

        $data = [
            'title' => 'All Todos',
            'todos' => $todos
        ];

        return view('todo/all', $data);
    }

    public function todo_create()
    {
        $data = [
            'title' => 'Todo Create'
        ];
        return view('todo/create', $data);
    }

    public function todo_edit($id)
    {
        if (!is_numeric($id)) {
            throw new \Exception('input id is not numeric');
        }
        try {
            // take  todo
            $req = Request::create(url('api/todo/' . $id), 'GET');
            $res = Route::dispatch($req);
            $res = json_decode($res->getContent());
            $todo = $res->data;
        } 
        catch (\Exception $e) {
            throw new \Exception("Not Found GET api/todo/{$id} with something wrong.");
        }
        $data = [
            'title' => 'Todo Edit',
            'todo' => $todo
        ];

        return view('todo/edit', $data);
    }
}
