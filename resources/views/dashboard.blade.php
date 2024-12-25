<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="mb-6">
        <div class="bg-white dark:bg-boxdark overflow-hidden w-full sm:rounded-lg">
            <div class="p-3 flex justify-between items-center">
                <div class="px-2">
                    <h2 class="text-lg font-semibold text-gray-800">Dashboard</h2>
                    <p class="text-sm text-gray-500">Selamat datang di dashboard aplikasi insiden</p>
                </div>

                <div>
                    <form action="" method="get">
                        <input type="number" class="border border-gray-300 dark:border-gray-700 rounded-md px-2 py-1 w-[100px] text-sm" id="year" name="year" value="{{ $year ?? date('Y') }}" min="2021" max="{{ date('Y') }}" oninput="this.value = Math.abs(this.value)">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded-md ml-2">Filter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <div class="grid gap-4 grid-cols-2 md:grid-cols-3 xl:grid-cols-5">
            @foreach ($jenisInsiden as $key => $val)
            <div class="bg-white dark:bg-boxdark overflow-hidden shadow-lg shadow-gray-300/25 sm:rounded-2xl w-full">
                <div class="p-6 text-gray-800 dark:text-bodydark1 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-semibold">{{ $key }}</h2>
                        <p class="text-xs text-gray-500">{{ $val['name'] }}</p>
                    </div>

                    <div class="ml-4">
                        <span class="text-2xl font-semibold">{{ $val['count'] }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="flex items-stretch gap-4">
        <div class="bg-white dark:bg-boxdark overflow-hidden shadow-lg shadow-gray-300/25 sm:rounded-2xl w-2/3" id="chart-container">
            <div class="p-6 text-gray-800 dark:text-bodydark1">
                {{-- title and subtitle --}}
                <h2 class="text-lg font-semibold">Trend Insiden Tahun {{ $year ?? date('Y') }}</h2>
                <p class="text-sm text-gray-500">Jumlah insiden per bulan</p>

                {{-- chart --}}
                <canvas id="chart" class="max-h-[450px]"></canvas>
            </div>
        </div>

        <div class="flex gap-4 flex-col w-1/3" id="grading-container">
            @foreach ($gradingCount as $key => $val)
            <x-cards.grading-count
                title="{{ $key }}"
                :subtitle="\Str::contains($key, 'belum') ? 'Insiden ' . $key : 'Insiden dengan grading ' . $key"
                count="{{ $val }}"
                key="{{ $key }}"
            />
            @endforeach
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
                const trendData = @json($trendData);

                const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

                var ctx = document.getElementById('chart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Trend Insiden Tahun {{ $year ?? date("Y") }}',
                            data: labels.map(month => trendData[month] || 0),
                            backgroundColor: 'rgba(60, 80, 224, 0.2)',
                            borderColor: 'rgba(60, 80, 224, 1)',
                            borderWidth: 2,
                            fill: true,
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
    </script>
    @endpush
</x-app-layout>