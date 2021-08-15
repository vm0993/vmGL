<x-jet-dialog-modal wire:model="create">
    <x-slot name="title">
        {{ ( $this->category_id) ? trans('category.edit-title') : trans('category.add-title') }}
    </x-slot>
    <x-slot name="content">
        <div class="col-span-12 sm:col-span-6">
            <label for="formCode" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('global.code') }}</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formCode" placeholder="Enter Code" wire:model="editing.code">
            @error('editing.code') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-6">
            <label for="formName" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('global.name') }}</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formName" placeholder="Enter Name" wire:model="editing.name">
            @error('editing.name') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
    </x-slot>
    <x-slot name="footer">
        <button type="button" wire:click="closeModal" class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">{{ trans('global.cancel-button') }}</button>
        <button type="button" wire:click.prevent="save" class="btn btn-primary w-20">{{ trans('global.save-button') }}</button>
    </x-slot>
</x-jet-dialog-modal>