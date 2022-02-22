@extends('template.main')

@section('css')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('content')
<div class="grid grid-cols-12 gap-10 mt-5">
    <div class="intro-y col-span-12 lg:col-span-12 md:col-span-12 sm:col-span-12">
        @if(!empty($result))
        <form action="{{ route('roles.update',['role'=> $result['id']]) }}" method="post" onkeydown="return event.key != 'Enter';">
        @else
        <form action="{{ route('roles.store') }}" method="post" onkeydown="return event.key != 'Enter';">
        @endif
            @csrf
            @if(!empty($result))
            @method('PUT')
            <input 
                type="hidden" 
                readonly
                class="form-control text-center" 
                name="id"
                @if(!empty($result))
                value="{{ $result['id'] }}"
                @endif
                id="id">
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
                            <div class="mt-0">
                                <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                    <div class="input-group">
                                        <div class="input-group-text text-theme-20"><span class="text-theme-20">Role&nbsp;Name</span></div>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            name="name"
                                            @if(!empty($result))
                                            value="{{ $result['name'] }}"
                                            @endif
                                            id="name">
                                    </div>
                                </div>
                            </div>
                            <div id="permission-list" class="mt-2">
                                <label class="form-label mb-2">Permission</label>
                                @if(!empty($result))
                                    @foreach($permissions as $value)
                                        <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-1 sm:mt-0">
                                            <input name="permission[]" value="{{ $value->id }}" class="form-check-input mt-2 mr-0 ml-3" type="checkbox">
                                            <label class="form-check-label py-1 ml-0">{{ ucfirst(preg_replace('/(?<=[a-z])(?=[A-Z])/', ' ',$value->name)) }}</label>
                                        </div>
                                    @endforeach
                                @else
                                    @foreach($permissions as $value)
                                        <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-1 sm:mt-0">
                                            <input name="permission[]" value="{{ $value->id }}" {{ in_array($value->id, $rolePermissions) ? true : false }} class="form-check-input mt-2 mr-0 ml-3" type="checkbox">
                                            <label class="form-check-label py- ml-0">{{ ucfirst(preg_replace('/(?<=[a-z])(?=[A-Z])/', ' ',$value->name)) }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="text-right mt-5">
                                <a href="{{ route('roles.index') }}" class="btn closeModal btn-outline-secondary w-20 mr-1">Cancel</a>
                                <button type="submit" class="btn btn-primary w-auto">Save</button>
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
    <script src="{{ asset('js/accounting.min.js') }}"></script>
    <script src="https://unpkg.com/imask"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script type="text/javascript">
        var transDate  = '';
        var id         = 0;
        var supplierID = '';
        var url        = "{{ route('roles.index') }}";
        var url_bill   = "{{ route('invoices.index') }}";
        var count      = 1;
        var addState   = "{{ request()->segment(count(request()->segments())) }}";
        
    </script>
    @endpush
@endsection