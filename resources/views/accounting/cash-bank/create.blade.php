@extends('template.main')

@section('css')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('content')
<div class="grid grid-cols-12 gap-10 mt-5">
    <div class="intro-y col-span-12 lg:col-span-12 md:col-span-12 sm:col-span-12">
        @if(!empty($result['cashbank']))
        <form action="{{ route('cash-banks.update',['cash_bank'=> $result['cashbank']['id']]) }}" method="post" onkeydown="return event.key != 'Enter';">
        @else
        <form action="{{ route('cash-banks.store') }}" method="post" onkeydown="return event.key != 'Enter';">
        @endif
            @csrf
            @if(!empty($result['cashbank']))
            @method('PUT')
            <input 
                type="hidden" 
                readonly
                class="form-control text-center" 
                name="id"
                @if(!empty($result['cashbank']))
                value="{{ $result['cashbank']['id'] }}"
                @endif
                id="id">
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
                            @if(!empty($result['cashbank']))
                            value="{{ $result['cashbank']['code'] }}"
                            @endif
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
                                                @if(!empty($result['cashbank']))
                                                value="{{ \Carbon\Carbon::parse($result['cashbank']['transaction_date'])->format('d-m-Y') }}"
                                                @endif
                                                id="transaction_date">
                                        </div>
                                        <div class="input-group">
                                            <input 
                                                type="checkbox" 
                                                class="mt-3 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 form-check-input border mr-2" 
                                                name="cashbank_tipe"
                                                @if(!empty($result['cashbank']))
                                                    {{ $result['cashbank']['transaction_id'] == 1 ? checked : "" }}
                                                @endif
                                                id="cashbank_tipe">
                                            <span class="text-theme-20 mt-2" id="tipeName">
                                                @if(!empty($result['cashbank']))
                                                    {{ $result['cashbank']['transaction_id'] == 1 ? "Cash/Bank In" : "Cash/Bank Out" }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-text text-theme-20">
                                            <span class="text-theme-20" id="headAccount">
                                                @if(!empty($result['cashbank']))
                                                    {{ $result['cashbank']['transaction_id'] == 1 ?  __('cashbank.credit_account')  : __('cashbank.debet_account') }}
                                                @endif
                                            </span>
                                        </div>
                                        <select class="form-control select" name="account_id" id="account_id">
                                            <option value="0">{{ __('cashbank.select_account') }}</option>
                                            @foreach ($banks as $bank)
                                                @if(!empty($result['cashbank']))
                                                    @if($result['cashbank']['account_id'] == $bank->id)
                                                    <option value="{{ $bank->id }}" selected>{{ $bank->account_no }} - {{ $bank->account_name }}</option>
                                                    @else
                                                    <option value="{{ $bank->id }}">{{ $bank->account_no }} - {{ $bank->account_name }}</option>
                                                    @endif
                                                @else
                                                    <option value="{{ $bank->id }}">{{ $bank->account_no }} - {{ $bank->account_name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
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
                                            @if(!empty($result['cashbank']))
                                            value="{{ $result['cashbank']['description'] }}"
                                            @endif
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
                            <div id="cashbank-list">
                            </div>
                            <div class="grid grid-cols-12 gap-x-5 mt-0">
                                <div class="col-span-12 lg:col-span-9 md:col-span-9 sm:col-span-6 mt-2">
                                    <div class="col-span-12 lg:col-span-8 mt-2">
                                        <button type="button" class="btn btn-primary shadow-md mr-2" id="addLine">{{ trans('jurnal.add-account') }}</button>
                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-3 md:col-span-3 sm:col-span-6 mt-2">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            {{ __('jurnal.total_amount') }}
                                        </div>
                                        <input type="number" step="any" readonly name="totAmount" id="totAmount"  class="form-control text-right"/>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right mt-5">
                                <a href="{{ route('cash-banks.index') }}" class="btn closeModal btn-outline-secondary w-20 mr-1">Cancel</a>
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
    <script type="text/javascript">
        var transDate = '';
        var id = 0;
        var url = "{{ route('cash-banks.index') }}";
        var count = 1;
        var addState = "{{ request()->segment(count(request()->segments())) }}";
        var tipeValue = '';
        var debAccount = "{{ __('cashbank.debet_account') }}";
        var creAccount = "{{ __('cashbank.credit_account') }}";
        var checkValue =  $('#cashbank_tipe').is(":checked");
    
        $('#cashbank_tipe').on('click',function(){
            getNextJurnal();
        });
    
        function getNextJurnal()
        {
            transDate = $('#transaction_date').val();
            checkValue =  $('#cashbank_tipe').is(":checked");
            if(checkValue == false){
                tipeValue = 0;
                $('#tipeName').text('Cash/Bank Out');
                $('#headAccount').text(debAccount);
            }else{
                tipeValue = 1;
                $('#tipeName').text('Cash/Bank In');
                $('#headAccount').text(creAccount);
            }
            tanggalTransaksi = transDate.split("-").reverse().join("-");
            if(transDate != '__-__-_____' ){
                $.get(url + '/'+ tanggalTransaksi.replace('_','')  +'/next-transaction/'+tipeValue+'/type',  function(data, status){ 
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
            id = $('#id').val();
            $.get(url + '/'+ id +'/get-transaction',  function(data, status){ 
                for(var a=0;a<data.length;a++){
                    html = '<div class="grid grid-cols-12 gap-x-5 mt-0" id="line_'+ a +'"><input type="hidden" name="nomor[]" value="'+ a + '">';
                    html += '    <div class="col-span-12 lg:col-span-9 md:col-span-9 sm:col-span-6 mt-2">';
                    html += '        <div class="input-group">';
                    html += '            <div class="input-group-text">';
                    html += '                {{ __('jurnal.account') }}';
                    html += '            </div>';
                    html += '            <select class="form-control select" id="account_id_'+ a +'" name="account_id_'+ a +'">';
                    html += '               @foreach($accounts as $item) ';
                    html += '               <option value="0">Pilih Akun Transaksi</option>';
                    if(data[a].account_id == "{{ $item->id }}"){
                        html += '<option value="{{ $item->id }}" selected>{{ $item->account_no }} - {{ $item->account_name }}</option>';
                    }else{
                        html += '<option value="{{ $item->id }}">{{ $item->account_no }} - {{ $item->account_name }}</option>';
                    }
                    html += ' @endforeach </select>';
                    html += '        </div>';
                    html += '    </div>';
                    html += '    <div class="col-span-12 lg:col-span-3 md:col-span-3 sm:col-span-6 mt-2">';
                    html += '        <div class="input-group">';
                    html += '            <div class="input-group-text">';
                    html += '                {{ __('jurnal.amount') }}';
                    html += '            </div>';
                    html += '            <input type="text" name="amount_'+ a +'" id="amount_'+ a +'" value="'+formatNumber(accounting.toFixed(data[a].amount),2)+'" class="form-control amount debet text-right" />';
                    html += '        </div>';
                    html += '    </div>';
                    html += '    <div class="col-span-12 lg:col-span-12 md:col-span-12 sm:col-span-12 mt-2">';
                    html += '        <div class="input-group">';
                    html += '            <div class="input-group-text">';
                    html += '                {{ __('jurnal.memo') }}';
                    html += '            </div>';
                    html += '            <input type="text" name="memo_'+ a +'" id="memo_'+ a +'" value="'+data[a].memo+'" class="form-control" placeholder="{{ trans('jurnal.memo') }}"  />';
                    html += '            <button type="button" class="input-group-text remove">';
                    html += '                <x-feathericon-trash-2 class="w-4 h-4"></x-feathericon-trash-2>';
                    html += '            </button>';
                    html += '        </div>';
                    html += '    </div>';
                    html += '</div>';
    
                    $("#cashbank-list").append(html);
                    $('.select').select2();
                }
                calculateTotal();
            });
        }
    
        $(document).on('change keyup','.debet',function(){
            deb_arr = $(this).attr('id');
            id_deb = deb_arr.split("_");
    
            var deb_nStr = $('#debet_'+id_deb[1]).val();
            if(deb_nStr>0){
                $('#debet_'+id_deb[1]).val((deb_nStr));
            }else{
                $('#credit_'+id_deb[1]).val(0);
            }  
            calculateTotal();
        });
    
        $('.debet').on('keyup',function(event){
            if (event.key === 'Enter' ) {
                deb_arr = $(this).attr('id');
                id_deb = deb_arr.split("_");
    
                var deb_nStr = $('#debet_'+id_deb[1]).val();
                
                $('#debet_'+id_deb[1]).val(formatNumber(deb_nStr));
            }
        });
    
        function formatNumber(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
        }
    
        function moneyFormat(price, sign = '') {
            const pieces = parseFloat(price).toFixed(2).split('')
            let ii = pieces.length - 3
            while ((ii-=3) > 0) {
                pieces.splice(ii, 0, ',')
            }
            return sign + pieces.join('')
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
            html += '    <div class="col-span-12 lg:col-span-9 md:col-span-9 sm:col-span-6 mt-2">';
            html += '        <div class="input-group">';
            html += '            <div class="input-group-text">';
            html += '                {{ __('jurnal.account') }}';
            html += '            </div>';
            html += '            <select class="form-control select" id="account_id_'+ number +'" name="account_id_'+ number +'">';
            html += '               <option value="0">Pilih Akun Transaksi</option>';
            html += '               @foreach($accounts as $item) <option value="{{ $item->id }}">{{ $item->account_no }} - {{ $item->account_name }} @endforeach ';
            html += '            </select>';
            html += '        </div>';
            html += '    </div>';
            html += '    <div class="col-span-12 lg:col-span-3 md:col-span-3 sm:col-span-6 mt-2">';
            html += '        <div class="input-group">';
            html += '            <div class="input-group-text">';
            html += '                {{ __('jurnal.amount') }}';
            html += '            </div>';
            html += '            <input type="text" name="amount_'+ number +'" id="amount_'+ number +'" class="form-control amount debet text-right" />';
            html += '        </div>';
            html += '    </div>';
            html += '    <div class="col-span-12 lg:col-span-12 md:col-span-12 sm:col-span-12 mt-2">';
            html += '        <div class="input-group">';
            html += '            <div class="input-group-text">';
            html += '                {{ __('jurnal.memo') }}';
            html += '            </div>';
            html += '            <input type="text" name="memo_'+ number +'" id="memo_'+ number +'" class="form-control" placeholder="{{ trans('jurnal.memo') }}"  />';
            html += '            <button type="button" class="input-group-text remove">';
            html += '                <x-feathericon-trash-2 class="w-4 h-4"></x-feathericon-trash-2>';
            html += '            </button>';
            html += '        </div>';
            html += '    </div>';
            html += '</div>';
    
            $("#cashbank-list").append(html);
            $('.select').select2();
        }
    
        $('#addLine').on('click',function(){
            count++;
            dynamicField(count);
        })
    
        $(document).on('click', '.remove', function(){
            count--;
            $(this).parent().parent().parent().remove();
        })
    
        function calculateTotal(){
            totalDebet =0; totalCredit =0;
            balance = 0;
            $('.debet').each(function(){
                debetLine = changeNumber($(this).val());
                if(debetLine != '' )totalDebet += (parseFloat(debetLine.replace(/,/g,'')));
            });
            $('#totAmount').val((totalDebet));
        }
    </script>
    @endpush
@endsection