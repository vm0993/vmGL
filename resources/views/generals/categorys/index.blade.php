@extends('template.main')

@section('content')
    <div class="intro-y flex items-center mt-2">
        <h2 class="intro-y text-lg font-medium mt-auto">Data Category</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-3">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('categories.create') }}" class="btn btn-primary shadow-md mr-2">Add New</a>
            <div class="dropdown">
                <button class="dropdown-toggle btn px-2 box text-gray-700 dark:text-gray-300" aria-expanded="false">
                    <span class="w-5 h-5 flex items-center justify-center">
                        <x-feathericon-plus class="w-4 h-4"></x-feathericon-plus>
                    </span>
                </button>
                <div class="dropdown-menu w-40">
                    <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                        <a href="javascript:;" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                            <x-feathericon-file-text class="w-4 h-4 mr-2"></x-feathericon-file-text>
                            <span>{{ trans('global.excel-export') }} </span>
                        </a>
                        <a href="javascript:;" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                            <x-feathericon-file-text class="w-4 h-4 mr-2"></x-feathericon-file-text>
                            <span>{{ trans('global.pdf-export') }} </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="md:block mx-auto text-slate-500">Filter Search...</div>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <div class="w-56 relative text-slate-500">
                    <input type="text" class="form-control w-56 box pr-10" placeholder="Search...">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i>
                </div>
            </div>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2 w-10">Created</th>
                        <th class="px-4 py-2 w-10">Status</th>
                        <th class="px-4 py-2 w-2 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(empty($categorys))
                        <tr class="intro-x">
                            <td colspan="4" class="text-center">
                                <span class="font-medium whitespace-nowrap text-center">{{ __('tabel.record_not_found') }}</span>
                            </td>
                        </tr>
                    @else
                        @foreach($categorys as $x => $result)
                            <tr class="intro-x">
                                <td>
                                    <a href="{{ route('categories.edit',['category' => $result['id']]) }}">
                                        <span class="font-medium text-theme-20 whitespace-nowrap">{{ $result['name'] }}</span>
                                    </a>
                                </td>
                                <td class="w-10">
                                    <span class="font-medium whitespace-nowrap text-center">{{ $result['user_name'] }}</span>
                                </td>
                                <td class="w-10">
                                    <span class="font-medium text-theme-20 text-center">{{ $result['status'] }}</span>
                                </td>
                                <td class="table-report__action w-10">
                                    <div class="flex justify-center items-center">
                                        <div class="intro-y flex flex-wrap sm:flex-nowrap items-center">
                                            <div class="dropdown">
                                                <button class="dropdown-toggle btn px-2 box text-gray-700 dark:text-gray-300" aria-expanded="false">
                                                    <span class="w-5 h-5 px-6 flex block items-center justify-center"> {{ __('tabel.select') }} </span>
                                                </button>
                                                <div class="dropdown-menu w-44">
                                                    <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                                        <a href="javascript:;" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                            <span>Edit</span>
                                                        </a>
                                                        <a href="javascript:;" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                            <span>Delete</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="text-justify">
            </div>
        </div>
    </div>
@stop