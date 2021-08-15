<x-jet-dialog-modal wire:model="create">
    <x-slot name="title">
        {{ ( $this->personil_id) ? trans('personil.edit-title') : trans('personil.add-title') }}
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
        <div class="col-span-12 sm:col-span-12">
            <label for="formAddress" class="form-label">{{ trans('personil.address') }}</label>
            <input type="text" class="form-control" id="formAddress" placeholder="Enter Address" wire:model="editing.address">
            @error('address') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
    </x-slot>

    <x-slot name="footer">
        <button type="button" wire:click="closeModal" class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">{{ trans('global.cancel-button') }}</button>
        <button type="button" wire:click.prevent="save" class="btn btn-primary w-20">{{ trans('global.save-button') }}</button>
    </x-slot>
</x-jet-dialog-modal>