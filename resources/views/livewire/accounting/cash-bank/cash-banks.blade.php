<x-slot name="header">
    <h2 class="intro-y text-lg font-medium mt-10">
        {{ trans('cash-bank.title') }}
    </h2>
</x-slot>
<div class="grid grid-cols-12 gap-6 mt-5">
    @if($updateMode==0)
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
                    <input type="text" wire:model="filters.search" class="form-control w-56 box pr-10 placeholder-theme-13" placeholder="Search...">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i> 
                </div>
            </div>
        </div>
        @if($confirmingDeletion)
            @include('livewire.confirm-delete')
        @endif
        @if ($showFilters)
            @include('livewire.accounting.cash-bank.advance-search')
        @endif
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr class="rounded-md bg-gray-400">
                        <th class="text-white w-24">{{ trans('cash-bank.code') }}</th>
                        <th class="text-white w-20">{{ trans('cash-bank.date') }}</th>
                        <th class="text-white w-24">{{ trans('cash-bank.source_account') }}</th>
                        <th class="text-white w-70">{{ trans('cash-bank.description') }}</th>
                        <th class="text-right text-white w-20">{{ trans('cash-bank.total') }}</th>
                        <th class="text-center text-white w-10">{{ trans('global.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kasbanks as $kasbank)
                    <tr class="intro-x">
                        <td class="w-20">
                            <a href="javascript:;" wire:click="edit({{ $kasbank->id }})">
                                <span class="font-medium text-theme-20 whitespace-nowrap">{{ $kasbank->code }}</span>
                            </a>
                        </td>
                        <td>
                            <span class="font-medium whitespace-nowrap">{{ \Carbon\Carbon::parse($kasbank->transaction_date)->format('d M y') }}</span>
                        </td>
                        <td>
                            <span class="font-medium whitespace-nowrap">{{ $kasbank->accountName }}</span>
                        </td>
                        <td class="text-left">{{ $kasbank->description }}</td>
                        <td class="text-right">{{ number_format($kasbank->total) }}</td>
                        <td class="table-report__action w-20">
                            <div class="flex justify-center items-center">
                                <button wire:click="preview({{ $kasbank->id }})" class="flex items-center text-theme-14">
                                    <x-feathericon-printer class="w-4 h-4 mr-1"></x-feathericon-printer>
                                    <span>{{ trans('global.print') }} </span>
                                </button> &nbsp;
                                <button wire:click="confirmingDeletion({{ $kasbank->id }})" class="flex items-center text-theme-21" data-toggle="modal" data-target="#delete-confirmation-modal">
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
    @elseif($updateMode == 1)
        @include('livewire.accounting.cash-bank.create')
    @else
        @include('livewire.accounting.cash-bank.create')
    @endif
</div>