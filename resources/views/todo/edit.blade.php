@extends('layouts.base')
@include('layouts.app')
@section('title', $title)
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/todo.css') }}">
<div id="todo-edit">
    <div class="title">
        {{$title}}
    </div>
    <nav>
        <a href="{{ url('/todo')}}">Get All Todos</a>
        <a href="{{ url('/todo/create')}}">Create</a>
    </nav>
    <form id="todo-update-form" method="post" action="{{ url('/api/todo/' . $todo->id) }}">
        @csrf
        @method('PATCH')
        <table class="todos-block">
            <tr>
                <th>id</th>
                <th>content</th>
                <th>assigner</th>
                <th>deadline</th>
                <th>is_completed</th>
                <th>is_deleted</th>
            </tr>
            <tr>
                <td>
                    {{ $todo->id }}
                </td>
                <td>
                    <input type="text" name="content" value="{{ $todo->content }}" required />
                </td>
                <td>
                    <input type="text" name="assigner" value="{{ $todo->assigner }}" required />
                </td>
                <td>
                    <input type="date" name="deadline" value="{{ $todo->deadline }}" required />
                </td>
                <td>
                    <input type="radio" name="is_completed" value="1" {{ ($todo->is_completed) ? 'checked' : '' }} />yes
                    <input type="radio" name="is_completed" value="0" required {{ ($todo->is_completed == 0) ? 'checked' : '' }} />no
                    <input type="hidden" name="completed_at" value="{{ $todo->completed_at }}" />
                </td>
                <td>
                    <input type="radio" name="is_deleted" value="1" {{ ($todo->is_deleted) ? 'checked' : '' }} />yes
                    <input type="radio" name="is_deleted" value="0" required {{ ($todo->is_deleted == 0) ? 'checked' : '' }} />no
                    <input type="hidden" name="deleted_at" value="{{ $todo->deleted_at }}" />
                </td>
                <input type="hidden" name="updated_at" value="{{ $todo->updated_at }}" />
            </tr>
        </table>
        <input type="submit" value="submit" />
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        const todo_form = $('#todo-update-form');
        todo_form.submit(function(e) {
            e.preventDefault();
            const patch_api = "<?= url('/api/todo/' . $todo->id) ?>";
            $.ajax({
                'url': patch_api,
                'method': 'post',
                'data': todo_form.serialize(),
                'success': function(res) {
                    if (res.message !== 'ok') {
                        alert('add todo something wrong!!');
                        return;
                    }
                    alert('update todo successfully!');
                    window.location.href = "<?= url('/todo'); ?>";
                },
                'failure': function(res) {
                    alert('add todo something wrong!!');
                }
            })
        });
    });
</script>
