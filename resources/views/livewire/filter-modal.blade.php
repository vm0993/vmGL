<x-jet-dialog-modal wire:modal="showFilter({{ $this->report_id }})">
    <x-slot name="title">
       {{ $this->title }} Report
    </x-slot>
    <x-slot name="content">
        @if($this->start_date == 0 && $this->end_date == 1)
        <div class="col-span-12 sm:col-span-4"></div>       
        <div class="col-span-12 sm:col-span-4">
            <label for="formName" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('reports.as_of') }}</label>
            <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" wire:model="source_end_date">
            @error('source_end_date') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-4"></div>
        @else
        <div class="col-span-12 sm:col-span-6">
            <label for="formCode" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('reports.start_date') }}</label>
            <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" wire:model="source_start_date">
            @error('source_start_date') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-6">
            <label for="formName" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('reports.end_date') }}</label>
            <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" wire:model="source_end_date">
            @error('source_end_date') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        @endif
        @if($this->from_account_id == 1 && $this->to_account_id == 1)
        <div class="col-span-12 sm:col-span-6">
            <label for="formCode" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('reports.account_from') }}</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" wire:model="source_account_id">
            @error('source_account_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        <div class="col-span-12 sm:col-span-6">
            <label for="formName" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('reports.account_to') }}</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" wire:model="target_account_id">
            @error('target_account_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        @endif
        @if($this->project_id == 1)
        <div class="col-span-12 sm:col-span-6">
            <label for="formCode" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('reports.project_id') }}</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" wire:model="source_project_id">
            @error('source_project_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        @endif
        @if($this->warehouse_id == 1)
        <div class="col-span-12 sm:col-span-6">
            <label for="formName" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('reports.warehouse_id') }}</label>
            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" wire:model="source_warehouse_id">
            @error('source_warehouse_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
        </div>
        @endif
        
    </x-slot>
    <x-slot name="footer">
        <button wire:click="closeModal" wire:loading.attr="disabled" class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">
            {{ trans('global.close-button') }}
        </button>
        <button wire:click="downloadReport({{ $this->report_id }})" class="btn btn-danger w-24" wire:loading.attr="disabled">
            {{ trans('global.download-button') }}
        </button>
    </x-slot>
</x-jet-dialog-modal>