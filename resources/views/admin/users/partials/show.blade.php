@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">تفاصيل المستخدم</h1>

<div class="bg-white p-6 rounded shadow">
    <p class="mb-2"><strong>الاسم:</strong> {{ $user->name }}</p>
    <p class="mb-2"><strong>البريد الإلكتروني:</strong> {{ $user->email }}</p>
    <p class="mb-2"><strong>الأدوار:</strong> {{ $user->roles->pluck('name')->join(', ') }}</p>
    <p class="mb-2"><strong>تاريخ الإنشاء:</strong> {{ $user->created_at->format('Y-m-d H:i') }}</p>

    <div class="mt-4">
        <a href="{{ route('admin.users.index') }}" class="text-gray-600">العودة</a>
        <a href="{{ route('admin.users.edit', $user->id) }}" class="text-yellow-600 ml-4">تعديل</a>
    </div>
</div>

@endsection
