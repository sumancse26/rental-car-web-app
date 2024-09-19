@extends('layout.backend')

@section('content')
    @include('components.dashboard.navbar')
    <main>
        <div class="flex flex-col md:flex-row">
            @include('components.dashboard.sidenav')
            @include('components.dashboard.user.user-list')
        </div>
    </main>
@endsection
