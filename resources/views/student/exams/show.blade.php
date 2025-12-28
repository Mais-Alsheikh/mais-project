@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">{{ $exam->title }}</h1>
    <p class="text-sm text-gray-600 mb-4">الدورة: {{ $exam->course->title }}</p>

    <form action="{{ route('student.exams.submit', $exam->id) }}" method="POST">
        @csrf

        @foreach($exam->questions as $question)
            <div class="mb-4 p-4 bg-white rounded border">
                <div class="font-semibold">{{ $question->body }}</div>
                @if($question->type === 'mcq')
                    @foreach($question->options ?? [] as $opt)
                        <div class="mt-2">
                            <label class="inline-flex items-center">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $opt }}"> <span class="mr-2">{{ $opt }}</span>
                            </label>
                        </div>
                    @endforeach
                @else
                    <div class="mt-2">
                        <textarea name="answers[{{ $question->id }}]" class="w-full p-2 border rounded"></textarea>
                    </div>
                @endif
            </div>
        @endforeach

        <div>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">أرسل الإجابات</button>
            <a href="{{ route('student.exams.index') }}" class="ml-2 text-gray-600">عودة</a>
        </div>
    </form>
</div>
@endsection
