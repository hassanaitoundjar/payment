<x-guest-layout>
    <div class="min-h-screen bg-gray-100">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Product Information -->
                            <div>
                                <h2 class="text-2xl font-bold mb-4">{{ $product->name }}</h2>
                                <p class="text-gray-600 mb-4">{{ $product->description }}</p>
                                
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-auto rounded-lg mb-4">
                                @endif

                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-2xl font-bold text-gray-900">
                                        {{ $product->currency }} {{ number_format($product->price, 2) }}
                                    </span>
                                </div>

                                <!-- Coupon Section -->
                                <div class="mt-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Have a coupon?</h3>
                                    
                                    @if(session('coupon_error'))
                                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                                            <span class="block sm:inline">{{ session('coupon_error') }}</span>
                                        </div>
                                    @endif

                                    @if(session('coupon_success'))
                                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                            <span class="block sm:inline">{{ session('coupon_success') }}</span>
                                        </div>
                                    @endif

                                    @if(session('discount_amount'))
                                        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                                            <span class="block sm:inline">
                                                Discount applied: {{ $product->currency }} {{ number_format(session('discount_amount'), 2) }}
                                            </span>
                                        </div>
                                    @endif

                                    <form action="{{ route('checkout.coupon') }}" method="POST" class="flex gap-4">
                                        @csrf
                                        <input type="hidden" name="checkout_link" value="{{ $product->checkout_link }}">
                                        <input type="text" 
                                               name="coupon_code" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                               placeholder="Enter coupon code">
                                        <button type="submit" 
                                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                            Apply
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Payment Section -->
                            <div class="space-y-6">
                                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Price</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ $product->currency }} {{ number_format($product->price, 2) }}
                                    </dd>
                                </div>

                                @if(session('discount_amount'))
                                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">Discount</dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            - {{ $product->currency }} {{ number_format(session('discount_amount'), 2) }}
                                        </dd>
                                    </div>
                                @endif

                                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Total</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ $product->currency }} {{ number_format($product->price - (session('discount_amount', 0)), 2) }}
                                    </dd>
                                </div>

                                <!-- Payment Method -->
                                <div class="pt-6 border-t border-gray-100">
                                    <h3 class="text-lg font-medium text-gray-900 mb-6">Payment Method</h3>
                                    
                                    <!-- Credit Card - Coming Soon -->
                                    <div class="mb-6">
                                        <div class="relative border border-gray-200 rounded-lg p-4 bg-gray-50">
                                            <div class="flex items-center justify-between mb-2">
                                                <div class="flex items-center space-x-3">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                                    </svg>
                                                    <span class="font-medium text-gray-700">Credit Card</span>
                                                </div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Coming Soon
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-500">Credit card payments will be available soon. For now, please use PayPal for secure payment.</p>
                                        </div>
                                    </div>

                                    <!-- PayPal Payment -->
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center space-x-3">
                                                <svg class="w-6 h-6 text-[#00A887]" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944 3.217a.785.785 0 0 1 .775-.654h7.648c3.394 0 5.745 2.46 5.745 5.576 0 4.897-4.445 8.076-9.23 8.076H7.76l-1.47 5.768a.357.357 0 0 1-.352.274.366.366 0 0 1-.092-.012l.23-.908zM12.27 5.097H6.455l-2.82 15.705h4.045l1.47-5.768a.785.785 0 0 1 .775-.654h2.122c4.445 0 8.695-2.916 8.695-7.541 0-2.788-2.122-5.026-5.230-5.026h-3.242v3.284z"/>
                                                </svg>
                                                <span class="font-medium text-gray-700">PayPal</span>
                                            </div>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Available
                                            </span>
                                        </div>

                                        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                                            <input type="hidden" name="cmd" value="_xclick">
                                            <input type="hidden" name="business" value="mariacamila.sc@hotmail.com">
                                            <input type="hidden" name="item_name" value="{{ $product->name }}">
                                            <input type="hidden" name="item_number" value="{{ $product->id }}">
                                            <input type="hidden" name="amount" value="{{ number_format($product->price - (session('discount_amount', 0)), 2, '.', '') }}">
                                            <input type="hidden" name="currency_code" value="{{ $product->currency }}">
                                            <input type="hidden" name="no_shipping" value="1">
                                            <input type="hidden" name="return" value="{{ route('checkout.success', ['orderNumber' => 'PENDING']) }}">
                                            <input type="hidden" name="cancel_return" value="{{ route('checkout.cancel', ['orderNumber' => 'PENDING']) }}">
                                            <input type="hidden" name="notify_url" value="{{ route('ipn.paypal') }}">
                                            <button type="submit" class="w-full bg-[#00A887] text-white px-4 py-2 rounded-lg hover:bg-[#008c72] transition-colors duration-200">
                                                Pay with PayPal
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
