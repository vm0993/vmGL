@extends('template.main')

@section('css')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('content')
    <div class="grid grid-cols-12 gap-10 mt-5">
        <div class="intro-y col-span-12 lg:col-span-10 md:col-span-10 sm:col-span-10">
            @if(!empty($result))
            <form action="{{ route('services.update',['service'=> $result['id']]) }}" method="post" onkeydown="return event.key != 'Enter';">
            @else
            <form action="{{ route('services.store') }}" method="post" onkeydown="return event.key != 'Enter';">
            @endif
                @csrf
                @if(!empty($result))
                @method('PUT')
                @endif
                <div class="intro-y box">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-medium text-base mr-auto">
                            {{ $title }}
                        </h2>
                    </div>
                    <div id="basic-select" class="p-5">
                        <div class="preview">
                            <div class="intro-y">
                                <div>
                                    <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                        <div class="input-group">
                                            <div class="input-group-text text-theme-20"><span class="text-theme-20">Category</span></div>
                                            <select 
                                                class="form-control select" 
                                                name="categori_id" 
                                                id="categori_id" 
                                                placeholder="{{ trans('account.select_account') }}" >
                                                <option value="">{{ trans('account.select_account') }}</option>
                                                @if(!empty($result))
                                                    @foreach ($categories as $cat)
                                                        @if($result['categori_id']== $cat->id)
                                                        <option value="{{ $cat->id }}" selected>{{ $cat->name }}</option>
                                                        @else
                                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @foreach ($categories as $cat)
                                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('categori_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-text text-theme-20"><span class="text-theme-20">Charges&nbsp;Type</span></div>
                                            <select 
                                                class="form-control select" 
                                                name="type_id" 
                                                id="type_id" 
                                                placeholder="{{ trans('account.select_account') }}" >
                                                <option value="">{{ trans('account.select_account') }}</option>
                                                @if(!empty($result))
                                                    @foreach ($types as $a => $type)
                                                        @if($result['type_id']==$a)
                                                        <option value="{{ $a }}" selected>{{ $type }}</option>
                                                        @else
                                                        <option value="{{ $a }}">{{ $type }}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @foreach ($types as $a => $type)
                                                        <option value="{{ $a }}">{{ $type }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('type_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                        <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                            <div class="input-group">
                                                <div class="input-group-text text-theme-20"><span class="text-theme-20">Code</span></div>
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
                                            <div class="input-group-text text-theme-20"><span class="text-theme-20">Name</span></div>
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
                                            <div class="input-group-text text-theme-20"><span class="text-theme-20">WIP&nbsp;Account</span></div>
                                            <select 
                                                class="form-control select" 
                                                name="wip_id" 
                                                id="wip_id" 
                                                placeholder="{{ trans('account.select_account') }}" >
                                                <option value="">{{ trans('account.select_account') }}</option>
                                                @if(!empty($result))
                                                    @foreach ($wipAccounts as $wip)
                                                        @if($result['wip_id']== $wip->id)
                                                        <option value="{{ $wip->id }}" selected>{{ $wip->account_no }} - {{ $wip->account_name }}</option>
                                                        @else
                                                        <option value="{{ $wip->id }}">{{ $wip->account_no }} - {{ $wip->account_name }}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @foreach ($wipAccounts as $wip)
                                                        <option value="{{ $wip->id }}">{{ $wip->account_no }} - {{ $wip->account_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('wip_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-text text-theme-20"><span class="text-theme-20">COGS&nbsp;Account</span></div>
                                            <select 
                                                class="form-control select" 
                                                name="cogs_id" 
                                                id="cogs_id" 
                                                placeholder="{{ trans('account.select_account') }}" >
                                                <option value="">{{ trans('account.select_account') }}</option>
                                                @if(!empty($result))
                                                    @foreach ($cogsAccounts as $cogs)
                                                        @if($result['cogs_id']== $cogs->id)
                                                        <option value="{{ $cogs->id }}" selected>{{ $cogs->account_no }} - {{ $cogs->account_name }}</option>
                                                        @else
                                                        <option value="{{ $cogs->id }}">{{ $cogs->account_no }} - {{ $cogs->account_name }}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @foreach ($cogsAccounts as $cogs)
                                                        <option value="{{ $cogs->id }}">{{ $cogs->account_no }} - {{ $cogs->account_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('cogs_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                        <div class="input-group">
                                            <div class="input-group-text text-theme-20"><span class="text-theme-20">Expense&nbsp;Account</span></div>
                                            <select 
                                                class="form-control select" 
                                                name="expense_id" 
                                                id="expense_id" 
                                                placeholder="{{ trans('account.select_account') }}" >
                                                <option value="">{{ trans('account.select_account') }}</option>
                                                @if(!empty($result))
                                                    @foreach ($expAccounts as $exps)
                                                        @if($result['expense_id']== $exps->id)
                                                        <option value="{{ $exps->id }}" selected>{{ $exps->account_no }} - {{ $exps->account_name }}</option>
                                                        @else
                                                        <option value="{{ $exps->id }}">{{ $exps->account_no }} - {{ $exps->account_name }}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @foreach ($expAccounts as $exps)
                                                        <option value="{{ $exps->id }}">{{ $exps->account_no }} - {{ $exps->account_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('expense_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right mt-5">
                                    <a href="{{ route('services.index') }}" class="btn btn-outline-secondary w-24 mr-1">Cancel</a>
                                    <button type="submit" class="btn btn-primary w-24">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer')
    @push('scripts')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script type="text/javascript">
        var transDate = '';
        var id = 0;
        var url = "{{ route('services.index') }}";
        var count = 1;
        var addState = "{{ request()->segment(count(request()->segments())) }}";
        
        $('.select').select2();
    </script>
    @endpush
@endsection