@extends('layouts.base')
@include('layouts.app')
@section('title', $title)
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/todo.css') }}">
<div id="todo-create">
    <div class="title">
        {{$title}}
    </div>
    @include('todo.nav')
    <div class="todo-form">
        <form id="todo-create-form" method="post" action="{{ url('/api/todo') }}">
            @csrf
            @method('POST')
            <div>
                Content: <input type="text" name="content" required />
            </div>
            <div>
                Assigner: 
                <select name="assigner_id" required>
                    <option value="0">
                        --- please choose ---
                    </option>
                    @foreach ($assigners as $assigner)
                        <option value="{{ $assigner->id }}">
                            {{ $assigner->name ?? '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                Deadline: <input type="date" name="deadline" required />
            </div>
            <div>
                working_hours: <input type="number" name="working_hours" min="0" required />
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
                    window.location.href = "<?= url('/todos'); ?>";
                },
                'error': function(res) {
                    if  (res.status === 422 && res.responseJSON) {
                        let error = '';
                        Object.values(res.responseJSON.message).map((v, i) => {
                            error += `${v}, `;
                        });
                        alert(error);
                        return;
                    } 
                    alert('add todo something wrong!!');
                }
            })
        });
    });
</script>
