@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-2xl font-bold">{{ $exam->title }}</h1>
            <div class="text-sm text-gray-600">الدورة: {{ $exam->course->title }}</div>
            <div class="text-sm text-gray-600">الأسئلة: {{ $exam->questions->count() }}</div>
        </div>
        <div>
            <a href="{{ route('exams.index') }}" class="px-3 py-2 bg-gray-200 rounded">عودة</a>
        </div>
    </div>

    <div class="bg-white rounded shadow p-4">
        @if($exam->questions->isEmpty())
            <p>لا توجد أسئلة في هذا النموذج.</p>
        @else
            <ol class="space-y-4 list-decimal pl-5">
                @foreach($exam->questions as $q)
                    <li>
                        <div class="font-semibold">{{ $q->body }}</div>
                        @if($q->type === 'mcq')
                            <div class="text-sm text-gray-600 mt-1">خيارات: {{ implode(' | ', $q->options ?? []) }}</div>
                        @endif
                    </li>
                @endforeach
            </ol>
        @endif
    </div>
</div>
@endsection
