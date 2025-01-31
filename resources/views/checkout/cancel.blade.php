<x-guest-layout>
    <div class="min-h-screen bg-gray-50 flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow">
            <div>
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Payment Cancelled
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Your order has been cancelled. No payment was processed.
                </p>
            </div>

            <div class="mt-8 space-y-6">
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        If you experienced any issues during checkout, please try again or contact our support team.
                    </p>
                </div>

                <div class="flex items-center justify-center space-x-4">
                    <a href="/" class="text-gray-600 hover:text-gray-500">
                        Return to Home
                    </a>
                    <a href="{{ route('checkout.show', $order->product->checkout_link) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Try Again
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
