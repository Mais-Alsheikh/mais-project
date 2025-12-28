@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-2xl font-bold">إدارة أسئلة النموذج: {{ $exam->title }}</h1>
            <div class="text-sm text-gray-600">الدورة: {{ $exam->course->title }}</div>
        </div>
        <div>
            <a href="{{ route('exams.show', $exam->id) }}" class="px-3 py-2 bg-gray-200 rounded">عرض النموذج</a>
        </div>
    </div>

    <form action="{{ route('exams.questions.update', $exam->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="bg-white rounded p-4 border">
            <h3 class="font-semibold mb-2">اختر الأسئلة من دورة: {{ $exam->course->title }}</h3>

            @if($questions->isEmpty())
                <p>لا توجد أسئلة في هذه الدورة.</p>
            @else
                @foreach($questions as $q)
                    <div class="mb-2 flex items-start gap-3">
                        <div><input type="checkbox" name="questions[]" value="{{ $q->id }}" id="q_{{ $q->id }}" @if(in_array($q->id, $selected)) checked @endif></div>
                        <div>
                            <label for="q_{{ $q->id }}" class="font-semibold">{{ $q->body }}</label>
                            <div class="text-sm text-gray-600">درس: {{ $q->lesson->title }}</div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="mt-4">
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">حفظ الأسئلة</button>
            <a href="{{ route('exams.index') }}" class="ml-2 text-gray-600">عودة</a>
        </div>
    </form>
</div>
@endsection
