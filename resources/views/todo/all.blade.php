@extends('layouts.base')
@include('layouts.app')
@section('title', $title)
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/todo.css') }}">
<div id="todo-all">
    <div class="title">
        {{$title}}
    </div>
    @include('todo.nav')
    <table class="todos-block">
        <tr>
            <th>id</th>
            <th>content</th>
            <th>assigner</th>
            <th>deadline</th>
            <th>is_completed</th>
            <th>completed_at</th>
            <th>is_deleted</th>
            <th>deleted_at</th>
            <th>updated_at</th>
            <th>created_at</th>
            <th>button</th>
        </tr>
        @foreach ($todos as $todo)
            <tr>
                <td>
                    {{ $todo->id }}
                </td>
                <td>
                    {{ $todo->content ?? '' }}
                </td>
                <td>
                    {{ $todo->assigner ?? '' }}
                </td>
                <td>
                    {{ $todo->deadline ?? '' }}
                </td>
                <td>
                    {{ $todo->is_completed ? 'yes' : 'no' }}
                </td>
                <td>
                    {{ $todo->completed_at ?? 'none' }}
                </td>
                <td>
                    {{ $todo->is_deleted ? 'yes' : 'no' }}
                </td>
                <td>
                    {{ $todo->deleted_at ?? 'none' }}
                </td>
                <td>
                    {{ $todo->updated_at ? date('Y-m-d H:i:s', strtotime($todo->updated_at)) : 'none' }}
                </td>
                <td>
                    {{ $todo->created_at ? date('Y-m-d H:i:s', strtotime($todo->updated_at)) : 'none' }}
                </td>
                <td>
                    <a target="_blank" href="{{ url('todo/edit/') . '/' . $todo->id }}">
                        edit
                    </a> 
                </td>
            </tr>
        @endforeach
    </div>
</div>
