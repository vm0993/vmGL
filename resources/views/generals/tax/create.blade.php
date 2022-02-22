@extends('template.main')

@section('css')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('content')
    <div class="intro-y flex items-center mt-2">
        <h2 class="text-lg font-medium mr-auto">{{ $title }}</h2>
    </div>
    <div class="grid grid-cols-12 gap-10 mt-2">
        <div class="intro-y col-span-12 lg:col-span-8 md:col-span-8 sm:col-span-8">
            @if(!empty($result))
            <form action="{{ route('taxes.update',['tax'=> $result['id']]) }}" method="post">
            @else
            <form action="{{ route('taxes.store') }}" method="post">
            @endif
                @csrf
                @if(!empty($result))
                @method('PUT')
                @endif
                <div class="preview">
                    <div class="intro-y box p-5">
                        <div>
                            <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                    <div class="input-group">
                                        <div for="code" class="input-group-text"><strong>Code</strong></div>
                                        <input
                                            type="text"
                                            name="code"
                                            id="code"
                                            @if(!empty($result))
                                                value="{{ $result['code'] }}"
                                            @endif
                                            class="form-control w-full"
                                            placeholder="Code"/>
                                        @error('code') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="input-group">
                                        <div for="rate" class="input-group-text"><strong>Rate</strong></div>
                                        <input
                                            type="number"
                                            step="any"
                                            name="rate"
                                            id="rate"
                                            @if(!empty($result))
                                                value="{{ $result['rate'] }}"
                                            @endif
                                            class="form-control w-full"
                                            placeholder="Tax Rate"/>
                                        @error('rate') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                <div class="input-group">
                                    <div for="name" class="input-group-text"><strong>Name</strong></div>
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        @if(!empty($result))
                                            value="{{ $result['name'] }}"
                                        @endif
                                        class="form-control w-full"
                                        placeholder="Tax Name"/>
                                    @error('name') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="md:grid grid-cols-1 sm:grid grid-cols-1 gap-2">
                                <div class="input-group">
                                    <div for="purchase_account_id" class="input-group-text"><strong>Purchase&nbsp;Account</strong></div>
                                    <select 
                                        class="form-control select" 
                                        name="purchase_account_id" 
                                        id="purchase_account_id" 
                                        placeholder="{{ trans('account.select_account') }}" >
                                        <option value="">{{ trans('account.select_account') }}</option>
                                        @if(!empty($result))
                                            @foreach ($purchAccount as $purchase)
                                                @if($result['purchase_account_id']==$purchase->id)
                                                <option value="{{ $purchase->id }}" selected>{{ $purchase->account_no }} - {{ $purchase->account_name }}</option>
                                                @else
                                                <option value="{{ $purchase->id }}">{{ $purchase->account_no }} - {{ $purchase->account_name }}</option>
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach ($purchAccount as $purchase)
                                                <option value="{{ $purchase->id }}">{{ $purchase->account_no }} - {{ $purchase->account_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('purchase_account_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        <div class="mt-3">
                            <div class="md:grid grid-cols-1 sm:grid grid-cols-1 gap-2">
                                <div class="input-group">
                                    <div for="sales_account_id" class="input-group-text"><strong>Sales&nbsp;Account</strong></div>
                                    <select 
                                        class="form-control select" 
                                        name="sales_account_id" 
                                        id="sales_account_id" 
                                        placeholder="{{ trans('account.select_account') }}" >
                                        <option value="">{{ trans('account.select_account') }}</option>
                                        @if(!empty($result))
                                            @foreach ($salesAccount as $sales)
                                                @if($result['sales_account_id']==$sales->id)
                                                <option value="{{ $sales->id }}" selected>{{ $sales->account_no }} - {{ $sales->account_name }}</option>
                                                @else
                                                <option value="{{ $sales->id }}">{{ $sales->account_no }} - {{ $sales->account_name }}</option>
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach ($salesAccount as $sales)
                                                <option value="{{ $sales->id }}">{{ $sales->account_no }} - {{ $sales->account_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('sales_account_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="text-right mt-5">
                            <a href="{{ route('taxes.index') }}" class="btn btn-outline-secondary w-24 mr-1">Cancel</a>
                            <button type="submit" class="btn btn-primary w-24">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script type="text/javascript">
        $('.select').select2();
    </script>
@endpush
