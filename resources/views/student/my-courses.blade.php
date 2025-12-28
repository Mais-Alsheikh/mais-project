@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6">دوراتي المسجّل بها</h1>

    @if($courses->count() == 0)
        <p class="text-gray-600">لم تسجّل بأي دورة بعد.</p>
    @else
        @foreach($courses as $course)
            <div class="bg-white p-4 rounded shadow mb-4">
                <h2 class="text-xl font-semibold">{{ $course->title }}</h2>
                <p class="text-gray-600">{{ $course->description }}</p>
                <p class="text-sm mt-2">المدرّس: {{ $course->teacher->name }}</p>
            </div>
        @endforeach
    @endif
</div>
@endsection