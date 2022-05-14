<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Route;
use App\Services\CrawlerService;
use GuzzleHttp\Client;
use App\Models\Todo;
use App\Models\Assigner;
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
        $postData = $request->only([
            'url',
            'page_count'
        ]);
        $crawlerResult = $service->ptt_crawler($postData['url'], $postData['page_count']);
        return response()->json([
            "message" => "ok",
            "data" => $crawlerResult
        ]);
    }

    public function todo_page()
    {
        $data = [
            'title' => 'Todos Pipeline practice using RESTful API'
        ];
        return view('todo/index', $data);
    }

    public function todos()
    {
        try {
            // take all todos/assigner
            $req = Request::create(url('api/todo'), 'GET');
            $res = Route::dispatch($req);
            $res = json_decode($res->getContent());
            $todos = Todo::hydrate($res->data);
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
        try {
            $req = Request::create(url('api/active_assigners'), 'GET');
            $res = Route::dispatch($req);
            $res = json_decode($res->getContent());
            $assigners = $res->data;
        } catch (\Exception $e) {
            throw new \Exception("Not Found GET todo_create with something wrong.");
        }
        $data = [
            'title' => 'Todo Create',
            'assigners' => $assigners ?: []
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
            $req = Request::create(url('api/active_assigners'), 'GET');
            $res = Route::dispatch($req);
            $res = json_decode($res->getContent());
            $assigners = $res->data;
        } catch (\Exception $e) {
            throw new \Exception("Not Found GET api/todo/{$id} with something wrong.");
        }
        $data = [
            'title' => 'Todo Edit',
            'todo' => $todo,
            'assigners' => $assigners
        ];

        return view('todo/edit', $data);
    }

    public function assigners()
    {
        try {
            // take all assigners
            $req = Request::create(url('api/assigner'), 'GET');
            $res = Route::dispatch($req);
            $res = json_decode($res->getContent());
            $assigners = Assigner::hydrate($res->data);
        } catch (\Exception $e) {
            throw new \Exception('Call GET api/assigner/ with something wrong.');
        }

        $data = [
            'title' => 'Assigners',
            'assigners' => $assigners
        ];

        return view('assigner/all', $data);
    }

    public function assigners_workload_list()
    {
        try {
            // take all assigners
            $req = Request::create(url('api/assigner'), 'GET');
            $res = Route::dispatch($req);
            $res = json_decode($res->getContent());
            $assigners = Assigner::hydrate($res->data);
        } catch (\Exception $e) {
            throw new \Exception('Call GET api/assigner/ with something wrong.');
        }

        $data = [
            'title' => 'Assigners workload List',
            'assigners' => $assigners
        ];

        return view('assigner/workload_list', $data);
    }

    public function assigner_create()
    {
        $data = [
            'title' => 'Assigner Create'
        ];
        return view('assigner/create', $data);
    }

    public function assigner_edit($id)
    {
        if (!is_numeric($id)) {
            throw new \Exception('input id is not numeric');
        }
        try {
            // take  todo
            $req = Request::create(url('api/assigner/' . $id), 'GET');
            $res = Route::dispatch($req);
            $res = json_decode($res->getContent());
            $assigner = $res->data;
        } catch (\Exception $e) {
            throw new \Exception("Not Found GET api/todo/{$id} with something wrong.");
        }
        $data = [
            'title' => 'Assigner Edit',
            'assigner' => $assigner
        ];

        return view('assigner/edit', $data);
    }
}
