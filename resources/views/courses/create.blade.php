@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">إضافة دورة جديدة</h1>

<form method="POST" action="{{ route('courses.store') }}" class="space-y-4">
    @csrf

    <div>
        <label class="block mb-1">اسم الدورة</label>
        <input type="text" name="title"
               class="w-full border rounded p-2" required>
    </div>

    <div>
        <label class="block mb-1">وصف الدورة</label>
        <textarea name="description"
                  class="w-full border rounded p-2" required></textarea>
    </div>

    <div>
        <label class="block mb-1">السعر ($)</label>
        <input type="number" name="price"
               class="w-full border rounded p-2" required>
    </div>

    <button class="bg-green-600 text-white px-4 py-2 rounded">
        حفظ الدورة
    </button>
</form>
@endsection