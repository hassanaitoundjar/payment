<x-app-layout>
    {{-- <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
            
            <!-- Stats Grid -->
            <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Total Sales Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Sales</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ number_format($totalSales, 2) }} {{ $currency ?? 'USD' }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Orders Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Orders</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $totalOrders }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Products Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Products</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $totalProducts }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
                <!-- Recent Orders -->
                <div class="bg-white shadow rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Orders</h3>
                        <div class="mt-5">
                            <div class="flex flex-col">
                                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                        <div class="overflow-hidden">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    @forelse($recentOrders as $order)
                                                        <tr>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->order_number }}</td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->product->name }}</td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($order->amount, 2) }} {{ $order->currency }}</td>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                    {{ ucfirst($order->status) }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                                No orders yet
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Products -->
                <div class="bg-white shadow rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Top Products</h3>
                        <div class="mt-5">
                            <div class="space-y-4">
                                @forelse($topProducts as $product)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $product->name }}
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    {{ $product->orders_count }} orders
                                                </p>
                                            </div>
                                            <div class="ml-4">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $product->price }} {{ $product->currency }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="bg-gray-50 rounded-lg p-4 text-center text-sm text-gray-500">
                                        No products yet
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sales Chart -->
            <div class="mt-8">
                <div class="bg-white shadow rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Sales Over Time</h3>
                        <div class="mt-5">
                            <canvas id="salesChart" class="w-full" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- <script>
        const salesData = @json($salesOverTime);
        
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: salesData.map(item => item.date),
                datasets: [{
                    label: 'Sales',
                    data: salesData.map(item => item.total),
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            }
                        }
                    }
                }
            }
        });
    </script> --}}
    @endpush
</x-app-layout>
