@if (\Session::has('message'))
<div class="alert alert-{{ \Session::get('alert') }}">
    <ul>
        <li>{!! \Session::get('message') !!}</li>
    </ul>
</div>
@endif