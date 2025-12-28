@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">تعديل الدورة</h1>

<form method="POST" action="{{ route('courses.update', $course->id) }}">
    @csrf
    @method('PATCH')

    <label class="block mb-2">عنوان الدورة:</label>
    <input type="text" name="title" value="{{ $course->title }}"
           class="border p-2 rounded w-full mb-4">

    <label class="block mb-2">الوصف:</label>
    <textarea name="description" class="border p-2 rounded w-full mb-4">{{ $course->description }}</textarea>

    <button type="submit"
            class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
        حفظ التعديلات
    </button>
</form>
@endsection