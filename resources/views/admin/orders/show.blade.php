<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Order Details') }} - {{ $order->order_number }}
            </h2>
            <a href="{{ route('admin.orders.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Back to Orders') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Order Information</h3>
                            <dl class="grid grid-cols-2 gap-4">
                                <dt class="text-sm font-medium text-gray-500">Order Number</dt>
                                <dd class="text-sm text-gray-900">{{ $order->order_number }}</dd>

                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="text-sm text-gray-900">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                           ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </dd>

                                <dt class="text-sm font-medium text-gray-500">Amount</dt>
                                <dd class="text-sm text-gray-900">{{ $order->amount }} {{ $order->currency }}</dd>

                                <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                                <dd class="text-sm text-gray-900">{{ ucfirst($order->payment_method) }}</dd>

                                <dt class="text-sm font-medium text-gray-500">Payment ID</dt>
                                <dd class="text-sm text-gray-900">{{ $order->payment_id ?? 'N/A' }}</dd>

                                <dt class="text-sm font-medium text-gray-500">Created At</dt>
                                <dd class="text-sm text-gray-900">{{ $order->created_at->format('M d, Y H:i') }}</dd>

                                <dt class="text-sm font-medium text-gray-500">Paid At</dt>
                                <dd class="text-sm text-gray-900">{{ $order->paid_at ? $order->paid_at->format('M d, Y H:i') : 'N/A' }}</dd>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Product Information</h3>
                            <dl class="grid grid-cols-2 gap-4">
                                <dt class="text-sm font-medium text-gray-500">Product Name</dt>
                                <dd class="text-sm text-gray-900">{{ $order->product->name ?? 'N/A' }}</dd>

                                <dt class="text-sm font-medium text-gray-500">Description</dt>
                                <dd class="text-sm text-gray-900">{{ $order->product->description ?? 'N/A' }}</dd>

                                @if($order->product && $order->product->services)
                                    <dt class="text-sm font-medium text-gray-500">Services</dt>
                                    <dd class="text-sm text-gray-900">
                                        <ul class="list-disc list-inside">
                                            @foreach(explode(',', $order->product->services) as $service)
                                                <li>{{ trim($service) }}</li>
                                            @endforeach
                                        </ul>
                                    </dd>
                                @endif
                            </dl>
                        </div>
                    </div>

                    @if($order->status === 'pending')
                        <div class="mt-6 border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Update Order Status</h3>
                            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')
                                
                                <div>
                                    <x-input-label for="status" :value="__('Status')" />
                                    <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('status')" />
                                </div>

                                <div>
                                    <x-primary-button>{{ __('Update Status') }}</x-primary-button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
