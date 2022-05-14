@extends('layouts.base')
@include('layouts.app')
@section('title', $title)
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/assigner.css') }}">
<div id="assigner-all">
    <div class="title">
        {{$title}}
    </div>
    @include('assigner.nav')
    <table class="assigner-block">
        <tr>
            <th>id</th>
            <th>name</th>
            <th>
                <p>contributions</p>
                <p>(completed_working_hours)</p>
            </th>
            <th>
                <p>now workload</p>
                <p>(unfinished_working_hours)</p>
            </th>
            <th>assigner_deleted</th>
            <th>deleted_at</th>
            <th>updated_at</th>
            <th>created_at</th>
        </tr>
        @foreach ($assigners as $assigner)
        <tr>
            <td>
                {{ $assigner->id }}
            </td>
            <td>
                {{ $assigner->name ?? '' }}
            </td>
            <td>
                {{ $assigner->todos->where('is_deleted', 0)->where('is_completed', 1)->sum('working_hours') }}
            </td>
            <td>
                {{ $assigner->todos->where('is_deleted', 0)->where('is_completed', 0)->sum('working_hours') }}
            </td>
            <td>
                {{ $assigner->is_deleted ? 'yes' : 'no' }}
            </td>
            <td>
                {{ $assigner->deleted_at ?? 'none' }}
            </td>
            <td>
                {{ $assigner->updated_at ? date('Y-m-d H:i:s', strtotime($assigner->updated_at)) : 'none' }}
            </td>
            <td>
                {{ $assigner->created_at ? date('Y-m-d H:i:s', strtotime($assigner->updated_at)) : 'none' }}
            </td>
        </tr>
        @endforeach
</div>