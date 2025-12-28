@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-gray-700">لوحة الإدارة</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold">عدد المستخدمين</h2>
        <p class="text-2xl mt-2">{{ \App\Models\User::count() }}</p>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold">عدد الدورات</h2>
        <p class="text-2xl mt-2">{{ \App\Models\Course::count() }}</p>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold">الإشعارات</h2>
        <p class="text-2xl mt-2">{{ auth()->user()->notifications->count() }}</p>
    </div>

</div>
@endsection