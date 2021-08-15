<x-jet-dialog-modal wire:model="create">
    <x-slot name="title">
        <h2 class="font-medium text-base mr-auto">
            {{ ( $this->bank_id) ? trans('bank.edit-title') : trans('bank.add-title') }}
        </h2>
    </x-slot>

    <x-slot name="content">
        <div class="col-span-12 sm:col-span-6">
            <label for="formCode" class="form-label">{{ trans('global.code') }}</label>
            <input type="text" class="form-control" id="formCode" placeholder="Enter Code" wire:model="editing.code">
            @error('code') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-6">
            <label for="formName" class="form-label">{{ trans('global.name') }}</label>
            <input type="text" class="form-control" id="formName" placeholder="Enter Name" wire:model="editing.name">
            @error('name') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-6">
            <label for="formAddress" class="form-label">{{ trans('bank.address') }}</label>
            <input type="text" class="form-control" id="formAddress" placeholder="Enter Address" wire:model="editing.address">
            @error('address') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-6">
            <label for="formOtherAddress" class="form-label">{{ trans('bank.address') }}</label>
            <input type="text" class="form-control" id="formOtherAddress" placeholder="Enter Other Address" wire:model="editing.other_address">
            @error('other_address') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-6">
            <label for="formPhoneNo" class="form-label">{{ trans('bank.phone_no') }}</label>
            <input type="text" class="form-control" id="formPhoneNo" placeholder="Enter Phone No" wire:model="editing.phone_no">
            @error('phone_no') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-6">
            <label for="formSwiftCode" class="form-label">{{ trans('bank.swift_code') }}</label>
            <input type="text" class="form-control" id="formSwiftCode" placeholder="Enter Swift Code" wire:model="editing.swift_code">
            @error('swift_code') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div> 
    </x-slot>

    <x-slot name="footer">
        <button type="button" wire:click="closeModal()" class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">{{ trans('global.cancel-button') }}</button>
        <button type="button" wire:click.prevent="save()" class="btn btn-primary w-20">{{ trans('global.save-button') }}</button>
    </x-slot>
</x-jet-dialog-modal>