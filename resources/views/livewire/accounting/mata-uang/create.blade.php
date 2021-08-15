<x-jet-dialog-modal wire:model="create">
    <x-slot name="title">
        {{ ( $this->currenci_id) ? trans('currency.edit-title') : trans('currency.add-title') }}
    </x-slot>

    <x-slot name="content">
        <div class="col-span-12 sm:col-span-6">
            <x-jet-label for="formCode" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('currency.code') }}</x-jet-label>
            <x-jet-input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formCode" placeholder="Enter Code" wire:model="editing.code"/>
        </div>
        <div class="col-span-12 sm:col-span-6">
            <x-jet-label for="formName" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('currency.name') }}</x-jet-label>
            <x-jet-input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formName" placeholder="Enter Name" wire:model="editing.name"/>
        </div>
        <div class="col-span-12 sm:col-span-6">
            <x-jet-label for="formRate" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('currency.rate') }}</x-jet-label>
            <x-jet-input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formRate" placeholder="Enter Rate" wire:model="editing.rate"/>
        </div>
        <div class="col-span-12 sm:col-span-6">
            <x-jet-label for="formCodeFlag" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('currency.code-flag') }}</x-jet-label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formCodeFlag" placeholder="Enter Symbol" wire:model="editing.code_flag"/>
        </div>  
    </x-slot>

    <x-slot name="footer">
        <button type="button" wire:click="closeModal()" class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">{{ trans('global.cancel-button') }}</button>
        <button type="button" wire:click.prevent="save()" class="btn btn-primary w-20">{{ trans('global.save-button') }}</button>
    </x-slot>
</x-jet-dialog-modal>