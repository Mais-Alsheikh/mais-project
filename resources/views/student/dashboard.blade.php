@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">دوراتي التعليمية</h1>
        <p class="text-gray-600">استعرض وتابع الدورات المسجلة</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-r-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-md animate-fade-in">
            <div class="flex items-center">
                <svg class="h-6 w-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(auth()->user()->notifications->count())
        <div class="bg-blue-100 border-r-4 border-blue-500 text-blue-700 p-4 mb-6 rounded shadow-md">
            <div class="flex items-start">
                <svg class="h-6 w-6 mr-2 mt-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                </svg>
                <div class="flex-1">
                    <strong class="font-semibold">الإشعارات:</strong>
                    <ul class="mt-2 space-y-1">
                        @foreach(auth()->user()->notifications as $notification)
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">•</span>
                                <span>{{ $notification->data['message'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if(auth()->user()->courses->count() == 0)
        <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-xl p-16 text-center">
            <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <h3 class="text-2xl font-semibold text-gray-700 mb-2">لا توجد دورات مسجلة</h3>
            <p class="text-gray-500 mb-6">لم تسجل في أي دورة تعليمية بعد</p>
            <a href="{{ route('courses.index') }}" class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                تصفح الدورات المتاحة
            </a>
        </div>
    @else
        <div class="space-y-8">
            @foreach(auth()->user()->courses as $course)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                    <div class="bg-gradient-to-r from-purple-600 to-blue-600 p-6">
                        <h2 class="text-2xl font-bold text-white mb-2">{{ $course->title }}</h2>
                        <p class="text-purple-100">{{ $course->description }}</p>
                        <div class="flex items-center mt-4 text-white">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                            </svg>
                            <span>المدرس: {{ $course->teacher->name }}</span>
                        </div>
                    </div>

                    @if($course->lessons->count())
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-xl font-semibold text-gray-800">محتوى الدورة</h4>
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                    {{ $course->lessons->count() }} درس
                                </span>
                            </div>

                            <div class="space-y-4">
                                @foreach($course->lessons as $index => $lesson)
                                    <div class="border border-gray-200 rounded-lg overflow-hidden hover:border-blue-400 transition-all">
                                        <div class="bg-gray-50 p-4 flex items-center justify-between cursor-pointer" onclick="toggleLesson({{ $lesson->id }})">
                                            <div class="flex items-center space-x-3 space-x-reverse">
                                                <div class="bg-blue-600 text-white w-10 h-10 rounded-full flex items-center justify-center font-bold">
                                                    {{ $index + 1 }}
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-800">{{ $lesson->title }}</p>
                                                    <p class="text-sm text-gray-500">
                                                        @if($lesson->type === 'video')
                                                            <span class="inline-flex items-center">
                                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                                                                </svg>
                                                                فيديو
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center">
                                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                                                </svg>
                                                                ملف PDF
                                                            </span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                            <svg class="w-6 h-6 text-gray-400 transform transition-transform" id="arrow-{{ $lesson->id }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>

                                        <div id="lesson-{{ $lesson->id }}" class="hidden">
                                            <div class="p-4 bg-white">
                                                @if($lesson->type === 'video')
                                                    @if($lesson->video_url)
                                                        <div class="aspect-video bg-gray-900 rounded-lg overflow-hidden shadow-lg">
                                                            <iframe 
                                                                class="w-full h-full" 
                                                                src="{{ $lesson->video_url }}" 
                                                                frameborder="0" 
                                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                                allowfullscreen>
                                                            </iframe>
                                                        </div>
                                                    @else
                                                        <video controls class="w-full rounded-lg shadow-lg">
                                                            <source src="{{ asset('storage/'.$lesson->file_path) }}" type="video/mp4">
                                                            متصفحك لا يدعم تشغيل الفيديو
                                                        </video>
                                                    @endif
                                                @endif

                                                @if($lesson->type === 'pdf')
                                                    <div class="flex items-center justify-center p-8 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                                                        <div class="text-center">
                                                            <svg class="mx-auto h-16 w-16 text-red-500 mb-4" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                                            </svg>
                                                            <h4 class="text-lg font-semibold text-gray-700 mb-2">ملف PDF</h4>
                                                            <a href="{{ asset('storage/'.$lesson->file_path) }}" 
                                                               target="_blank"
                                                               class="inline-flex items-center bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition font-semibold shadow-md">
                                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                                </svg>
                                                                فتح الملف
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="p-6">
                            <div class="bg-gray-50 rounded-lg p-8 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <p class="text-gray-600">لا يوجد محتوى في هذه الدورة بعد</p>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
function toggleLesson(lessonId) {
    const content = document.getElementById('lesson-' + lessonId);
    const arrow = document.getElementById('arrow-' + lessonId);
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        arrow.style.transform = 'rotate(180deg)';
    } else {
        content.classList.add('hidden');
        arrow.style.transform = 'rotate(0deg)';
    }
}
</script>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}
</style>
@endsection