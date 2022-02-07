@extends('template.main')

@section('content')
<div class="grid grid-cols-12 gap-10 mt-5">
    <div class="intro-y col-span-12 lg:col-span-12 md:col-span-12 sm:col-span-12">
        @if(!empty($result))
        <form action="{{ route('accounts.update',['id'=> $result['id']]) }}" method="post" onkeydown="return event.key != 'Enter';">
        @else
        <form action="{{ url()->current() }}" method="post" onkeydown="return event.key != 'Enter';">
        @endif
            @csrf
            @if(!empty($result))
            @method('PUT')
            @endif
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        Cash/Bank Baru
                    </h2>
                    <div class="text-right">
                        <input 
                            type="text" 
                            readonly
                            placeholder="Voucher No"
                            class="form-control text-center" 
                            name="voucher_no"
                            id="voucher_no">
                    </div>
                </div>
                <div id="basic-select" class="p-5">
                    <div class="preview">
                        <div class="intro-y">
                            <div class="mt-0">
                                <label class="form-label">Data Transaksi</label>
                                <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                    <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                        <div class="input-group">
                                            <div class="input-group-text text-theme-20"><span class="text-theme-20">Tgl&nbsp;Transaksi</span></div>
                                            <input 
                                                type="text" 
                                                class="form-control date" 
                                                name="transaction_date"
                                                id="transaction_date">
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-text text-theme-20"><span class="text-theme-20">Debet&nbsp;Account</span></div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="md:grid grid-cols-1 sm:grid grid-cols-1 gap-2">
                                    <div class="input-group">
                                        <div class="input-group-text text-theme-20"><span class="text-theme-20">Keterangan</span></div>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            name="description"
                                            id="description">
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 gap-x-5 mt-1">
                                <div class="col-span-12 lg:col-span-9 md:col-span-9 sm:col-span-6 mt-1">
                                    <div class="input-group">
                                        <div class="input-group-text w-full text-center">
                                            <span class="text-theme-20">Account&nbsp;Name</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-3 md:col-span-3 sm:col-span-6 mt-1">
                                    <div class="input-group">
                                        <div class="input-group-text w-full text-center">
                                            <span class="text-theme-20">Amount</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 gap-x-5 mt-0">
                                <div class="col-span-12 lg:col-span-9 md:col-span-9 sm:col-span-6 mt-2">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            {{ __('jurnal.account') }}
                                        </div>
                                        <input type="number" step="any" class="form-control text-right" />
                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-3 md:col-span-3 sm:col-span-6 mt-2">
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control text-right" placeholder="Amount" />
                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-12 sm:col-span-12 mt-2">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            {{ __('jurnal.memo') }}
                                        </div>
                                        <input type="text" class="form-control" placeholder="{{ trans('jurnal.memo') }}"  />
                                        <div class="input-group-text">
                                            <x-feathericon-trash-2 class="w-4 h-4"></x-feathericon-trash-2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 gap-x-5 mt-0">
                                <div class="col-span-12 lg:col-span-9 md:col-span-9 sm:col-span-6 mt-2">
                                    <div class="col-span-12 lg:col-span-8 mt-2">
                                        <button class="btn btn-primary shadow-md mr-2">{{ trans('jurnal.add-account') }}</button>
                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-3 md:col-span-3 sm:col-span-6 mt-2">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            {{ __('jurnal.total_amount') }}
                                        </div>
                                        <input type="number" step="any" readonly name="totCredit" class="form-control text-right"/>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right mt-5">
                                <a href="{{ route('jurnals.index') }}" class="btn closeModal btn-outline-secondary w-20 mr-1">Cancel</a>
                                <button type="submit" class="btn btn-primary w-auto">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@stop