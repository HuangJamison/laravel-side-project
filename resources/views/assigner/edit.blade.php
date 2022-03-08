@extends('layouts.base')
@include('layouts.app')
@section('title', $title)
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/assigner.css') }}">
<div id="assigner-edit">
    <div class="title">
        {{$title}}
    </div>
    @include('assigner.nav')
    <form id="assigner-update-form" method="post" action="{{ url('/api/assigner/' . $assigner->id) }}">
        @csrf
        @method('PATCH')
        <table class="assigners-block">
            <tr>
                <th>id</th>
                <th>name</th>
                <th>is_deleted</th>
            </tr>
            <tr>
                <td>
                    {{ $assigner->id }}
                </td>
                <td>
                    <input type="text" name="name" value="{{ $assigner->name }}" required />
                </td>
                <td>
                    <input type="radio" name="is_deleted" value="1" {{ ($assigner->is_deleted) ? 'checked' : '' }} />yes
                    <input type="radio" name="is_deleted" value="0" required {{ ($assigner->is_deleted == 0) ? 'checked' : '' }} />no
                    <input type="hidden" name="deleted_at" value="{{ $assigner->deleted_at }}" />
                </td>
                <input type="hidden" name="updated_at" value="{{ $assigner->updated_at }}" />
            </tr>
        </table>
        <input type="submit" value="submit" />
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        const assigner_form = $('#assigner-update-form');
        assigner_form.submit(function(e) {
            e.preventDefault();
            const patch_api = "<?= url('/api/assigner/' . $assigner->id) ?>";
            $.ajax({
                'url': patch_api,
                'method': 'post',
                'data': assigner_form.serialize(),
                'success': function(res) {
                    if (res.message !== 'ok') {
                        alert('add assigner something wrong!!');
                        return;
                    }
                    alert('update assigner successfully!');
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
                    alert('add assigner something wrong!!');
                }
            })
        });
    });
</script>
