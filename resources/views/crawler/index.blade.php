@extends('layouts.base')
@include('layouts.app')
@section('title', $title)
<h1>
    {{$title}}
</h1>
<div class="crawl-block">
    <div class="crawl-notice">
        <h2>
            PTT Crawler
            Please choose the which PTT board you want to crawl. <br/>
            We offer three boards to demo the craweler.
        <h2/>
    </div>
    <div class="crawl-form">
        <form method="post" action="{{ url('/crawler_titles')}}">
            @csrf
            @method('POST')
            <h3>
                Please choose one website：
                <select name="url">
                    @foreach ($crawler_wbsite as $site)
                        <option value="{{ $site['url'] }}">
                            {{ $site['name'] }}
                        </option>
                    @endforeach
                </select><br/>
                how many pages do you want to crawl ? <input type="text" name="page_count" /><br/>
                <input type="submit" value="submit"/>
            </h3>
        </form>
    </div>
</div>