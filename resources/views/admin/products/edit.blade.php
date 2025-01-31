<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="__('Product Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $product->name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('description', $product->description) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="price" :value="__('Price')" />
                                <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full" :value="old('price', $product->price)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('price')" />
                            </div>

                            <div>
                                <x-input-label for="currency" :value="__('Currency')" />
                                <select id="currency" name="currency" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="USD" {{ old('currency', $product->currency) == 'USD' ? 'selected' : '' }}>USD</option>
                                    <option value="EUR" {{ old('currency', $product->currency) == 'EUR' ? 'selected' : '' }}>EUR</option>
                                    <option value="GBP" {{ old('currency', $product->currency) == 'GBP' ? 'selected' : '' }}>GBP</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('currency')" />
                            </div>

                            <div>
                                <x-input-label for="is_active" :value="__('Status')" />
                                <select id="is_active" name="is_active" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="1" {{ old('is_active', $product->is_active) ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active', $product->is_active) ? '' : 'selected' }}>Inactive</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('is_active')" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="image" :value="__('Product Image')" />
                            @if($product->image)
                                <div class="mt-2 mb-4">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded-lg">
                                </div>
                            @endif
                            <input type="file" id="image" name="image" accept="image/*" class="mt-1 block w-full" />
                            <p class="mt-1 text-sm text-gray-500">Upload a new product image (JPEG, PNG, GIF up to 2MB). Leave empty to keep the current image.</p>
                            <x-input-error class="mt-2" :messages="$errors->get('image')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update Product') }}</x-primary-button>
                            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
