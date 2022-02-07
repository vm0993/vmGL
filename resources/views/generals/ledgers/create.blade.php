@extends('template.main')

@section('content')
    <div class="intro-y flex items-center mt-2">
        <h2 class="text-lg font-medium mr-auto">New Ledger</h2>
    </div>
    <div class="grid grid-cols-12 gap-10 mt-2">
        <div class="intro-y col-span-12 lg:col-span-8 md:col-span-8 sm:col-span-8">
            @if(!empty($result))
            <form action="{{ route('ledgers.update',['ledger'=> $result['id']]) }}" method="post">
            @else
            <form action="{{ route('ledgers.store') }}" method="post">
            @endif
                @csrf
                @if(!empty($result))
                @method('PUT')
                @endif
                <div class="preview">
                    <div class="intro-y box p-5">
                        <div>
                            <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                <div class="input-group">
                                    <div for="type" class="input-group-text"><strong>Ledger&nbsp;Type</strong></div>
                                    <select 
                                        class="tom-select w-full" 
                                        name="type" 
                                        id="type" 
                                        placeholder="{{ trans('account.select_account') }}" >
                                        <option value="">{{ trans('account.select_account') }}</option>
                                        @if(!empty($result))
                                            @foreach (App\Models\General\Ledger::LEDGER_TYPE as $a => $type)
                                                @if($result['type']==$a)
                                                <option value="{{ $a }}" selected>{{ $type }}</option>
                                                @else
                                                <option value="{{ $a }}">{{ $type }}</option>
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach (App\Models\General\Ledger::LEDGER_TYPE as $a => $type)
                                                <option value="{{ $a }}">{{ $type }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('type') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
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
                                        placeholder="Ledger Name"/>
                                    @error('name') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                <div class="input-group">
                                    <div for="address" class="input-group-text"><strong>Address</strong></div>
                                    <textarea
                                        name="address"
                                        id="address"
                                        rows="5"
                                        class="form-control"
                                        placeholder="Address">
                                        @if(!empty($result))
                                            {!! $result['address'] !!}
                                        @endif</textarea>
                                    @error('address') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                </div>
                                <div class="input-group">
                                    <div for="other_address" class="input-group-text"><strong>Other&nbsp;Address</strong></div>
                                    <textarea
                                        name="other_address"
                                        id="other_address"
                                        rows="5"
                                        class="form-control"
                                        placeholder="Other Address">
                                        @if(!empty($result))
                                            {!! $result['other_address'] !!}
                                        @endif
                                        </textarea>
                                    @error('other_address') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                <div class="input-group">
                                    <div for="phone_no" class="input-group-text"><strong>Phone&nbsp;No</strong></div>
                                    <input
                                        type="text"
                                        name="phone_no"
                                        id="phone_no"
                                        @if(!empty($result))
                                            value="{{ $result['phone_no'] }}"
                                        @endif
                                        class="form-control w-full"
                                        placeholder="Phone No"/>
                                    @error('phone_no') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                </div>
                                <div class="input-group">
                                    <div for="fax_no" class="input-group-text"><strong>Fax&nbsp;No</strong></div>
                                    <input
                                        type="text"
                                        name="fax_no"
                                        id="fax_no"
                                        @if(!empty($result))
                                            value="{{ $result['fax_no'] }}"
                                        @endif
                                        class="form-control w-full"
                                        placeholder="Fax No"/>
                                    @error('fax_no') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                <div class="input-group">
                                    <div for="tax_reg_no" class="input-group-text"><strong>NPWP</strong></div>
                                    <input
                                        type="text"
                                        name="tax_reg_no"
                                        id="tax_reg_no"
                                        maxlength="16"
                                        @if(!empty($result))
                                            value="{{ $result['tax_reg_no'] }}"
                                        @endif
                                        class="form-control w-full"
                                        placeholder="NPWP"/>
                                    @error('tax_reg_no') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                </div>
                                <div class="input-group">
                                    <div for="bank_account" class="input-group-text"><strong>No&nbsp;Rekening</strong></div>
                                    <input
                                        type="text"
                                        name="bank_account"
                                        id="bank_account"
                                        @if(!empty($result))
                                            value="{{ $result['bank_account'] }}"
                                        @endif
                                        class="form-control w-full"
                                        placeholder="No Rekening"/>
                                    @error('bank_account') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="text-right mt-5">
                            <a href="{{ route('ledgers.index') }}" class="btn btn-outline-secondary w-24 mr-1">Cancel</a>
                            <button type="submit" class="btn btn-primary w-24">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop