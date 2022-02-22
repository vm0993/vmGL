@extends('template.main')

@section('content')
    <h2 class="intro-y text-lg font-medium mt-4">Data Request Approval</h2>
    <div class="grid grid-cols-12 gap-6 mt-2">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
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
            <div class="md:block mx-auto text-gray-600">
                Filter Search...
            </div>
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <div class="w-56 relative text-gray-700 dark:text-gray-300">
                    <input type="text" class="form-control w-56 box pr-10 placeholder-theme-13" placeholder="Search...">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i> 
                </div>
            </div>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="px-4 py-2 w-10">Approve No</th>
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2 w-24">Amount</th>
                        <th class="px-4 py-2 w-10">Created</th>
                        <th class="px-4 py-2 w-10">Status</th>
                        <th class="px-4 py-2 w-2 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(empty($results))
                        <tr class="intro-x">
                            <td colspan="5" class="text-center">
                                <span class="font-medium whitespace-nowrap text-center">{{ __('tabel.record_not_found') }}</span>
                            </td>
                        </tr>
                    @else
                        @foreach($results as $result)
                        <tr class="intro-x">
                            <td class="w-10">
                                <span class="font-medium text-theme-20 whitespace-nowrap">{{ $result['code'] }}</span>
                                <div class="text-xs whitespace-nowrap mt-0.5">{{ $result['trans_date'] }}</div>
                            </td>
                            <td>
                                <span class="font-medium whitespace-nowrap">{{ $result['description'] }}</span>
                                <div class="text-xs whitespace-nowrap mt-0.5">{{ $result['personel'] }}</div>
                            </td>
                            <td>
                                <span class="font-medium whitespace-nowrap text-right">{{ $result['request_amount'] }}</span>
                                <div class="text-xs whitespace-nowrap mt-0.5">Apv : {{ $result['approve_amount'] }}</div>
                            </td>
                            <td>
                                <span class="font-medium whitespace-nowrap text-center">{{ $result['usercreate'] }}</span>
                                <div class="text-xs whitespace-nowrap mt-0.5">Apv By : {{ $result['userapprove'] }}</div>
                            </td>
                            <td>
                                <span class="font-medium whitespace-nowrap text-theme-20 text-center">
                                    @if($result['status']==0)
                                    CREATED
                                    @elseif($result['status']==1)
                                    SUBMITED
                                    @elseif($result['status']==2)
                                    APPROVED
                                    @endif
                                </span>
                            </td>
                            <td class="table-report__action w-10">
                                <div class="flex justify-center items-center">
                                    <div class="intro-y flex flex-wrap sm:flex-nowrap items-center">
                                        <div class="dropdown">
                                            <button class="dropdown-toggle btn px-2 box text-gray-700 dark:text-gray-300" aria-expanded="false">
                                                <span class="w-5 h-5 px-6 flex block items-center justify-center"> {{ trans('tabel.select') }} </span>
                                            </button>
                                            <div class="dropdown-menu w-44">
                                                <div class="dropdown-menu__content box dark:bg-dark-1 p-2">
                                                    <a href="{{ route('advance-approvals.approval',['advance_approval' => $result['id']]) }}" class="modal-open w-full flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                        <x-feathericon-package class="w-4 h-4 mr-2"></x-feathericon-package>
                                                        <span>Approved</span>
                                                    </a>
                                                    <a href="javascript:;" id="reject" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                        <x-feathericon-eye-off class="w-4 h-4 mr-2"></x-feathericon-eye-off>
                                                        <span>Rejected</span>
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
            @include('paging.page')
        </div>
    </div>
    
@endsection

@section('footer')
    
    @push('scripts')
    <script type="text/javascript">
        /*cash('#approve').on('click', function() {
            console.log($(this).attr("data-id") );
            cash('#basic-modal-preview').modal('show')
        })
        
        // Hide modal
        cash('#closeModal').on('click', function() {
            cash('#basic-modal-preview').modal('hide')
        })*/
        
    </script>
    <script src="{{ asset('js/vima.js') }}"></script>
    @endpush
@endsection
