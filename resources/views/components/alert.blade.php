@if ($errors->any())
    <div class="alert alert-danger mb-0">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="alert alert-success mb-0">
    {{$alertMessage}}
</div>


