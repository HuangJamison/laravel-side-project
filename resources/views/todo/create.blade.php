@extends('layouts.base')
@include('layouts.app')
@section('title', $title)
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/todo.css') }}">
<div id="todo-create">
    <div class="title">
        {{$title}}
    </div>
    <nav>
        <a href="{{ url('/todo')}}">Get All Todos</a>
        <a href="{{ url('/todo/create')}}">Create</a>
        <a href="{{ url('/todo/update')}}">Update</a>
    </nav>
    <div class="todo-form">
        <form id="todo-create-form" method="post" action="{{ url('/api/todo') }}">
            @csrf
            @method('POST')
            <div>
                Content: <input type="text" name="content" required />
            </div>
            <div>
                Assigner: <input type="text" name="assigner" required />
            </div>
            <div>
                Content: <input type="date" name="deadline" required />
            </div>
            <input type="submit" value="submit" />
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        const todo_form = $('#todo-create-form');
        todo_form.submit(function(e) {
            e.preventDefault();
            const post_api = "<?= url('/api/todo'); ?>";
            $.ajax({
                'url': post_api,
                'method': 'post',
                'data': todo_form.serialize(),
                'success': function(res) {
                    if (res.message !== 'ok') {
                        alert('add todo something wrong!!');
                        return;
                    }
                    alert('add new todo successfully!');
                    window.location.href = "<?= url('/todo'); ?>";
                },
                'failure': function(res) {
                    alert('add todo something wrong!!');
                }
            })
        });
    });
</script>
