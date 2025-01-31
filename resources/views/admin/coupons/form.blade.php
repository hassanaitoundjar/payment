<div class="grid grid-cols-1 gap-6">
    <div>
        <x-label for="code" value="{{ __('Coupon Code') }}" />
        <x-input id="code" type="text" name="code" class="mt-1 block w-full" value="{{ old('code', $coupon->code ?? '') }}" required />
        <x-input-error :messages="$errors->get('code')" class="mt-2" />
    </div>

    <div>
        <x-label for="type" value="{{ __('Discount Type') }}" />
        <select id="type" name="type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
            <option value="fixed" {{ (old('type', $coupon->type ?? '') === 'fixed') ? 'selected' : '' }}>Fixed Amount</option>
            <option value="percentage" {{ (old('type', $coupon->type ?? '') === 'percentage') ? 'selected' : '' }}>Percentage</option>
        </select>
        <x-input-error :messages="$errors->get('type')" class="mt-2" />
    </div>

    <div>
        <x-label for="value" value="{{ __('Discount Value') }}" />
        <x-input id="value" type="number" name="value" class="mt-1 block w-full" value="{{ old('value', $coupon->value ?? '') }}" step="0.01" min="0" required />
        <x-input-error :messages="$errors->get('value')" class="mt-2" />
    </div>

    <div>
        <x-label for="valid_from" value="{{ __('Valid From') }}" />
        <x-input id="valid_from" type="date" name="valid_from" class="mt-1 block w-full" value="{{ old('valid_from', isset($coupon) ? $coupon->valid_from->format('Y-m-d') : '') }}" required />
        <x-input-error :messages="$errors->get('valid_from')" class="mt-2" />
    </div>

    <div>
        <x-label for="valid_until" value="{{ __('Valid Until (Optional)') }}" />
        <x-input id="valid_until" type="date" name="valid_until" class="mt-1 block w-full" value="{{ old('valid_until', isset($coupon) && $coupon->valid_until ? $coupon->valid_until->format('Y-m-d') : '') }}" />
        <x-input-error :messages="$errors->get('valid_until')" class="mt-2" />
    </div>

    <div>
        <x-label for="max_uses" value="{{ __('Maximum Uses (Optional)') }}" />
        <x-input id="max_uses" type="number" name="max_uses" class="mt-1 block w-full" value="{{ old('max_uses', $coupon->max_uses ?? '') }}" min="1" />
        <x-input-error :messages="$errors->get('max_uses')" class="mt-2" />
    </div>

    <div class="flex items-center">
        <input id="is_active" type="checkbox" name="is_active" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="1" {{ old('is_active', $coupon->is_active ?? true) ? 'checked' : '' }}>
        <x-label for="is_active" class="ml-2" value="{{ __('Active') }}" />
        <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
    </div>
</div>
