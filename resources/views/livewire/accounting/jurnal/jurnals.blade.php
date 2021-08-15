<x-slot name="header">
    <h2 class="intro-y text-lg font-medium mt-10">
        {{ trans('jurnal.title') }}
    </h2>
</x-slot>
<div class="grid grid-cols-12 gap-6 mt-5">
    @if($updateMode==0)
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <button wire:click="create()" class="btn btn-primary shadow-md mr-2">{{ trans('global.create-new') }}</button>
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
        @if($confirmingDeletion)
            @include('livewire.confirm-delete')
        @endif
        @if ($showFilters)
            @include('livewire.accounting.jurnal.advance-search')
        @endif
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr class="rounded-md bg-gray-400">
                        <th class="text-white w-10">{{ trans('jurnal.code') }}</th>
                        <th class="text-white w-10">{{ trans('jurnal.date') }}</th>
                        <th class="text-white w-60">{{ trans('jurnal.description') }}</th>
                        <th class="text-right text-white w-10">{{ trans('jurnal.total') }}</th>
                        <th class="text-center text-white w-10">{{ trans('global.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jurnals as $jurnal)
                    <tr class="intro-x">
                        <td class="w-10">
                            <a href="javascript:;" wire:click="edit({{ $jurnal->id }})">
                                <span class="font-medium text-theme-20 whitespace-nowrap">{{ $jurnal->code }}</span>
                            </a>
                        </td>
                        <td>
                            <span class="font-medium whitespace-nowrap">{{ \Carbon\Carbon::parse($jurnal->transaction_date)->format('d M y') }}</span>
                        </td>
                        <td class="text-left">{{ $jurnal->description }}</td>
                        <td class="text-right">{{ number_format($jurnal->total) }}</td>
                        <td class="table-report__action w-10">
                            <div class="flex justify-center">
                                <button wire:click="preview({{ $jurnal->id }})" class="flex items-center text-theme-24" wire:loading.class="bg-gray">
                                    <x-feathericon-printer class="w-4 h-4 mr-1"></x-feathericon-printer>
                                    <span>{{ trans('global.print-button') }} </span>
                                </button> &nbsp;
                                <button wire:click="confirmingDeletion({{ $jurnal->id }})" class="flex items-center text-theme-21" data-toggle="modal" data-target="#delete-confirmation-modal">
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
            {{ $jurnals->links('pagination',['is_livewire' => true]) }}
        </div>
    @elseif($updateMode == 1)
        @include('livewire.accounting.jurnal.create')
    @else

    @endif
</div>