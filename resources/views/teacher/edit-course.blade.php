@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">تعديل الدورة</h1>

<form method="POST" action="{{ route('courses.update', $course->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-2">عنوان الدورة</label>
        <input type="text" name="title" value="{{ old('title', $course->title) }}"
               class="w-full border border-gray-300 rounded p-2" required>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-semibold mb-2">الوصف</label>
        <textarea name="description"
                  class="w-full border border-gray-300 rounded p-2" required>{{ old('description', $course->description) }}</textarea>
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        حفظ التعديلات
    </button>
</form>
@endsection