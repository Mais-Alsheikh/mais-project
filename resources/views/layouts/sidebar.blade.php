<aside class="w-64 bg-indigo-700 text-white min-h-screen p-5">
    <h2 class="text-xl font-bold mb-6">القائمة</h2>

    <ul class="space-y-3">

        @role('admin')
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="block px-3 py-2 rounded hover:bg-indigo-500">
                    لوحة الإدارة
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}"
                   class="block px-3 py-2 rounded hover:bg-indigo-500">
                    إدارة المستخدمين
                </a>
            </li>
        @endrole

        @role('teacher')
            <li>
                <a href="{{ route('teacher.dashboard') }}"
                   class="block px-3 py-2 rounded hover:bg-indigo-500">
                    لوحة المعلم
                </a>
            </li>
            <li>
                <a href="{{ route('teacher.my-courses') }}"
                   class="block px-3 py-2 rounded hover:bg-indigo-500">
                    دوراتي
                </a>
            </li>
            <li>
                <a href="{{ route('questions.index') }}"
                   class="block px-3 py-2 rounded hover:bg-indigo-500">
                    أسئلة الدروس
                </a>
            </li>
            <li>
                <a href="{{ route('exams.index') }}"
                   class="block px-3 py-2 rounded hover:bg-indigo-500">
                    نماذج الامتحانات
                </a>
            </li>
        @endrole

        @role('student')
            <li>
                <a href="{{ route('student.dashboard') }}"
                   class="block px-3 py-2 rounded hover:bg-indigo-500">
                    لوحة الطالب
                </a>
            </li>
            <li>
                <a href="{{ route('student.my-courses') }}"
                   class="block px-3 py-2 rounded hover:bg-indigo-500">
                    دوراتي
                </a>
            </li>
            <li>
                <a href="{{ route('student.exams.index') }}"
                   class="block px-3 py-2 rounded hover:bg-indigo-500">
                    نماذج الامتحانات
                </a>
            </li>
        @endrole

    </ul>
</aside>