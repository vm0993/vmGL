<x-jet-dialog-modal wire:model="create">
    <x-slot name="title">
        <h2 class="font-medium text-base mr-4">
            {{ ( $this->account_id) ? trans('account.edit-title') : trans('account.add-title') }}
        </h2>
    </x-slot>

    <x-slot name="content">
        <div class="col-span-12 sm:col-span-12">
            <label for="formAccountType" class="form-label">{{ trans('account.acc_type') }}</label>
            <select class="tom-select w-full" wire:model="account_type" id="formAccountType" placeholder="{{ trans('account.select_account') }}" >
                <option value="">{{ trans('account.select_account') }}</option>
                @foreach ($accType as $a => $type)
                    <option value="{{ $a }}">{{ $type }}</option>
                @endforeach
            </select>
            @error('account_type') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-6">
            <label for="formCode" class="form-label">{{ trans('account.acc_no') }}</label>
            <input type="text" class="form-control" id="formCode" placeholder="{{ trans('account.input.account-no') }}" wire:model="account_no">
            @error('account_no') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-6">
            <label for="formName" class="form-label">{{ trans('account.acc_name') }}</label>
            <input type="text" class="form-control" id="formName" placeholder="{{ trans('account.input.account-name') }}" wire:model="account_name">
            @error('account_name') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
    </x-slot>

    <x-slot name="footer">
        <button type="button" wire:click="closeModal" class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">{{ trans('global.cancel-button') }}</button>
        <button type="button" wire:click.prevent="save" class="btn btn-primary w-20">{{ trans('global.save-button') }}</button>
    </x-slot>
</x-jet-dialog-modal>