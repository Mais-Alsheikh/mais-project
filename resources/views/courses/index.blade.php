@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">كل الدورات</h1>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

@foreach($courses as $course)

    <div class="bg-white p-6 rounded shadow">

        <h2 class="text-xl font-semibold">{{ $course->title }}</h2>
        <p class="text-gray-600 mt-2">{{ $course->description }}</p>

        <p class="text-sm text-gray-500 mt-2">
            المدرس: {{ $course->teacher->name }}
        </p>

        @if(auth()->user()->hasRole('student'))
            @if(auth()->user()->courses->contains($course->id))
                <button class="mt-4 bg-gray-300 text-gray-700 px-4 py-2 rounded cursor-not-allowed">
                    مسجل مسبقًا
                </button>
            @else
                <form method="POST" action="{{ route('courses.enroll', $course->id) }}">
                    @csrf
                    <button class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        تسجيل بالدورة
                    </button>
                </form>
            @endif
        @else
            <div class="mt-4 text-sm text-gray-600">يمكن لحسابات الطلاب فقط التسجيل في الدورات</div>
        @endif

    </div>

@endforeach

</div>

@endsection