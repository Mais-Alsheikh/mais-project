@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">إنشاء مستخدم جديد</h1>
{{-- اضافة تعديل للتجربة على الجيت هاب --}}
@if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.users.store') }}" class="bg-white p-6 rounded shadow">
    @csrf

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">الاسم</label>
        <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">البريد الإلكتروني</label>
        <input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">كلمة المرور</label>
        <input type="password" name="password" class="mt-1 block w-full border-gray-300 rounded-md" required>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">تأكيد كلمة المرور</label>
        <input type="password" name="password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md" required>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">الدور (اختياري)</label>
        <select name="role" class="mt-1 block w-full border-gray-300 rounded-md">
            <option value="">-- اختر دور --</option>
            @foreach($roles as $role)
                <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>{{ $role }}</option>
            @endforeach
        </select>
    </div>

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.users.index') }}" class="text-gray-600">إلغاء</a>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">إنشاء</button>
    </div>
</form>

@endsection
