@extends('template.main')

@section('css')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('content')
    <div class="intro-y flex items-center mt-2">
        <h2 class="text-lg font-medium mr-auto">{{ empty($result) ? $title : $title }}</h2>
    </div>
    <div class="grid grid-cols-12 gap-10 mt-2">
        <div class="intro-y col-span-12 lg:col-span-8 md:col-span-8 sm:col-span-8">
            @if(!empty($result))
            <form action="{{ route('accounts.update',['account'=> $result['id']]) }}" method="post" onkeydown="return event.key != 'Enter';">
            @else
            <form action="{{ url()->current() }}" method="post" onkeydown="return event.key != 'Enter';">
            @endif
                @csrf
                @if(!empty($result))
                @method('PUT')
                @endif
                <div class="intro-y box">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-medium text-base mr-auto"></h2>
                    </div>
                    <div id="basic-select" class="p-5">
                        <div class="preview">
                            <div class="intro-y">
                                <div>
                                    <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                        <div class="input-group">
                                            <div for="account_type" class="input-group-text"><strong>Account&nbsp;Type</strong></div>
                                            @php $accTypes = getAccountTypes(); @endphp
                                            <select 
                                                class="form-control select" 
                                                name="account_type" 
                                                id="account_type" 
                                                placeholder="{{ trans('account.select_account') }}" >
                                                <option value="">{{ trans('account.select_account') }}</option>
                                                @if(!empty($result))
                                                @foreach ($accTypes as $a => $type)
                                                    @if($result['account_type'] == $a)
                                                    <option value="{{ $a }}" selected>{{ $type }}</option>
                                                    @else
                                                    <option value="{{ $a }}">{{ $type }}</option>
                                                    @endif
                                                @endforeach
                                                @else
                                                @foreach ($accTypes as $a => $type)
                                                    <option value="{{ $a }}">{{ $type }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            @error('account_type') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                        <div class="input-group">
                                            <div class="input-group-text">Account&nbsp;No</div>
                                            <input 
                                                type="text" 
                                                id="account_no"
                                                name="account_no"
                                                @if(!empty($result))
                                                value="{{ $result['account_no'] }}"
                                                @endif
                                                class="form-control" 
                                                placeholder="Account No">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="md:grid grid-cols-1 sm:grid grid-cols-1 gap-2">
                                        <div class="input-group">
                                            <div for="account_name" class="input-group-text">Account&nbsp;Name</div>
                                            <input 
                                                type="text" 
                                                id="account_name"
                                                name="account_name"
                                                @if(!empty($result))
                                                value="{{ $result['account_name'] }}"
                                                @endif
                                                class="form-control" 
                                                placeholder="Account Name" >
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                        <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                            <div class="input-group">
                                                <div class="input-group-text">Jurnal</div>
                                                @php $canJurnals = App\Models\Accounting\Accounts\Account::IS_JURNAL @endphp
                                                <select 
                                                    class="form-control select" 
                                                    name="can_jurnal" 
                                                    id="can_jurnal" 
                                                    placeholder="{{ trans('account.select_jurnal') }}" >
                                                    <option value="">{{ trans('account.select_jurnal') }}</option>
                                                    @if(!empty($result))
                                                    @foreach ($canJurnals as $x => $jurnal)
                                                        @if($result['can_jurnal'] == $x)
                                                        <option value="{{ $x }}" selected>{{ $jurnal }}</option>
                                                        @else
                                                        <option value="{{ $x }}">{{ $jurnal }}</option>
                                                        @endif
                                                    @endforeach
                                                    @else
                                                    @foreach ($canJurnals as $x => $jurnal)
                                                        <option value="{{ $x }}">{{ $jurnal }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="input-group ml-2" id="subAccount">
                                            <div class="input-group-text">Sub&nbsp;Account</div>
                                            <select 
                                                class="form-control select" 
                                                name="parent_account_id" 
                                                id="parent_account_id">
                                                <option value="0">Select Sub Account</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right mt-5">
                                    <a href="{{ route('accounts.index') }}" class="btn closeModal btn-outline-secondary w-20 mr-1">Cancel</a>
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
@push('scripts')
<script src="{{ asset('js/select2.min.js') }}"></script>
<script type="text/javascript">
    $('#subAccount').hide();
    var accountType = '';
    var isCanJurnal = $('#can_jurnal').val();
    var parentId = "{{ request()->segment(count(request()->segments())) }}";
    var op = '';

    $('.select').select2();
    
    if(isCanJurnal == 'YES'){
        $('#subAccount').show();
    }else{
        $('#subAccount').hide();
    }

    $('#account_type').on('change',function(){
        accountType = $('#account_type').val();
        $.ajax({
            url:'http://vmgl.test/masters/accounts/'+ accountType +'/next-account',
            dataType:'json',
            type:'get',
            processData : false,
            contentType:false,
            success:function(data){
                $('#account_no').val(data);
            }
        });
    });

    $('#can_jurnal').on('change',function(){
        isCanJurnal = $('#can_jurnal').val();
        accountType = $('#account_type').val();
        console.log(accountType);
        if(accountType == '' && isCanJurnal === 'YES'){
            alert('Please Select Account Type first!');
        }else{
            if(isCanJurnal === 'YES'){
                $('#subAccount').show();
                //show detail account
                $.ajax({
                    url:'http://vmgl.test/masters/accounts/'+ accountType +'/lists',
                    dataType:'json',
                    type:'get',
                    processData : false,
                    contentType:false,
                    success:function(data){
                        op +='<option value="0">Select Sub Account </option>';
                        for(var i=0;i<data.length;i++){
                            if(parentId != "create"){
                                op +='<option value="'+data[i].id+'" selected>'+data[i].account_no+ ' - ' +data[i].account_name+'</option>';
                            }else{
                                op +='<option value="'+data[i].id+'">'+data[i].account_no+ ' - ' +data[i].account_name+'</option>';
                            }
                        }
                        $('#parent_account_id').html("");
                        $('#parent_account_id').append(op);
                        $('.select').select2();
                    }
                });
            }else{
                $('#subAccount').hide();
            }
        }
    });
</script>
@endpush