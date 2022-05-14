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
        @if (!empty($assigners))
        <form id="todo-create-form" method="post" action="{{ url('/api/todo') }}">
            @csrf
            @method('POST')
            <div>
                Content: <input type="text" name="content" required />
            </div>
            <div id="assign-method">
                Assign method:
                <input type="radio" name="assign_method" value="designate" required /> designate
                <input type="radio" name="assign_method" value="automatic" required /> automatic
                <input type="radio" name="assign_method" value="random" required /> random
            </div>
            <div id="assigner" class="hide">
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
        @else
        <h1>No active assigners, please <a href="{{ url('/assigner/create') }}">create active assigners. </a></h1>
        @endif
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        const todo_form = $('#todo-create-form');
        todo_form.on("click", "#assign-method", function(e) {
            if (e.target.value === 'designate') {
                $('#assigner').removeClass('hide');
            } else {
                $('#assigner').addClass('hide');
            }
        });
        todo_form.submit(function(e) {
            e.preventDefault();
            const post_api = "<?= url('/api/todo'); ?>";
            const deadline = $('input[name = "deadline"]').val() + ' 00:00:00';
            if (new Date(deadline).getTime() < new Date().getTime()) {
                alert('Deadline should be after now!');
                return;
            }
            const data = $(this).serialize();
            $.ajax({
                'url': post_api,
                'method': 'post',
                'data': data,
                'success': function(res) {
                    if (res.message !== 'ok') {
                        alert('add todo something wrong!!');
                        return;
                    }
                    alert('add new todo successfully!');
                    window.location.href = "<?= url('/todos'); ?>";
                },
                'error': function(res) {
                    if (res.status === 422 && res.responseJSON) {
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