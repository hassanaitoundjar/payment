<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                        Thank you for your purchase!
                    </h2>
                    @if(isset($orderNumber))
                        <p class="mt-2 text-center text-sm text-gray-600">
                            Order #{{ $orderNumber }}
                        </p>
                    @endif
                    
                    <div class="mt-6 text-sm text-gray-500">
                        <p>We've received your payment and are processing your order.</p>
                        <p class="mt-2">You will receive an email confirmation shortly with your purchase details.</p>
                    </div>

                    <div class="mt-6">
                        <a href="/" class="text-blue-600 hover:text-blue-500">
                            Return to Homepage
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
