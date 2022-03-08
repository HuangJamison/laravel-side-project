@extends('layouts.base')
@include('layouts.app')
@section('title', $title)
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/assigner.css') }}">
<div id="assigner-create">
    <div class="title">
        {{$title}}
    </div>
    @include('assigner.nav')
    <div class="assigner-form">
        <form id="assigner-create-form" method="post" action="{{ url('/api/assigner') }}">
            @csrf
            @method('POST')
            <div>
                Name: <input type="text" name="name" required />
            </div>
            <input type="submit" value="submit" />
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        const assigner_form = $('#assigner-create-form');
        assigner_form.submit(function(e) {
            e.preventDefault();
            const post_api = "<?= url('/api/assigner'); ?>";
            $.ajax({
                'url': post_api,
                'method': 'post',
                'data': assigner_form.serialize(),
                'success': function(res) {
                    if (res.message !== 'ok') {
                        alert('add assigner something wrong!!');
                        return;
                    }
                    alert('add new assigner successfully!');
                    window.location.href = "<?= url('/assigners'); ?>";
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
