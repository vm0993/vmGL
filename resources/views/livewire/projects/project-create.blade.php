<x-jet-dialog-modal wire:model="create">
    <x-slot name="title">
        {{ ( $this->project_id) ? trans('project.edit-title') : trans('project.add-title') }}
    </x-slot>
    <x-slot name="content">
        <div class="col-span-12 sm:col-span-6">
            <label for="formCode" class="text-white">{{ trans('global.code') }}</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formCode" placeholder="Enter Code" wire:model="editing.code">
            @error('code') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-6">
            <label for="formName" class="text-white">{{ trans('global.name') }}</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formName" placeholder="Enter Name" wire:model="editing.name">
            @error('name') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-12">
            <label for="formLedger" class="text-white">{{ trans('project.ledger_id') }}</label>
            <select class="tom-select w-full" wire:model="editing.ledger_id" id="formLedger" placeholder="Select Client Name" >
                <option value="">{{ trans('project.select_client') }}</option>
                @foreach (\App\Helpers\FinanceHelper::getLedger(0) as $ledger)
                    <option value="{{ $ledger->id }}">{{ $ledger->name }}</option>
                @endforeach
            </select>
            @error('ledger_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-6">
            <label for="formContract" class="text-white">{{ trans('project.contract_no') }}</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formContract" placeholder="Enter Contract No" wire:model="editing.contract_no">
            @error('contract_no') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-6">
            <label for="formContractAmount" class="text-white">{{ trans('project.contract_amount') }}</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-right" id="formContractAmount" placeholder="Enter Contract Amount" wire:model="editing.contract_amount">
            @error('contract_amount') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-12">
            <label for="formContractTitle" class="text-white">{{ trans('project.contract_title') }}</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formContractTitle" placeholder="Enter Contract Title" wire:model="editing.contract_title">
            @error('contract_title') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
    </x-slot>
    <x-slot name="footer">
        <button type="button" wire:click="closeModal()" class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">{{ trans('global.cancel-button') }}</button>
        <button type="button" wire:click.prevent="save()" class="btn btn-primary w-20">{{ trans('global.save-button') }}</button>
    </x-slot>
</x-jet-dialog-modal>