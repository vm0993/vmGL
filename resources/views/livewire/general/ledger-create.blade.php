<x-jet-dialog-modal wire:model="create">
    <x-slot name="title">
        {{ ( $this->ledger_id) ? trans('ledger.edit-title') : trans('ledger.add-title') }}
    </x-slot>
    <x-slot name="content">
        <div class="col-span-12 sm:col-span-6">
            <label for="formCode" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('global.code') }}</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formCode" placeholder="Enter Code" wire:model="editing.code">
            @error('code') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-6">
            <label for="formName" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('global.name') }}</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formName" placeholder="Enter Name" wire:model="editing.name">
            @error('name') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-6">
            <label for="formAddress" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('ledger.address') }}</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formAddress" placeholder="Enter Address" wire:model="address">
            @error('address') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-6">
            <label for="formOtherAddress" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('ledger.other_address') }}</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formOtherAddress" placeholder="Enter Other Address" wire:model="address_other">
            @error('other_address') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-6">
            <label for="formPhoneNo" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('ledger.phone_no') }}</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formPhoneNo" placeholder="Enter Phone No" wire:model="phone_no">
            @error('phone_no') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-6">
            <label for="formFaxNo" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('ledger.fax_no') }}</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formFaxNo" placeholder="Enter Fax No" wire:model="fax_no">
            @error('fax_no') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-6">
            <label for="formPersonel" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('ledger.personel_name') }}</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formPersonel" placeholder="Enter Personel Name" wire:model="personel_name">
            @error('personel_name') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-6">
            <label for="formTaxNo" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('ledger.fax_no') }}</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formTaxNo" placeholder="Enter Tax Reg No" wire:model="tax_reg_no">
            @error('tax_reg_no') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-6">
            <label for="formAccountType" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('ledger.bank_id') }}</label>
            <select class="w-full border bg-white rounded px-3 py-2 outline-none" wire:model="bank_id" id="formAccountType" placeholder="Select Bank" >
                <option value="">{{ trans('global.select_bank') }}</option>
                @foreach ($banks as $bank)
                    <option value="{{ $bank->id }}">{{ $bank->code }} - {{ $bank->name }}</option>
                @endforeach
            </select>
            @error('bank_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-6">
            <label for="formBankAccount" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('ledger.bank_account') }}</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formBankAccount" placeholder="Enter Bank Account" wire:model="bank_account">
            @error('bank_account') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-12">
            <label for="formBeneficiary" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('ledger.beneficiary_name') }}</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formBeneficiary" placeholder="Enter Beneficiary Name" wire:model="beneficiary_name">
            @error('beneficiary_name') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
    </x-slot>
    <x-slot name="footer">
        <button type="button" wire:click="closeModal" class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">{{ trans('global.cancel-button') }}</button>
        <button type="button" wire:click.prevent="save" class="btn btn-primary w-20">{{ trans('global.save-button') }}</button>
    </x-slot>
</x-jet-dialog-modal>