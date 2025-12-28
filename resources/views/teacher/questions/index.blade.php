@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">إدارة الأسئلة</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($lessons as $lesson)
            <div class="p-4 border rounded bg-white">
                <h3 class="font-semibold">{{ $lesson->title }}</h3>
                <p class="text-sm text-gray-600">الدورة: {{ $lesson->course->title }}</p>
                <a href="{{ route('questions.lesson.index', $lesson->id) }}" class="inline-block mt-3 px-3 py-2 bg-indigo-600 text-white rounded">إدارة أسئلة الدرس</a>
            </div>
        @empty
            <p>لا توجد دروس حتى الآن</p>
        @endforelse
    </div>
</div>
@endsection
