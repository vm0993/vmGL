<div class="intro-y box col-span-12 p-4 bg-gray-300 rounded">
    <div class="mt-1">
        <div class="sm:grid grid-cols-3 gap-2">
            <div class="input-group">
                <div id="formStartDate" class="input-group-text whitespace-nowrap">{{ trans('cash-bank.start_date') }}</div>
                <input aria-describedby="formStartDate" type="date" wire:model.lazy="filters.start_date" class="form-control">
            </div>
            <div class="input-group">
                <div id="formEndDate" class="input-group-text whitespace-nowrap">{{ trans('cash-bank.end_date') }}</div>
                <input aria-describedby="formEndDate" type="date" wire:model.lazy="filters.end_date" class="form-control">
            </div>
        </div>
        <div class="sm:grid grid-cols-2 gap-2 mt-2">
            <div class="input-group">
                <div id="formDescription" class="input-group-text whitespace-nowrap">{{ trans('cash-bank.description') }}</div>
                <input aria-describedby="formDescription" type="text" wire:model.lazy="filters.description" class="form-control" placeholder="{{ trans('cash-bank.input.description') }}">
            </div>
            <div class="input-group">
                <div id="formAmount" class="input-group-text whitespace-nowrap">{{ trans('cash-bank.amount') }}</div>
                <input aria-describedby="formAmount" type="text" wire:model.lazy="filters.amount" class="form-control" placeholder="{{ trans('cash-bank.input.amount') }}">
            </div>
        </div>
    </div>
    <div class="text-right mt-2">
        <button wire:click="resetFilters" class="">Reset Filters</button>
    </div>
</div>