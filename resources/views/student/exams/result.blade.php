@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">نتيجة الامتحان: {{ $exam->title }}</h1>
    <div class="bg-white rounded p-4 border mb-4">
        <div>النقاط المكتسبة: <strong>{{ $result->score }}</strong></div>
        <div>النسبة المئوية: <strong>{{ $result->percentage }}%</strong></div>
        <div>تم التسليم في: <strong>{{ $result->submitted_at }}</strong></div>
    </div>

    <div class="bg-white rounded p-4 border">
        <h3 class="font-semibold mb-2">تفصيل الإجابات</h3>
        <ul class="space-y-2">
            @foreach($result->answers as $qid => $info)
                <li class="border p-3 rounded">
                    <div class="font-semibold">سؤال: {{ optional($exam->questions->firstWhere('id', $qid))->body }}</div>
                    <div class="text-sm text-gray-600 mt-1">إجابتك: {{ $info['submitted'] }}</div>
                    <div class="text-sm text-gray-600 mt-1">حالة: @if($info['correct'] === true) صحيحة @elseif($info['correct'] === false) خاطئة @else يحتاج تقييم يدوي @endif</div>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="mt-4">
        <a href="{{ route('student.exams.index') }}" class="px-3 py-2 bg-gray-200 rounded">عودة إلى نماذج الامتحانات</a>
    </div>
</div>
@endsection
