<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>أكاديمية الشمس</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex">

        {{-- Sidebar --}}
        @auth
            @include('layouts.sidebar')
        @endauth

        {{-- المحتوى الرئيسي --}}
        <div class="flex-1">
            @include('layouts.navigation')

            <main class="p-6">
                
                {{-- ✅ إشعار النجاح --}}
                @if (session('success'))
                    <div class="mb-6 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg shadow-sm animate-bounce">
                        <strong>✔️ {{ session('success') }}</strong>
                    </div>
                @endif

                {{-- 🔔 إشعارات قاعدة البيانات --}}
                @if(auth()->check() && auth()->user()->notifications->count())
                    <div class="mb-6 bg-blue-100 border border-blue-300 text-blue-800 px-4 py-3 rounded-lg shadow-sm">
                        <strong class="block mb-1">🔔 إشعاراتك:</strong>
                        <ul class="list-disc ml-6">
                            @foreach(auth()->user()->notifications as $notification)
                                <li>{{ $notification->data['message'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ $slot ?? '' }}
                {{-- إشعارات النجاح / الخطأ --}}
                    @if(session('success'))
                        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif
                @yield('content')
            </main>
        </div>

    </div>
</body>

</html>