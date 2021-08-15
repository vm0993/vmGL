<x-slot name="header">
    <h2 class="intro-y text-lg font-medium mt-10">
        {{ trans('currency.title') }}
    </h2>
</x-slot>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
        <button wire:click="create" class="btn btn-primary shadow-md mr-2">{{ trans('global.create-new') }}</button>
        <div class="dropdown">
            <button class="dropdown-toggle btn px-2 box text-gray-700 dark:text-gray-300" aria-expanded="false">
                <span class="w-5 h-5 flex items-center justify-center"> <x-feathericon-plus class="w-4 h-4"></x-feathericon-plus> </span>
            </button>
            <div class="dropdown-menu w-40">
                @include('livewire.button-download')
            </div>
        </div>
        <div class="hidden md:block mx-auto text-gray-600">
            <button wire:click="toggleShowFilters">@if ($showFilters) {{ trans('global.hide') }} @endif {{ trans('global.advance_search') }}</button>
        </div>
        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
            <div class="w-56 relative text-gray-700 dark:text-gray-300">
                <input type="text" class="form-control w-56 box pr-10 placeholder-theme-13" placeholder="Search...">
                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i> 
            </div>
        </div>
    </div>
    @if($showEditModal)
        @include('livewire.accounting.mata-uang.create')
    @endif

    @if($confirmingDeletion)
        @include('livewire.confirm-delete')
    @endif
    @if($confirmingSetDefault)
        @include('livewire.confirm-setdefault')
    @endif
    @if($showCurrencyDefaultModal)
        @include('livewire.accounting.mata-uang.currency-default')
    @endif
    @if ($showFilters)
        @include('livewire.accounting.mata-uang.advance-search')
    @endif
    <!-- BEGIN: Data List -->
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        <table class="table table-report -mt-2">
            <thead>
                <tr class="rounded-md bg-gray-400">
                    <th class="whitespace-nowrap w-20">{{ trans('global.code') }}</th>
                    <th class="whitespace-nowrap w-60">{{ trans('global.name') }}</th>
                    <th class="text-center whitespace-nowrap w-20">{{ trans('currency.code-flag') }}</th>
                    <th class="text-center whitespace-nowrap w-20">{{ trans('currency.set-default') }}</th>
                    <th class="text-center whitespace-nowrap w-20">{{ trans('global.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($currencies as $curr)
                <tr class="intro-x">
                    <td class="w-20">
                        <a href="javascript:;" wire:click="edit({{ $curr->id }})">
                            <span class="font-medium text-theme-20 whitespace-nowrap">{{ $curr->code }}</span>
                        </a>
                    </td>
                    <td class="w-60">
                        <span class="font-medium whitespace-nowrap">{{ $curr->name }}</span>
                    </td>
                    <td class="text-center">{{ $curr->code_flag }}</td>
                    <td class="text-center w-20">
                        <div class="flex justify-center items-center">
                        @if($curr->is_default == 1)
                            <button wire:loading.attr="disabled" class="flex items-center text-theme-20">
                                <x-feathericon-pocket class="w-4 h-4 mr-1"></x-feathericon-pocket>
                                <span>{{ trans('currency.default') }} </span>
                            </button> &nbsp;
                        @else
                            <button wire:click="confirmingSetDefault({{ $curr->id }})" wire:loading.attr="disabled" class="flex items-center text-theme-23">
                                <x-feathericon-shield class="w-4 h-4 mr-1"></x-feathericon-shield>
                                <span>{{ trans('currency.change-default') }} </span>
                            </button> &nbsp;
                        @endif
                        </div>
                    </td>
                    <td class="table-report__action w-20">
                        <div class="flex justify-center items-center">
                            @if($curr->defaultcurr==0)
                            <button wire:click="addDefaultCurrency({{ $curr->id }})" class="flex items-center mr-3"> 
                                <x-feathericon-plus-circle class="w-4 h-4 mr-1"></x-feathericon-plus-circle>
                                <span>{{ trans('global.curr-default') }} </span>
                            </button>
                            @else
                            <button wire:click="viewDefaultCurrency({{ $curr->defaultcurr }})" class="flex items-center text-theme-20 mr-3"> 
                                <x-feathericon-plus-circle class="w-4 h-4 mr-1"></x-feathericon-plus-circle>
                                <span>{{ trans('global.change-default') }} </span>
                            </button>
                            @endif
                            <button wire:click="confirmingDeletion({{ $curr->id }})" wire:loading.attr="disabled" class="flex items-center text-theme-21">
                                <x-feathericon-trash-2 class="w-4 h-4 mr-1"></x-feathericon-trash-2>
                                <span>{{ trans('global.delete-button') }} </span>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>