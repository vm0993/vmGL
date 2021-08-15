<x-slot name="header">
    <h2 class="intro-y text-lg font-medium mt-10">
        {{ trans('jurnal.title') }}
    </h2>
</x-slot>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
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
    @if ($showFilters)
        @include('livewire.accounting.jurnal.advance-search')
    @endif
    <!-- BEGIN: Data List -->
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        <table class="table table-report -mt-2">
            <thead>
                <tr class="rounded-md bg-gray-400">
                    <th class="text-white w-10">{{ trans('jurnal.code') }}</th>
                    <th class="text-white w-10">{{ trans('jurnal.account_name') }}</th>
                    <th class="text-right text-white w-10">{{ trans('jurnal.debet') }}</th>
                    <th class="text-center text-white w-10">{{ trans('jurnal.credit') }}</th>
                    <th class="text-white w-60">{{ trans('jurnal.description') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                <tr class="intro-x">
                    <td class="w-10">
                        <span class="font-medium text-theme-20 whitespace-nowrap">{{ $result->code }}</span>
                        <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">{{ \Carbon\Carbon::parse($result->transaction_date)->format('d M y') }}</div>
                    </td>
                    <td class="w-10">
                        <span class="font-medium whitespace-nowrap">{{ $result->account_no }} - {{ $result->account_name }}</span>
                        <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">{{ $result->costid }}</div>
                    </td>
                    <td class="text-right w-10">{{ number_format($result->debet) }}</td>
                    <td class="text-right w-10">{{ number_format($result->credit) }}</td>
                    <td class="text-left">{{ $result->memo }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-right mt-3">
        {{ $results->links('pagination',['is_livewire' => true]) }}
    </div>
</div>