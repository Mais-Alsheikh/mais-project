@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-2xl font-bold">أسئلة: {{ $lesson->title }}</h1>
            <p class="text-sm text-gray-600">الدورة: {{ $lesson->course->title }}</p>
        </div>
        <div>
            <a href="{{ route('questions.create', $lesson->id) }}" class="px-4 py-2 bg-green-600 text-white rounded">أضف سؤالاً جديداً</a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded shadow p-4">
        @if($questions->isEmpty())
            <p>لا توجد أسئلة لهذا الدرس.</p>
        @else
            <ul class="space-y-3">
                @foreach($questions as $q)
                    <li class="border p-3 rounded flex justify-between items-start">
                        <div>
                            <div class="font-semibold">{{ $q->body }}</div>
                            @if($q->type === 'mcq')
                                <div class="text-sm text-gray-600 mt-1">خيارات: {{ implode(' | ', $q->options ?? []) }}</div>
                                <div class="text-sm text-gray-600 mt-1">الإجابة الصحيحة: {{ $q->correct_answer }}</div>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('questions.edit', [$lesson->id, $q->id]) }}" class="px-2 py-1 bg-yellow-400 rounded">تعديل</a>
                            <form method="POST" action="{{ route('questions.destroy', [$lesson->id, $q->id]) }}">
                                @csrf
                                @method('DELETE')
                                <button class="px-2 py-1 bg-red-600 text-white rounded" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
