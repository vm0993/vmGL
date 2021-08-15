<x-jet-dialog-modal wire:model="importCOA">
    <x-slot name="title">
        <h2 class="font-medium text-base mr-2">
            {{ ( $this->account_id) ? trans('account.import-title') : trans('account.import-title') }}
        </h2>
    </x-slot>

    <x-slot name="content">
        <div class="col-span-12 sm:col-span-12">
            <label for="formAccountType" class="form-label">{{ trans('account.acc_import') }}</label>
            <input id="excelFile" name="excelFile" type="file" class="form-control" wire:model="excelFile">
            @error('excelFile') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <p class="text-sm text-black">
            {{ $fileName }}
        </p>
    </x-slot>

    <x-slot name="footer">
        <button type="button" wire:click="closeImport" class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">{{ trans('global.cancel-button') }}</button>
        <button type="button" wire:click.prevent="importProcess" class="btn btn-primary w-20">{{ trans('global.import-button') }}</button>
    </x-slot>
</x-jet-dialog-modal>