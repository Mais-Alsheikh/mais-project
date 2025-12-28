@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6 text-gray-700">
    إضافة درس جديد - {{ $course->title }}
</h1>

<form method="POST"
      action="{{ route('lessons.store', $course->id) }}"
      enctype="multipart/form-data"
      class="bg-white p-6 rounded shadow max-w-xl">

    @csrf

    <div class="mb-4">
        <label class="block mb-1">عنوان الدرس</label>
        <input type="text" name="title"
               class="w-full border rounded p-2"
               required>
    </div>

    <div class="mb-4">
        <label class="block mb-1">نوع الدرس</label>
        <select name="type" class="w-full border rounded p-2" required>
            <option value="video">فيديو</option>
            <option value="pdf">ملف PDF</option>
        </select>
    </div>

    <div class="mb-4">
        <label class="block mb-1">الملف</label>
        <input type="file" name="file"
               class="w-full border rounded p-2"
               required>
    </div>

    <button class="bg-indigo-600 text-white px-4 py-2 rounded">
        حفظ الدرس
    </button>

</form>
@endsection