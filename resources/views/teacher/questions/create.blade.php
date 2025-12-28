@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">أضف سؤالاً لدرس: {{ $lesson->title }}</h1>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('questions.store', $lesson->id) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-1">نص السؤال</label>
            <textarea name="body" class="w-full p-2 border rounded" required>{{ old('body') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-1">النوع (text أو mcq)</label>
            <input type="text" name="type" value="{{ old('type','text') }}" class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-1">خيارات (اكتب كل خيار في سطر جديد) - فقط للـ mcq</label>
            <textarea name="options_raw" class="w-full p-2 border rounded">{{ old('options_raw') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-1">الإجابة الصحيحة (قيم واحدة إذا كانت mcq)</label>
            <input type="text" name="correct_answer" value="{{ old('correct_answer') }}" class="w-full p-2 border rounded">
        </div>

        <div>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">حفظ السؤال</button>
            <a href="{{ route('questions.lesson.index', $lesson->id) }}" class="ml-2 text-gray-600">عودة</a>
        </div>
    </form>
</div>
@endsection
