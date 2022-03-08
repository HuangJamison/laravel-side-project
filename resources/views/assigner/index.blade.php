@extends('layouts.base')
@include('layouts.app')
@section('title', $title)
<h1>
    {{$title}}
</h1>
<div>
    I did a Laravel side project to demo CRUD assigner by RESTful API. <br/>
    Try and enjoy it. <br/>
    Extension: Production pipleline, factory job allocation. <br/>
    Have a working hours and name list to have an automation allocation to find the man who has the minimal job. <br/>
</div>
@include('assigner.nav')