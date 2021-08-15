<x-slot name="header">
    <h2 class="intro-y text-lg font-medium mt-10">
        {{ trans('item.title') }}
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
                <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                    <a href="javascript:void();" wire:click="importItem" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                        <x-feathericon-shield class="w-4 h-4 mr-2"></x-feathericon-shield>
                        <span>{{ trans('global.import') }}</span>
                    </a>
                    <a href="javascript:void();" wire:click="downloadExcel" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                        <x-feathericon-file-text class="w-4 h-4 mr-2"></x-feathericon-file-text>
                        <span>{{ trans('global.excel-export') }} </span>
                    </a>
                    <a href="javascript:void();" wire:click="downloadPDF" wire:loading.attr="disabled" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
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
                <input type="text" wire:model="filters.search" class="form-control w-56 box pr-10 placeholder-theme-13" placeholder="Search...">
                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i> 
            </div>
        </div>
    </div>
    @if($showEditModal)
        @include('livewire.general.item-create')
    @endif
    @if($confirmingDeletion)
        @include('livewire.confirm-delete')
    @endif
    @if ($showFilters)
        @include('livewire.general.item-advance-search')
    @endif
    @if($showUpload)
        @include('livewire.general.item-upload')
    @endif
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        <table class="table table-report -mt-2">
            <thead>
                <tr class="rounded-md bg-gray-400">
                    <th class="text-white w-20">{{ trans('global.code') }}</th>
                    <th class="text-white">{{ trans('global.name') }}</th>
                    <th class="text-white">{{ trans('item.alias') }}</th>
                    <th class="text-white w-20">{{ trans('global.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr class="intro-x">
                    <td class="w-20">
                        <a href="javascript:;" wire:click="edit({{ $item->id }})">
                            <span class="font-medium text-theme-20 whitespace-nowrap">{{ $item->code }}</span>
                        </a>
                        <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">{{ $item->catname }}</div>
                    </td>
                    <td>
                        <span class="font-medium whitespace-nowrap">{{ $item->name }}</span>
                        <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">{{ $item->invotorys }}</div>
                    </td>
                    <td>
                        <span class="font-medium whitespace-nowrap">{{ $item->alias_name }}</span>
                        <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">{{ trans('item.sell_price') }} : {{ number_format($item->sell_price) }} ; {{ trans('item.buy_price') }} : {{ number_format($item->buy_price) }}</div>
                    </td>
                    <td class="table-report__action w-20">
                        <div class="flex justify-center items-center">
                            <button wire:click="confirmingDeletion({{ $item->id }})" wire:loading.attr="disabled" class="flex items-center text-theme-21">
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
    <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-right mt-3">
        {{ $items->links('pagination',['is_livewire' => true]) }}
    </div>
</div>
