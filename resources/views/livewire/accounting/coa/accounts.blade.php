<x-slot name="header">
    <h2 class="intro-y text-lg font-medium mt-5">
        {{ trans('account.title') }}
    </h2>
</x-slot>
<div class="grid grid-cols-12 gap-6 mt-2">
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
        <button wire:click="create" class="btn btn-primary shadow-md mr-2">{{ trans('global.create-new') }}</button> 
        <div class="dropdown">
            <button class="dropdown-toggle btn px-2 box text-gray-700 dark:text-gray-300" aria-expanded="false">
                <span class="w-5 h-5 flex items-center justify-center"> <x-feathericon-plus class="w-4 h-4"></x-feathericon-plus> </span>
            </button>
            <div class="dropdown-menu w-40">
                <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                    <a href="javascript:void();" wire:click="importCOA" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                        <x-feathericon-paperclip class="w-4 h-4 mr-2"></x-feathericon-paperclip>
                        <span>{{ trans('global.import') }}</span>
                    </a>
                    <a href="javascript:void();" wire:click="downloadExcel" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                        <x-feathericon-file-text class="w-4 h-4 mr-2"></x-feathericon-file-text>
                        <span>{{ trans('global.excel-export') }} </span>
                    </a>
                    <a href="javascript:void();" wire:click="downloadPDF" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                        <x-feathericon-file-text class="w-4 h-4 mr-2"></x-feathericon-file-text>
                        <span>{{ trans('global.pdf-export') }} </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="hidden md:block mx-auto text-gray-600">
            <button wire:click="toggleShowFilters">@if ($showFilters) {{ trans('global.hide') }} @endif {{ trans('global.advance_search') }}</button>
        </div>
        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
            <div class="w-56 relative text-gray-700 dark:text-gray-300">
                <input type="text" wire:model="filters.search" class="form-control w-56 box pr-10 placeholder-theme-13" placeholder="{{ trans('global.search') }}">
                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i> 
            </div>
        </div>
    </div>
    @if($showEditModal)
        @include('livewire.accounting.coa.create')
    @endif
    @if($showDeleteModal)
        @include('livewire.confirm-delete')
    @endif
    @if ($showFilters)
        @include('livewire.accounting.coa.advance-search')
    @endif
    @if($showImportModal)
        @include('livewire.accounting.coa.import')
    @endif
    @if($confirmingSuspend)
        @include('livewire.confirm-suspend')
    @endif
    @if($confirmingActivate)
        @include('livewire.confirm-activate')
    @endif
    <!-- BEGIN: Data List -->
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        <table class="table table-report -mt-2">
            <thead>
                <tr class="rounded-md bg-gray-400">
                    <th class="form-check"><input class="form-check-input text-white" type="checkbox" value="" wire:model="selectPage"></th>
                    <th class="text-white" sortable multi-column wire:click="sortBy('account_no')" :direction="$sorts['account_no'] ?? null">{{ trans('account.acc_no') }}</th>
                    <th class="text-white" sortable multi-column wire:click="sortBy('account_name')" :direction="$sorts['account_name'] ?? null">{{ trans('account.acc_name') }}</th>
                    <th class="text-white" sortable multi-column wire:click="sortBy('account_type')" :direction="$sorts['account_type'] ?? null">{{ trans('account.acc_type') }}</th>
                    <th class="text-white text-center" sortable multi-column wire:click="sortBy('is_jurnal')" :direction="$sorts['is_jurnal'] ?? null">{{ trans('account.is_jurnal') }}</th>
                    <th class="text-white" sortable multi-column wire:click="sortBy('account_balance')" :direction="$sorts['account_balance'] ?? null">{{ trans('account.acc_balance') }}</th>
                    <th class="text-white text-center" sortable multi-column wire:click="sortBy('status')" :direction="$sorts['status'] ?? null">{{ trans('global.status') }}</th>
                    <th class="text-center">{{ trans('global.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @if ($selectPage)
                    <tr class="intro-x bg-cool-gray-200" wire:key="row-message">
                        <td colspan="6">
                            @include('selected')
                        </td>
                    </tr>
                @endif
                @foreach($accounts as $account)
                <tr class="intro-x">
                    <td class="w-10"><input wire:model="selected" class="form-check-input" type="checkbox" value="{{ $account->id }}"></td>
                    <td class="w-40">
                        <a href="javascript:void();" wire:click="edit({{ $account->id }})">
                            <span class="font-medium text-theme-20 whitespace-nowrap">{{ $account->account_no }}</span>
                        </a>
                    </td>
                    <td>
                        <span class="font-medium whitespace-nowrap">{{ $account->account_name }}</span>
                    </td>
                    @forelse ($accType as $a => $type)
                        @if($a == $account->account_type)
                            <td class="w-40"><span class="font-medium whitespace-nowrap">{{ $type }}</span></td>
                        @endif
                    @empty
                        <td class="w-40"><span class="font-medium whitespace-nowrap">{{ trans('global.404') }}</span></td>
                    @endforelse
                    <td class="text-center">
                        <span class="font-medium whitespace-nowrap">{{ $account->is_jurnal == 1 ? trans('account.no_jurnal') : trans('account.yes_jurnal')  }}</span>
                    </td>
                    <td class="w-26 text-right"><span class="text-right justify-right font-medium whitespace-nowrap">{{ number_format($account->account_balance) }}</span></td>
                    <td class="text-center">
                        @if($account->status == 1)
                        <span class="font-medium whitespace-nowrap text-theme-21">{{ $account->status == 1 ? trans('account.suspend') : trans('account.active')  }}</span>
                        @else
                        <span class="font-medium whitespace-nowrap text-theme-20">{{ $account->status == 1 ? trans('account.suspend') : trans('account.active')  }}</span>
                        @endif
                    </td>
                    <td class="table-report__action w-20">
                        <div class="flex justify-center items-center">
                            @if($account->status == 1)
                            <button wire:click="confirmingActivate({{ $account->id }})" class="flex items-center text-theme-20 mr-3">
                                <x-feathericon-triangle class="w-4 h-4 mr-1"></x-feathericon-triangle>
                                <span>{{ trans('global.active-button') }} </span>
                            </button>
                            @else
                            <button wire:click="confirmingSuspend({{ $account->id }})" class="flex items-center mr-3">
                                <x-feathericon-slash class="w-4 h-4 mr-1"></x-feathericon-slash>
                                <span>{{ trans('global.suspend-button') }} </span>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- END: Data List -->
    <!-- BEGIN: Pagingation -->
    <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-right mt-3">
        {{ $accounts->links('pagination',['is_livewire' => true]) }}
    </div>
    <!-- END: Pagingation -->
</div>
