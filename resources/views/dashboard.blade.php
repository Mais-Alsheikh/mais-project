<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">
            لوحة التحكم
        </h2>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <div class="flex items-center justify-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m0-4a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <div class="text-sm text-gray-500">المستخدمين</div>
                    </div>
                    <div class="mt-3 text-3xl font-bold text-indigo-600">{{ $users ?? 0 }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <div class="flex items-center justify-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6l4 2"/></svg>
                        <div class="text-sm text-gray-500">الدورات</div>
                    </div>
                    <div class="mt-3 text-3xl font-bold text-yellow-600">{{ $courses ?? 0 }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <div class="flex items-center justify-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"/></svg>
                        <div class="text-sm text-gray-500">الدروس</div>
                    </div>
                    <div class="mt-3 text-3xl font-bold text-green-600">{{ $lessons ?? 0 }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <div class="flex items-center justify-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h8M8 11h8M8 15h8"/></svg>
                        <div class="text-sm text-gray-500">الاختبارات</div>
                    </div>
                    <div class="mt-3 text-3xl font-bold text-red-600">{{ $exams ?? 0 }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-right">
                <h3 class="text-lg font-semibold">مرحباً بك في لوحة التحكم</h3>
                <p class="mt-2 text-gray-600">هنا يمكنك متابعة الإحصائيات العامة للمنصة والتنقل لإدارة المحتوى.</p>
            </div>

            <div class="mt-6 bg-white p-6 rounded-lg shadow-sm">
                <div class="flex justify-end gap-2 mb-4">
                    <button id="lineBtn" class="px-3 py-1 bg-indigo-600 text-white rounded opacity-100">خطّي</button>
                    <button id="doughnutBtn" class="px-3 py-1 bg-yellow-600 text-white rounded opacity-60">دونات</button>
                </div>
                <h3 class="text-lg font-semibold mb-4 text-right">رسم بياني للإحصاءات</h3>
                <div id="chartContainer" class="mx-auto" style="max-width:800px;">
                    <canvas id="statsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('statsChart').getContext('2d');
        let statsChart = null;

        const baseData = {
            labels: ['المستخدمين','الدورات','الدروس','الاختبارات'],
            datasets: [{
                label: 'عدد',
                data: [{{ $users ?? 0 }}, {{ $courses ?? 0 }}, {{ $lessons ?? 0 }}, {{ $exams ?? 0 }}],
                backgroundColor: ['#6366F1','#F59E0B','#10B981','#EF4444'],
                borderColor: '#6366F1',
                fill: false,
                tension: 0.25
            }]
        };

        function setChartSize(type) {
            const container = document.getElementById('chartContainer');
            if (type === 'doughnut') {
                container.style.maxWidth = '320px';
            } else {
                container.style.maxWidth = '800px';
            }
        }

        function renderChart(type) {
            if (statsChart) statsChart.destroy();

            setChartSize(type);

            const cfg = {
                type: type,
                data: (type === 'doughnut') ? {
                    labels: baseData.labels,
                    datasets: [{ data: baseData.datasets[0].data, backgroundColor: baseData.datasets[0].backgroundColor }]
                } : baseData,
                options: {}
            };

            if (type === 'line') {
                cfg.options = {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                };
            } else if (type === 'doughnut') {
                cfg.options = {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: { legend: { position: 'bottom' } },
                    cutout: '60%'
                };
            }

            statsChart = new Chart(ctx, cfg);
        }

        // initial
        renderChart('line');

        document.getElementById('lineBtn').addEventListener('click', function () {
            renderChart('line');
            this.classList.add('opacity-100');
            this.classList.remove('opacity-60');
            document.getElementById('doughnutBtn').classList.remove('opacity-100');
            document.getElementById('doughnutBtn').classList.add('opacity-60');
        });

        document.getElementById('doughnutBtn').addEventListener('click', function () {
            renderChart('doughnut');
            this.classList.add('opacity-100');
            this.classList.remove('opacity-60');
            document.getElementById('lineBtn').classList.remove('opacity-100');
            document.getElementById('lineBtn').classList.add('opacity-60');
        });
    });
</script>
</x-app-layout>


<!-- هاد يلي بينعرض لما المستخدم يدخل على الداش بورد
 هاد داش بورد الاساسي تبع لارافيل بريز -->