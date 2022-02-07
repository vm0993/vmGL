@extends('template.main')

@section('content')
<div class="grid grid-cols-12 gap-10 mt-5">
    <div class="intro-y col-span-12 lg:col-span-12 md:col-span-12 sm:col-span-12">
        @if(!empty($result))
        <form action="{{ route('jurnals.update',['id'=> $result['id']]) }}" method="post" onkeydown="return event.key != 'Enter';">
        @else
        <form action="{{ route('jurnals.store') }}" method="post" onkeydown="return event.key != 'Enter';">
        @endif
            @csrf
            @if(!empty($result))
            @method('PUT')
            @endif
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        Jurnal Baru
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
                                <div class="col-span-12 lg:col-span-6 sm:col-span-3 mt-1">
                                    <div class="input-group">
                                        <div class="input-group-text w-full text-center">
                                            <span class="text-theme-20">Account&nbsp;Name</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-3 sm:col-span-3 mt-1">
                                    <div class="input-group">
                                        <div class="input-group-text w-full text-center">
                                            <span class="text-theme-20">Debet</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-3 sm:col-span-3 mt-1">
                                    <div class="input-group">
                                        <div class="input-group-text w-full text-center">
                                            <span class="text-theme-20">Credit</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="jurnal-list">
                            </div>
                            {{--  <div class="grid grid-cols-12 gap-x-5 mt-0">
                                <div class="col-span-12 lg:col-span-6 sm:col-span-3 mt-2">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            {{ __('jurnal.account') }}
                                        </div>
                                        <input type="number" step="any" class="form-control text-right" />
                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-3 sm:col-span-3 mt-2">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            {{ __('jurnal.debet') }}
                                        </div>
                                        <input type="number" step="any" class="form-control text-right" />
                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-3 sm:col-span-3 mt-2">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            {{ __('jurnal.credit') }}
                                        </div>
                                        <input type="number" step="any" class="form-control text-right"/>
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
                            </div>  --}}
                            <div class="grid grid-cols-12 gap-x-5 mt-0">
                                <div class="col-span-12 lg:col-span-6 sm:col-span-3 mt-2">
                                    <div class="col-span-12 lg:col-span-8 mt-2">
                                        <button type="button" class="btn btn-primary shadow-md mr-2" id="addLine">{{ trans('jurnal.add-account') }}</button>
                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-3 sm:col-span-3 mt-2">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            {{ __('jurnal.total_debet') }}
                                        </div>
                                        <input type="number" step="any" readonly name="totDebet" id="debetTotal" class="form-control text-right"/>
                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-3 sm:col-span-3 mt-2">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            {{ __('jurnal.total_credit') }}
                                        </div>
                                        <input type="number" step="any" readonly name="totCredit" id="creditTotal" class="form-control text-right"/>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right mt-5">
                                <a href="{{ route('jurnals.index') }}" class="btn closeModal btn-outline-secondary w-20 mr-1">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@push('scripts')
