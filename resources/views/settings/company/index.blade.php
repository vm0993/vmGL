@extends('template.main')

@section('css')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('content')
    <div class="intro-y flex items-center mt-2">
        <h2 class="text-lg font-medium mr-auto">{{ empty($result) ? $title : $title }}</h2>
    </div>
    <div class="grid grid-cols-12 gap-2 mt-2">
        <div class="intro-y col-span-12 lg:col-span-12 md:col-span-12">
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                @if(!empty($result))
                <form action="{{ route('company.update',['company'=> $result['id']]) }}" method="post" onkeydown="return event.key != 'Enter';">
                @else
                <form action="{{ route('company.store') }}" method="post" onkeydown="return event.key != 'Enter';">
                @endif
                    @csrf
                    @if(!empty($result))
                    @method('PUT')
                    @endif
                    <div class="p-5">
                        <div class="flex flex-col-reverse xl:flex-row flex-col">
                            <div class="flex-1 mt-6 xl:mt-0">
                                <div class="grid grid-cols-12 gap-x-5">
                                    <div class="col-span-12 xl:col-span-6">
                                        <div>
                                            <label for="formName" class="form-label block font-bold">{{ trans('setting.name') }}</label>
                                            <input 
                                                type="text" 
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                                id="formName" 
                                                name="name"
                                                @if(!empty($result))
                                                value="{{ $result['name'] }}"
                                                @endif
                                                placeholder="Enter Name">
                                            @error('name') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-span-12 xl:col-span-3">
                                        <div>
                                            <label for="formAlias" class="form-label block font-bold">{{ trans('setting.subdomain') }}</label>
                                            <input 
                                                type="text" 
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                                id="formAlias" 
                                                readonly
                                                placeholder="Enter Alias" 
                                                @if(!empty($result))
                                                value="{{ $result['subdomain'] }}"
                                                @endif
                                                name="alias">
                                            @error('alias') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-span-12 xl:col-span-3">
                                        <div>
                                            <label for="formEmail" class="form-label block font-bold">{{ trans('setting.email') }}</label>
                                            <input 
                                                type="email" 
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                                id="formEmail" 
                                                placeholder="Enter Email" 
                                                @if(!empty($result))
                                                value="{{ $result['email'] }}"
                                                @endif
                                                name="email">
                                            @error('email') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-span-12 xl:col-span-6 mt-2">
                                        <div>
                                            <label for="formAddress" class="form-label block font-bold">{{ trans('setting.address') }}</label>
                                            <textarea 
                                                rows=3 
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                                id="formAddress" 
                                                placeholder="Enter Address" 
                                                name="address">
                                                @if(!empty($result))
                                                {!! $result['address'] !!}
                                                @endif
                                            </textarea>
                                            @error('address') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-span-12 xl:col-span-3 mt-2">
                                        <div>
                                            <label for="formCity" class="form-label block font-bold">{{ trans('setting.city') }}</label>
                                            <input 
                                                type="text" 
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                                id="formCity" 
                                                placeholder="Enter City" 
                                                @if(!empty($result))
                                                value="{{ $result['city'] }}"
                                                @endif
                                                name="city">
                                            @error('city') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-span-12 xl:col-span-3 mt-2">
                                        <div>
                                            <label for="formPhone" class="form-label block font-bold">{{ trans('setting.phone') }}</label>
                                            <input 
                                                type="text" 
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                                id="formPhone" 
                                                @if(!empty($result))
                                                value="{{ $result['phone_no'] }}"
                                                @endif
                                                placeholder="Enter Phone" 
                                                name="phone_no">
                                            @error('phone_no') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-span-12 xl:col-span-2 mt-2">
                                        <div>
                                            <label for="formFax" class="form-label block font-bold">{{ trans('setting.fax_no') }}</label>
                                            <input 
                                                type="text" 
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                                id="formFax" 
                                                name="fax_no"
                                                @if(!empty($result))
                                                value="{{ $result['fax_no'] }}"
                                                @endif
                                                placeholder="Enter Fax">
                                            @error('fax_no') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-span-12 xl:col-span-2 mt-2">
                                        <div>
                                            <label for="formPostalCode" class="form-label block font-bold">{{ trans('setting.postal_code') }}</label>
                                            <input 
                                                type="text" 
                                                name="postal_code"
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                                id="formPostalCode" 
                                                @if(!empty($result))
                                                value="{{ $result['postal_code'] }}"
                                                @endif
                                                placeholder="Postal Code">
                                            @error('postal_code') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-span-12 xl:col-span-2 mt-2">
                                        <div>
                                            <label for="formPagination" class="form-label block font-bold">{{ trans('setting.pagination') }}</label>
                                            <input 
                                                type="number" 
                                                name="paging"
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                                id="formPagination" 
                                                placeholder="Pagination">
                                            @error('pagination') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-span-12 xl:col-span-3 mt-2">
                                        <div>
                                            <label for="formThousand" class="form-label block font-bold">{{ trans('setting.thousand_separator') }}</label>
                                            <input 
                                                type="text" 
                                                max="2" 
                                                name="thousand_separator"
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                                id="formThousand" 
                                                @if(!empty($result))
                                                value="{{ $result['thousand_separator'] }}"
                                                @endif
                                                placeholder="{{ trans('setting.thousand_separator') }}" >
                                                @error('thousand_separator') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-span-12 xl:col-span-3 mt-2">
                                        <div>
                                            <label for="formDecimal" class="form-label block font-bold">{{ trans('setting.decimal_separator') }}</label>
                                            <input 
                                                type="text" 
                                                max="2" 
                                                name="decimal_separator"
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                                id="formDecimal" 
                                                @if(!empty($result))
                                                value="{{ $result['decimal_separator'] }}"
                                                @endif
                                                placeholder="{{ trans('setting.decimal_separator') }}">
                                            @error('decimal_separator') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-12 gap-x-5 mt-2">
                                    <div class="col-span-12 xl:col-span-4">
                                        <div class="mt-3 xl:mt-0">
                                            <label for="formRetained" class="form-label">{{ trans('setting.retained_earning') }}</label>
                                            <select 
                                                id="formRetained" 
                                                class="form-control select" 
                                                data-search="true" 
                                                name="retained_earning_account"
                                                placeholder="{{ trans('setting.select_retained_earning') }}" >
                                                <option value="">{{ trans('setting.select_retained_earning') }}</option>
                                                @foreach ($equityAccounts as $rea)
                                                    @if(empty($result))
                                                        <option value="{{ $rea->id }}">{{ $rea->accountFull }}</option>
                                                    @else
                                                        @if($result['retained_earning_account'] == $rea->id)
                                                        <option value="{{ $rea->id }}" selected>{{ $rea->accountFull }}</option>
                                                        @else
                                                        <option value="{{ $rea->id }}">{{ $rea->accountFull }}</option>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('retained_earning_account') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-span-12 xl:col-span-4">
                                        <div class="mt-3 xl:mt-0">
                                            <label for="formYearly" class="form-label">{{ trans('setting.yearly_earning') }}</label>
                                            <select 
                                                id="formYearly" 
                                                class="form-control select" 
                                                data-search="true" 
                                                name="yearly_profit_account"
                                                placeholder="{{ trans('setting.select_yearly_earning') }}" >
                                                <option value="">{{ trans('setting.select_yearly_earning') }}</option>
                                                @foreach ($equityAccounts as $ypa)
                                                    @if(empty($result))
                                                        <option value="{{ $ypa->id }}">{{ $ypa->accountFull }}</option>
                                                    @else
                                                        @if($result['yearly_profit_account'] == $ypa->id)
                                                        <option value="{{ $ypa->id }}" selected>{{ $ypa->accountFull }}</option>
                                                        @else
                                                        <option value="{{ $ypa->id }}">{{ $ypa->accountFull }}</option>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('yearly_profit_account') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-span-12 xl:col-span-4">
                                        <div class="mt-3 xl:mt-0">
                                            <label for="formMonthly" class="form-label">{{ trans('setting.monthly_earning') }}</label>
                                            <select 
                                                id="formMonthly" 
                                                class="form-control select" 
                                                data-search="true" 
                                                name="monthly_profit_account"
                                                placeholder="{{ trans('setting.select_monthly_earning') }}" >
                                                <option value="">{{ trans('setting.select_monthly_earning') }}</option>
                                                @foreach ($equityAccounts as $mpa)
                                                    @if(empty($result))
                                                        <option value="{{ $mpa->id }}">{{ $mpa->accountFull }}</option>
                                                    @else
                                                        @if($result['monthly_profit_account'] == $mpa->id)
                                                        <option value="{{ $mpa->id }}" selected>{{ $mpa->accountFull }}</option>
                                                        @else
                                                        <option value="{{ $mpa->id }}">{{ $mpa->accountFull }}</option>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('monthly_profit_account') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                                {{--  <div class="grid grid-cols-12 gap-x-5 mt-2">
                                    <div class="col-span-12 xl:col-span-6 mt-2">
                                        <div>
                                            <label for="formThousand" class="form-label block font-bold">{{ trans('setting.thousand_separator') }}</label>
                                            <input 
                                                type="text" 
                                                max="2" 
                                                name="thousand_separator"
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                                id="formThousand" 
                                                @if(!empty($result))
                                                value="{{ $result['thousand_separator'] }}"
                                                @endif
                                                placeholder="{{ trans('setting.thousand_separator') }}" >
                                            @error('thousand_separator') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-span-12 xl:col-span-6 mt-2">
                                        <div>
                                            <label for="formDecimal" class="form-label block font-bold">{{ trans('setting.decimal_separator') }}</label>
                                            <input 
                                                type="text" 
                                                max="2" 
                                                name="decimal_separator"
                                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                                id="formDecimal" 
                                                @if(!empty($result))
                                                value="{{ $result['decimal_separator'] }}"
                                                @endif
                                                placeholder="{{ trans('setting.decimal_separator') }}">
                                            @error('decimal_separator') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>  --}}
                            </div>
                            <div class="w-52 mx-auto xl:mr-0 xl:ml-6">
                                <div class="border-2 border-dashed shadow-sm border-gray-200 dark:border-dark-5 rounded-md p-5">
                                    <div class="h-40 relative image-fit cursor-pointer zoom-in mx-auto">
                                        <img class="rounded-md" alt="Company Logo" src="{{ asset('images/logovm.jpg') }}">
                                        <div title="Remove this logo?" class="tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-theme-21 right-0 top-0 -mr-2 -mt-2">
                                            <x-feathericon-x class="w-4 h-4"></x-feathericon-x>    
                                        </div>
                                    </div>
                                    <div class="mx-auto cursor-pointer relative mt-5">
                                        <button type="button" class="btn btn-info w-full">{{ trans('setting.change-logo') }}</button>
                                        <input type="file" class="w-full h-full top-0 left-0 absolute opacity-0" name="company_logo" />
                                    </div>
                                    @error('company_logo') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex px-5 py-5 sm:py-3 border-t border-gray-200 dark:border-dark-5">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary w-24">{{ trans('global.save-button') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- END: Form Layout -->
        </div>
    </div>
@endsection

@section('footer')
    @push('scripts')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script type="text/javascript">
        
        $('.select').select2();
    </script>
    @endpush
@endsection