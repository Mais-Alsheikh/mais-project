@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">إنشاء نموذج امتحاني جديد</h1>

    <form action="{{ route('exams.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block mb-1">اختر الدورة</label>
            <select name="course_id" id="course_id" class="w-full p-2 border rounded">
                <option value="">-- اختر دورة --</option>
                @foreach($courses as $c)
                    <option value="{{ $c->id }}" @if(old('course_id') == $c->id) selected @endif>{{ $c->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1">عنوان النموذج</label>
            <input type="text" name="title" value="{{ old('title') }}" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">وصف (اختياري)</label>
            <textarea name="description" class="w-full p-2 border rounded">{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-1">المدة بالدقائق (اختياري)</label>
            <input type="number" name="duration_minutes" value="{{ old('duration_minutes') }}" class="w-full p-2 border rounded">
        </div>

        @if(isset($selectedCourse) && $questions->isNotEmpty())
            <div class="mb-4 bg-white rounded p-4 border">
                <h3 class="font-semibold mb-2">اختر الأسئلة من دورة: {{ $selectedCourse->title }}</h3>
                <p class="text-sm text-gray-600 mb-2">اختر الأسئلة التي تريد إضافتها للنموذج (يمكنك تحديد كل سؤال وترك النقاط الافتراضية).</p>

                @foreach($questions as $q)
                    <div class="mb-2 flex items-start gap-3">
                        <div><input type="checkbox" name="questions[]" value="{{ $q->id }}" id="q_{{ $q->id }}"></div>
                        <div>
                            <label for="q_{{ $q->id }}" class="font-semibold">{{ $q->body }}</label>
                            <div class="text-sm text-gray-600">درس: {{ $q->lesson->title }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif(request('course_id'))
            <p>لا يوجد أسئلة في هذه الدورة.</p>
        @endif

        <div>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">إنشاء النموذج</button>
            <a href="{{ route('exams.index') }}" class="ml-2 text-gray-600">عودة</a>
        </div>
    </form>
</div>
@endsection
