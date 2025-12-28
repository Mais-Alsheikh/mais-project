@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">نماذج الامتحانات</h1>
        <a href="{{ route('exams.create') }}" class="px-4 py-2 bg-green-600 text-white rounded">إنشاء نموذج جديد</a>
    </div>

    @if($exams->isEmpty())
        <p>لا توجد نماذج امتحانات حتى الآن.</p>
    @else
        <ul class="space-y-3">
            @foreach($exams as $exam)
                <li class="p-4 bg-white rounded border flex justify-between items-center">
                    <div>
                        <div class="font-semibold">{{ $exam->title }}</div>
                        <div class="text-sm text-gray-600">الدورة: {{ $exam->course->title }}</div>
                        <div class="text-sm text-gray-600">الأسئلة: {{ $exam->questions->count() }}</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('exams.show', $exam->id) }}" class="px-2 py-1 bg-blue-500 text-white rounded">عرض</a>
                        <a href="{{ route('exams.questions.manage', $exam->id) }}" class="px-2 py-1 bg-yellow-400 rounded">إدارة الأسئلة</a>
                        <form method="POST" action="{{ route('exams.destroy', $exam->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="px-2 py-1 bg-red-600 text-white rounded" onclick="return confirm('هل تريد حذف النموذج؟')">حذف</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
