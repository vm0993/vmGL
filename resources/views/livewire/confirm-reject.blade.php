<x-jet-confirmation-modal wire:model="confirmingCancelation">
    <x-slot name="title">
        {{ trans('Cancel') }}
    </x-slot>

    <x-slot name="content">
        {{ trans('Are you sure you want to cancel? ') }}
    </x-slot>

    <x-slot name="footer">
        <button wire:click="$set('confirmingCancelation', false)" wire:loading.attr="disabled" class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">
            {{ trans('global.close-button') }}
        </button>

        <button class="btn btn-danger w-24" wire:click="reject({{ $confirmingCancelation }})" wire:loading.attr="disabled">
            {{ trans('global.reject-button') }}
        </button>
    </x-slot>
</x-jet-confirmation-modal>