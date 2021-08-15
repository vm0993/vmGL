<x-slot name="header">
    <h2 class="intro-y text-lg font-medium mt-10">
        {{ trans('tax.title') }} 
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
        </div>
        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
            <div class="w-56 relative text-gray-700 dark:text-gray-300">
                <input type="text" wire:model="filters.search" class="form-control w-56 box pr-10 placeholder-theme-13" placeholder="{{ trans('global.search') }}">
                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i> 
            </div>
        </div>
    </div>
    @if($showEditModal)
        @include('livewire.general.tax-create')
    @endif
    @if($confirmingDeletion)
        @include('livewire.confirm-delete')
    @endif
    <!-- BEGIN: Data List -->
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        <table class="table table-report -mt-2">
            <thead>
                <tr class="rounded-md bg-gray-400">
                    <th class="text-white w-20">{{ trans('global.code') }}</th>
                    <th class="text-white">{{ trans('global.name') }}</th>
                    <th class="text-white">{{ trans('global.rate') }}</th>
                    <th class="text-white">{{ trans('tax.purchase_id') }}</th>
                    <th class="text-white">{{ trans('tax.sales_id') }}</th>
                    <th class="text-white">{{ trans('global.status') }}</th>
                    <th class="text-white text-center w-20">{{ trans('global.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($taxes as $tax)
                <tr class="intro-x">
                    <td class="w-30">
                        <a href="javascript:;" wire:click="edit({{ $tax->id }})">
                            <span class="font-medium text-theme-20 whitespace-nowrap">{{ $tax->code }}</span>
                        </a>
                    </td>
                    <td>
                        <span class="font-medium whitespace-nowrap">{{ $tax->name }}</span>
                    </td>
                    <td>
                        <span class="font-medium whitespace-nowrap">{{ number_format($tax->rate) }} %</span>
                    </td>
                    <td>
                        <span class="font-medium whitespace-nowrap">{{ $tax->purchaseAccount }}</span>
                    </td>
                    <td>
                        <span class="font-medium whitespace-nowrap">{{ $tax->salesAccount }}</span>
                    </td>
                    <td>
                        <span class="font-medium whitespace-nowrap">{{ $tax->status == 0 ? "Active" : "Suspend" }}</span>
                    </td>
                    <td class="table-report__action w-20">
                        <div class="flex justify-center items-center">
                            <button wire:click="confirmingDeletion({{ $tax->id }})" wire:loading.attr="disabled" class="flex items-center text-theme-21">
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
    <!-- BEGIN: Pagingation -->
    <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-right mt-3">
        {{ $taxes->links('pagination',['is_livewire' => true]) }}
    </div>
    <!-- END: Pagingation -->
</div>