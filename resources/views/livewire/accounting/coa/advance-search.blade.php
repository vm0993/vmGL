<div class="intro-y box col-span-12 p-4 bg-gray-300 rounded">
    <div class="mt-1">
        <div class="sm:grid grid-cols-2 gap-2">
            <div class="input-group">
                <div id="formAccountNo" class="input-group-text whitespace-nowrap">{{ trans('account.acc_no') }}</div>
                <input aria-describedby="formAccountNo" type="text" wire:model.lazy="filters.account_no" class="form-control" placeholder="{{ trans('account.input.account-no') }}">
            </div>
            <div class="input-group">
                <div id="formAccountName" class="input-group-text whitespace-nowrap">{{ trans('account.acc_name') }}</div>
                <input aria-describedby="formAccountName" type="text" wire:model.lazy="filters.account_name" class="form-control" placeholder="{{ trans('account.input.account-name') }}">
            </div>
        </div>
    </div>
    <div class="text-right mt-2">
        <button wire:click="resetFilters" class="">Reset Filters</button>
    </div>
</div>