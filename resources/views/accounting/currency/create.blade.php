@extends('template.main')

@section('content')
    <div class="intro-y flex items-center mt-2">
        <h2 class="text-lg font-medium mr-auto">{{ empty($result) ? $title : $title }}</h2>
    </div>
    <div class="grid grid-cols-12 gap-2 mt-2">
        <div class="intro-y col-span-12 lg:col-span-6 md:col-span-6">
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                @if(!empty($result))
                <form action="{{ route('currencies.update',['currency'=> $result['id']]) }}" method="post">
                @else
                <form action="{{ url()->current() }}" method="post">
                @endif
                    @csrf
                    @if(!empty($result))
                    @method('PUT')
                    @endif
                    <div>
                        <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                            <div class="input-group">
                                <div id="input-group-3" class="input-group-text">Code</div>
                                <input 
                                    type="text" 
                                    name="code"
                                    @if(!empty($result))
                                    value="{{ $result['code'] }}"
                                    @endif
                                    class="form-control" 
                                    placeholder="Code" 
                                    aria-describedby="input-group-3">
                            </div>
                            <div class="input-group mt-2 sm:mt-0 ml-2">
                                <div id="input-group-4" class="input-group-text">Name</div>
                                <input 
                                    type="text" 
                                    name="name"
                                    @if(!empty($result))
                                    value="{{ $result['name'] }}"
                                    @endif
                                    class="form-control" 
                                    placeholder="Name" 
                                    aria-describedby="input-group-4">
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                            <div class="input-group">
                                <div id="input-group-3" class="input-group-text">Rate</div>
                                <input 
                                    type="text" 
                                    step="any"
                                    name="rate"
                                    @if(!empty($result))
                                    value="{{ $result['rate'] }}"
                                    @endif
                                    class="form-control" 
                                    placeholder="Rate" 
                                    aria-describedby="input-group-3">
                            </div>
                            <div class="input-group mt-2 sm:mt-0 ml-2">
                                <div id="input-group-4" class="input-group-text">Symbol</div>
                                <input 
                                    type="text"
                                    name="symbol" 
                                    @if(!empty($result))
                                    value="{{ $result['symbol'] }}"
                                    @endif
                                    class="form-control" 
                                    placeholder="Symbol" 
                                    aria-describedby="input-group-4">
                            </div>
                        </div>
                    </div>
                    <div class="text-right mt-5">
                        <a href="{{ route('currencies.index') }}" class="btn btn-outline-secondary w-20 mr-1">Cancel</a>
                        <button type="submit" class="btn btn-primary w-auto">Save</button>
                    </div>
                </form>
            </div>
            <!-- END: Form Layout -->
        </div>
    </div>
@stop