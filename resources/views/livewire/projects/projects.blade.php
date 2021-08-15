
<x-slot name="header">
    <h2 class="intro-y text-lg font-medium mt-10">
        {{ trans('project.title') }}
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
    @if($showProject == 1)
        @include('livewire.projects.add-order')
    @endif
    @if($showEditModal)
        @include('livewire.projects.project-create')
    @endif
    @if($confirmingDeletion)
        @include('livewire.confirm-delete')
    @endif
    @if ($showFilters)
        @include('livewire.projects.project-advance-search')
    @endif
    <!-- BEGIN: Data List -->
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        <table class="table table-report -mt-2">
            <thead>
                <tr class="rounded-md bg-gray-400">
                    <th class="text-white w-40">{{ trans('global.code') }}</th>
                    <th class="text-white">{{ trans('project.contract_no') }}</th>
                    <th class="text-white">{{ trans('project.ledger_id') }}</th>
                    <th class="text-white w-20">{{ trans('project.remaining') }}</th>
                    <th class="text-white w-20">{{ trans('global.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                <tr class="intro-x">
                    <td class="w-20">
                        <a href="javascript:;" wire:click="edit({{ $project->id }})">
                            <span class="font-medium text-theme-20 whitespace-nowrap">{{ $project->code }}</span>
                        </a>
                        <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">{{ $project->name }}</div>
                    </td>
                    <td class="w-20">
                        <span class="font-medium whitespace-nowrap">{{ $project->contract_no }}</span>
                        <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5 text-right">{{ number_format($project->contract_amount) }}</div>
                    </td>
                    <td>
                        <span class="font-medium whitespace-nowrap">{!! $project->contract_title !!}</span>
                        <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">{{ $project->clientname }}</div>
                    </td>
                    <td class="w-20 text-right">
                        <span class="font-medium whitespace-nowrap">{{ number_format($project->contract_balance) }}</span>
                    </td> 
                    <td class="table-report__action w-20">
                        <div class="flex justify-center items-center">
                            <button wire:click="addOrder({{ $project->id }})" class="flex items-center mr-3"> 
                                <x-feathericon-plus-circle class="w-4 h-4 mr-1"></x-feathericon-plus-circle>
                                <span>{{ trans('global.add-order') }} </span>
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
        {{ $projects->links('pagination',['is_livewire' => true]) }}
    </div>
    <!-- END: Pagingation -->
</div>
