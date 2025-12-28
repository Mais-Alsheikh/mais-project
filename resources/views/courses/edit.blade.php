@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">تعديل الدورة</h1>

<form method="POST" action="{{ route('courses.update', $course->id) }}">
    @csrf
    @method('PUT')

    <input name="title" value="{{ $course->title }}" class="w-full mb-3 p-2 border">
    <textarea name="description" class="w-full mb-3 p-2 border">{{ $course->description }}</textarea>
    <input name="price" value="{{ $course->price }}" class="w-full mb-3 p-2 border">

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        حفظ التعديل
    </button>
</form>
@endsection