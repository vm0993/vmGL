<x-jet-dialog-modal wire:model="create">
    <x-slot name="title">
        <h2 class="font-medium text-base mr-auto">
            {{ ( $this->tax_id) ? trans('tax.edit-title') : trans('tax.add-title') }}
        </h2>
    </x-slot>
    <x-slot name="content">
        <div class="col-span-12 sm:col-span-3">
            <label for="formCode" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('global.code') }}</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formCode" placeholder="Enter Code" wire:model="editing.code">
            @error('editing.code') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-6">
            <label for="formName" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('global.name') }}</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formName" placeholder="Enter Name" wire:model="editing.name">
            @error('editing.name') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-3">
            <label for="formRate" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('global.rate') }}</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formRate" placeholder="Enter Rate" wire:model="editing.rate">
            @error('editing.rate') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-6">
            <label for="formPurchase" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('tax.purchase_id') }}</label>
                <select class="w-full border bg-white rounded px-3 py-2 outline-none" wire:model="editing.purchase_id" id="formPurchase" placeholder="Select Purchase Account" >
                <option value="">{{ trans('tax.purchase_account') }}</option>
                @foreach ($accounts as $acc)
                    <option value="{{ $acc->id }}">{{ $acc->account_no }} - {{ $acc->account_name }}</option>
                @endforeach
            </select>
            @error('editing.purchase_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-6">
            <label for="formSales" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('tax.sales_id') }}</label>
            <select class="w-full border bg-white rounded px-3 py-2 outline-none" wire:model="editing.sales_id" id="formSales" placeholder="Select Sales Account" >
                <option value="">{{ trans('tax.sales_account') }}</option>
                @foreach ($accounts as $acc)
                    <option value="{{ $acc->id }}">{{ $acc->account_no }} - {{ $acc->account_name }}</option>
                @endforeach
            </select>
            @error('editing.sales_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
    </x-slot>
    <x-slot name="footer">
        <button type="button" wire:click="closeModal" class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">{{ trans('global.cancel-button') }}</button>
        <button type="button" wire:click.prevent="save" class="btn btn-primary w-20">{{ trans('global.save-button') }}</button>
    </x-slot>
</x-jet-dialog-modal>
