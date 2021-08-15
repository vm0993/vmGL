<div class="intro-y box col-span-12 p-4 rounded">
    <div class="mt-1">
        <div class="sm:grid grid-cols-2 gap-2">
            <div class="input-group">
                <div id="formCode" class="input-group-text whitespace-nowrap">{{ trans('project.input.code') }}</div>
                <input aria-describedby="formCode" type="text" wire:model.lazy="filters.code" class="form-control" placeholder="{{ trans('project.input.code') }}">
            </div>
            <div class="input-group">
                <div id="formName" class="input-group-text whitespace-nowrap">{{ trans('project.input.name') }}</div>
                <input aria-describedby="formName" type="text" wire:model.lazy="filters.name" class="form-control" placeholder="{{ trans('project.input.name') }}">
            </div>
        </div>
        <div class="sm:grid grid-cols-2 gap-2 mt-2">
            <div class="input-group">
                <div id="formCode" class="input-group-text whitespace-nowrap">{{ trans('project.ledger_id') }}</div>
                <input aria-describedby="formCode" type="text" wire:model.lazy="filters.ledger_id" class="form-control" placeholder="{{ trans('project.input.ledger') }}">
            </div>
            <div class="input-group">
                <div id="formName" class="input-group-text whitespace-nowrap">{{ trans('project.contract_no') }}</div>
                <input aria-describedby="formName" type="text" wire:model.lazy="filters.contract_no" class="form-control" placeholder="{{ trans('project.input.contract') }}">
            </div>
        </div>
    </div>
    <div class="text-right mt-2">
        <button wire:click="resetFilters" class="">Reset Filters</button>
    </div>
</div>