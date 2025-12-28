@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">تعديل الدرس</h1>
            <p class="text-gray-600">الدورة: <span class="font-semibold">{{ $lesson->course->title }}</span></p>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border-r-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('lessons.update', $lesson->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">عنوان الدرس</label>
                <input type="text" name="title" value="{{ old('title', $lesson->title) }}" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                    placeholder="أدخل عنوان الدرس" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">نوع المحتوى</label>
                <select name="type" id="type" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                    required>
                    <option value="video" {{ $lesson->type === 'video' ? 'selected' : '' }}>فيديو</option>
                    <option value="pdf" {{ $lesson->type === 'pdf' ? 'selected' : '' }}>ملف PDF</option>
                </select>
            </div>

            <div class="mb-6 {{ $lesson->type !== 'video' ? 'hidden' : '' }}" id="video-section">
                <label class="block text-gray-700 font-semibold mb-2">رابط الفيديو</label>
                <div class="flex gap-3">
                    <input type="url" name="video_url" id="video_url" value="{{ old('video_url', $lesson->video_url) }}"
                        class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                        placeholder="https://youtube.com/watch?v=...">
                    <button type="button" id="preview-btn" 
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold shadow-md hover:shadow-lg">
                        معاينة
                    </button>
                </div>
                <p class="text-sm text-gray-500 mt-2">يدعم روابط من: YouTube, Vimeo, Dailymotion</p>
                
                <div id="video-preview" class="mt-6 {{ $lesson->video_url ? '' : 'hidden' }}">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <label class="block text-gray-700 font-semibold mb-3">معاينة الفيديو</label>
                        <div class="aspect-video bg-gray-900 rounded-lg overflow-hidden shadow-lg">
                            <iframe id="video-iframe" class="w-full h-full" src="{{ $lesson->video_url ? $lesson->video_url : '' }}" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-6 {{ $lesson->type !== 'pdf' ? 'hidden' : '' }}" id="pdf-section">
                <label class="block text-gray-700 font-semibold mb-2">رفع ملف PDF جديد (اختياري)</label>
                @if($lesson->file_path)
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-3">
                        <p class="text-sm text-blue-800">الملف الحالي: {{ basename($lesson->file_path) }}</p>
                    </div>
                @endif
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition">
                    <input type="file" name="file" id="file" class="hidden" accept="application/pdf">
                    <label for="file" class="cursor-pointer">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">اضغط لاختيار ملف PDF جديد</p>
                        <p class="text-xs text-gray-500 mt-1">الحد الأقصى: 10MB</p>
                    </label>
                </div>
                <div id="file-name" class="mt-3 text-sm text-gray-600 hidden"></div>
            </div>

            <div class="flex gap-4 pt-6 border-t">
                <button type="submit" 
                    class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold shadow-md hover:shadow-lg">
                    حفظ التعديلات
                </button>
                <a href="{{ route('courses.edit', $lesson->course_id) }}" 
                    class="flex-1 bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition font-semibold text-center shadow-md hover:shadow-lg">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    const typeSelect = document.getElementById('type');
    const videoSection = document.getElementById('video-section');
    const pdfSection = document.getElementById('pdf-section');
    const videoInput = document.getElementById('video_url');
    const fileInput = document.getElementById('file');
    const videoPreview = document.getElementById('video-preview');
    const videoIframe = document.getElementById('video-iframe');
    const previewBtn = document.getElementById('preview-btn');
    const fileNameDiv = document.getElementById('file-name');

    typeSelect.addEventListener('change', function() {
        if (this.value === 'video') {
            videoSection.classList.remove('hidden');
            pdfSection.classList.add('hidden');
            videoInput.required = true;
            fileInput.required = false;
        } else {
            videoSection.classList.add('hidden');
            pdfSection.classList.remove('hidden');
            videoInput.required = false;
            fileInput.required = false;
        }
    });

    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            fileNameDiv.textContent = '✓ تم اختيار: ' + this.files[0].name;
            fileNameDiv.classList.remove('hidden');
        }
    });

    previewBtn.addEventListener('click', function() {
        const url = videoInput.value.trim();
        
        if (url === '') {
            alert('الرجاء إدخال رابط الفيديو');
            return;
        }

        let embedUrl = '';

        const youtubeRegex = /(?:youtube\.com\/(?:watch\?v=|live\/)|youtu\.be\/)([^&?\/\s]+)/;
        const youtubeMatch = url.match(youtubeRegex);
        if (youtubeMatch) {
            embedUrl = `https://www.youtube.com/embed/${youtubeMatch[1]}`;
        }

        const vimeoRegex = /vimeo\.com\/(\d+)/;
        const vimeoMatch = url.match(vimeoRegex);
        if (vimeoMatch) {
            embedUrl = `https://player.vimeo.com/video/${vimeoMatch[1]}`;
        }

        const dailymotionRegex = /dailymotion\.com\/video\/([^_\s]+)/;
        const dailymotionMatch = url.match(dailymotionRegex);
        if (dailymotionMatch) {
            embedUrl = `https://www.dailymotion.com/embed/video/${dailymotionMatch[1]}`;
        }

        if (embedUrl) {
            videoIframe.src = embedUrl;
            videoPreview.classList.remove('hidden');
            videoPreview.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } else {
            alert('رابط الفيديو غير صحيح. يرجى استخدام رابط من YouTube أو Vimeo أو Dailymotion');
            videoPreview.classList.add('hidden');
            videoIframe.src = '';
        }
    });
</script>
@endsection