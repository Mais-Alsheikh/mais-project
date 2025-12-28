@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6 text-gray-700">لوحة المعلم</h1>

{{-- إشعارات النجاح --}}
@if(session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

{{-- زر إضافة دورة جديدة --}}
<a href="{{ route('courses.create') }}"
   class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 mb-4 inline-block">
   إضافة دورة جديدة
</a>

<hr class="my-6">

<h2 class="text-xl font-semibold mb-4 text-gray-700">دوراتي</h2>

@if(auth()->user()->taughtCourses->count() == 0)
    <p class="text-gray-600">ما عندك دورات لحد الآن</p>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach(auth()->user()->taughtCourses as $course)
            <div class="bg-white p-4 rounded shadow">
                <h3 class="font-bold">{{ $course->title }}</h3>
                <p class="text-gray-600">{{ $course->description }}</p>

                {{-- عرض الدروس --}}
                @if($course->lessons->count())
                    <div class="mt-4">
                        <h4 class="font-semibold text-sm mb-2">الدروس:</h4>
                        <ul class="list-disc ml-5 text-sm">
                            @foreach($course->lessons as $lesson)
                                <li>{{ $lesson->title }} ({{ $lesson->type }})</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mt-4 flex gap-2">
                    <a href="{{ route('courses.edit', $course->id) }}"
                       class="text-blue-600 underline">تعديل</a>

                    <form method="POST" action="{{ route('courses.destroy', $course->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 underline"
                                onclick="return confirm('هل أنت متأكد من حذف الدورة؟')">
                            حذف
                        </button>
                    </form>

                    <a href="{{ route('lessons.create', $course->id) }}"
                        class="text-green-600 underline">
                        إضافة درس
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection