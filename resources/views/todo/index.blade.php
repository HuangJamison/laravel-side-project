@extends('layouts.base')
@include('layouts.app')
@section('title', $title)
<h1>
    {{$title}}
</h1>
<div>
    I did a Laravel side project to demo CRUD Todo by RESTful API.
    Try and enjoy it.
    Extension: Production pipleline, factory job allocation.
    Have a working hours and name list to have an automation allocation to find the man who has the minimal job.
</div>
<nav>
    <a href="{{ url('/todo')}}">Get All Todos</a>
    <a href="{{ url('/todo/create')}}">Create</a>
</nav>