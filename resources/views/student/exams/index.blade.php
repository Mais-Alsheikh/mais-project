@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">نماذج الامتحانات المتاحة</h1>

    @if($exams->isEmpty())
        <p>لا توجد نماذج متاحة للدورات التي تسجلت بها.</p>
    @else
        <ul class="space-y-3">
            @foreach($exams as $exam)
                <li class="p-4 bg-white rounded border flex justify-between items-center">
                    <div>
                        <div class="font-semibold">{{ $exam->title }}</div>
                        <div class="text-sm text-gray-600">الدورة: {{ $exam->course->title }}</div>
                        <div class="text-sm text-gray-600">الأسئلة: {{ $exam->questions->count() }}</div>
                    </div>
                    <div>
                        <a href="{{ route('student.exams.show', $exam->id) }}" class="px-3 py-2 bg-indigo-600 text-white rounded">ابدأ الامتحان</a>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
