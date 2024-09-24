@extends('layout.backend')
@section('content')
    <main>
        <div class="flex flex-col md:flex-row">
            @include('components.auth.login')
        </div>
    </main>
@endsection
