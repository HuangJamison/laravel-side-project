@extends('layouts.base')
@include('layouts.app')
@section('title', $title)
<h1>
    {{$title}}
</h1>
<div>
    I did a Laravel side project to demo CRUD Todos Pipeline by RESTful API. <br/>
    You can allocate this task to assigners, also watch their workload. Try and enjoy it. <br/>
    Extension: Production pipleline, factory job allocation. <br/>
    Next stage I want to do a feature to find person whose workload is minimal. You can allocate task by manual/auto system.
</div>
@include('todo.nav')