<script type="text/javascript">
    var transDate = '';
    var url = "{{ route('jurnals.index') }}";
    var count = 1;
    var addState = "{{ request()->segment(count(request()->segments())) }}";

    function getNextJurnal()
    {
        transDate = $('#transaction_date').val();
        tanggalTransaksi = transDate.split("-").reverse().join("-");
        if(transDate != null ){
            $.get(url + '/'+ tanggalTransaksi.replace('_','')  +'/next-transaction',  function(data, status){ 
                $('#voucher_no').val(data);
            });
        }else{
            alert('Please enter transaction date!');
        }
    }

    $('#transaction_date').on('keyup',function(event){
        if (event.key === 'Enter' ) {
            getNextJurnal();
        }
    });

    if(addState=='create'){
        dynamicField(1);
    }else{
        //loadJurnal();
    }

    $('.debet').on('change keyup',function(){
        id_arr = $(this).attr('id');
        id = id_arr.split("_");

        var nStr = $('#debet_'+id[1]).val();
        nStr = nStr.replace(/\,/g, "");
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';  
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }

        debet  = x1 + x2; //formatNumber($('#debet_'+id[1]).val());
        //console.log(debet);
        if(debet>0){
            $('#debet_'+id[1]).val((debet));
        }else{
            $('#credit_'+id[1]).val(0);
        }  
        calculateTotal();
    });

    $('.credit').on('change keyup',function(){
        id_arr = $(this).attr('id');
        id = id_arr.split("_");

        var nStr = $('#credit_'+id[1]).val();
        nStr = nStr.replace(/\,/g, "");
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';  
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }

        credit  = x1 + x2;
        
        if(credit>0){
            $('#debet_'+id[1]).val(0);
        }else{
            $('#credit_'+id[1]).val((credit));
        }
        calculateTotal();
    });

    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }
    
    function changeNumber(num){
        return num.toString().replace('.', '')
    }

    function validate(evt) {
        var theEvent = evt || window.event;
    
        // Handle paste
        if (theEvent.type === 'paste') {
            key = event.clipboardData.getData('text/plain');
        } else {
        // Handle key press
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
        }
        var regex = /[0-9]|\./;
        if( !regex.test(key) ) {
            theEvent.returnValue = false;
            if(theEvent.preventDefault) theEvent.preventDefault();
        }
    }

    function dynamicField(number){
        html = '<div class="grid grid-cols-12 gap-x-5 mt-0" id="line_'+ number +'"><input type="hidden" name="nomor[]" value="'+ number + '">';
        html += '    <div class="col-span-12 lg:col-span-6 sm:col-span-3 mt-2">';
        html += '        <div class="input-group">';
        html += '            <div class="input-group-text">';
        html += '                {{ __('jurnal.account') }}';
        html += '            </div>';
        html += '            <select class="tom-select w-full" id="account_id_'+ number +'" name="account_id_'+ number +'">';
        html += '               <option value="0">Pilih Akun Transaksi</option>';
        html += '               @foreach($accounts as $item) <option value="{{ $item->id }}">{{ $item->account_no }} - {{ $item->account_name }} @endforeach ';
        html += '            </select>';
        html += '        </div>';
        html += '    </div>';
        html += '    <div class="col-span-12 lg:col-span-3 sm:col-span-3 mt-2">';
        html += '        <div class="input-group">';
        html += '            <div class="input-group-text">';
        html += '                {{ __('jurnal.debet') }}';
        html += '            </div>';
        html += '            <input type="text" step="any" name="debet_'+ number +'" id="debet_'+ number +'" onkeypress="validate(event)" class="form-control amount debet text-right" />';
        html += '        </div>';
        html += '    </div>';
        html += '    <div class="col-span-12 lg:col-span-3 sm:col-span-3 mt-2">';
        html += '        <div class="input-group">';
        html += '            <div class="input-group-text">';
        html += '                {{ __('jurnal.credit') }}';
        html += '            </div>';
        html += '            <input type="text" step="any" name="credit_'+ number +'" id="credit_'+ number +'" onkeypress="validate(event)" class="form-control amount credit text-right"/>';
        html += '        </div>';
        html += '    </div>';
        html += '    <div class="col-span-12 lg:col-span-12 sm:col-span-12 mt-2">';
        html += '        <div class="input-group">';
        html += '            <div class="input-group-text">';
        html += '                {{ __('jurnal.memo') }}';
        html += '            </div>';
        html += '            <input type="text" name="memo_'+ number +'" id="memo_'+ number +'" class="form-control" placeholder="{{ trans('jurnal.memo') }}"  />';
        html += '            <div class="input-group-text remove">';
        html += '                <x-feathericon-trash-2 class="w-4 h-4"></x-feathericon-trash-2>';
        html += '            </div>';
        html += '        </div>';
        html += '    </div>';
        html += '</div>';

        $("#jurnal-list").append(html);
    }

    $('#addLine').on('click',function(){
        count++;
        dynamicField(count);
    })

    $('.remove').on('click',function(){
        count--;
        $(this).parent().parent().parent().remove();
    })

    function calculateTotal(){
        totalDebet =0; totalCredit =0;
        balance = 0;
        $('.debit').each(function(){
            debetLine = changeNumber($(this).val());
            //console.log((debetLine));
            //if($(this).val() != '' )totalDebet += (parseFloat($(this).val() ));
            if(debetLine != '' )totalDebet += (parseFloat(debetLine.replace(/,/g,'')));
        });
        //totalD = formatNumber(totalDebet);
        //console.log(formatNumber(totalDebet));
        $('#debetTotal').val((totalDebet));
        $('.credit').each(function(){
            creditLine = changeNumber($(this).val());
            //if($(this).val() != '' )totalCredit += (parseFloat($(this).val()));
            if(creditLine != '' )totalCredit += (parseFloat(creditLine.replace(/,/g,'')));
        });
        $('#creditTotal').val((totalCredit));
        balance = totalDebet-totalCredit;
        console.log(balance);
        //$('#balance').val(totalDebet-totalCredit);
    }
    
</script>
@endpush