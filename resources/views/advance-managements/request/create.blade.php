@extends('template.main')

@section('css')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('content')
<div class="grid grid-cols-12 gap-10 mt-5">
    <div class="intro-y col-span-12 lg:col-span-12 md:col-span-12 sm:col-span-12">
        @if(!empty($result['cashbank']))
        <form action="{{ route('advance-requests.update',['advance_request' => $result['advance']['id']]) }}" method="post" onkeydown="return event.key != 'Enter';">
        @else
        <form action="{{ route('advance-requests.store') }}" method="post" onkeydown="return event.key != 'Enter';">
        @endif
            @csrf
            @if(!empty($result['advance']))
            @method('PUT')
            <input 
                type="hidden" 
                readonly
                class="form-control text-center" 
                name="id"
                @if(!empty($result['advance']))
                value="{{ $result['advance']['id'] }}"
                @endif
                id="id">
            @endif
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        Advance Request Baru
                    </h2>
                    <div class="text-right">
                        <input 
                            type="text" 
                            readonly
                            placeholder="Request Advance No"
                            class="form-control text-center" 
                            name="voucher_no"
                            @if(!empty($result['advance']))
                            value="{{ $result['advance']['code'] }}"
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
                                                @if(!empty($result['advance']))
                                                value="{{ \Carbon\Carbon::parse($result['advance']['transaction_date'])->format('d-m-Y') }}"
                                                @endif
                                                id="transaction_date">
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-text text-theme-20">
                                                <span class="text-theme-20">Personel</span>
                                            </div>
                                            <select class="form-control select" name="personel_id" id="personel_id">
                                                <option value="0">{{ __('advance-request.select_pic') }}</option>
                                                @foreach ($personels as $personel)
                                                    @if(!empty($result['advance']))
                                                        @if($result['advance']['personel_id'] == $personel->id)
                                                        <option value="{{ $personel->id }}" selected>{{ $personel->name }}</option>
                                                        @else
                                                        <option value="{{ $personel->id }}">{{ $personel->name }}</option>
                                                        @endif
                                                    @else
                                                        <option value="{{ $personel->id }}">{{ $personel->name }} </option>
                                                    @endif
                                                @endforeach
                                            </select>
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
                                            @if(!empty($result['advance']))
                                            value="{{ $result['advance']['description'] }}"
                                            @endif
                                            id="description">
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 gap-x-5 mt-1">
                                <div class="col-span-12 lg:col-span-9 md:col-span-9 sm:col-span-6 mt-1">
                                    <div class="input-group">
                                        <div class="input-group-text w-full text-center">
                                            <span class="text-theme-20">Job&nbsp;Order</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-3 md:col-span-3 sm:col-span-6 mt-1">
                                    <div class="input-group">
                                        <div class="input-group-text w-full text-center">
                                            <span class="text-theme-20">Request Amount</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="advance-list">
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
                                            {{ __('advance-request.total_amount') }}
                                        </div>
                                        <input type="number" step="any" readonly name="totAmount" id="totAmount"  class="form-control text-right"/>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right mt-5">
                                <a href="{{ route('advance-requests.index') }}" class="btn closeModal btn-outline-secondary w-20 mr-1">Cancel</a>
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
        var url = "{{ route('advance-requests.index') }}";
        var count = 1;
        var addState = "{{ request()->segment(count(request()->segments())) }}";
        
        $('.select').select2();

        function getNextJurnal()
        {
            transDate = $('#transaction_date').val();
            tanggalTransaksi = transDate.split("-").reverse().join("-");
            if(transDate != '__-__-_____' ){
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
            id = $('#id').val();
            $.get(url + '/'+ id +'/get-transaction',  function(data, status){ 
                for(var a=0;a<data.length;a++){
                    html = '<div class="grid grid-cols-12 gap-x-5 mt-0" id="line_'+ a +'"><input type="hidden" name="nomor[]" value="'+ a + '">';
                    html += '    <div class="col-span-12 lg:col-span-9 md:col-span-9 sm:col-span-6 mt-2">';
                    html += '        <div class="input-group">';
                    html += '            <div class="input-group-text">';
                    html += '                {{ __('advance-request.job_order') }}';
                    html += '            </div>';
                    html += '            <select class="form-control select" id="job_order_'+ a +'" name="job_order_'+ a +'">';
                    html += '               @foreach($jobs as $item) ';
                    html += '               <option value="0">Pilih Job</option>';
                    if(data[a].job_order_id == "{{ $item->id }}"){
                        html += '<option value="{{ $item->id }}" selected>{{ $item->code }} - {{ $item->name }}</option>';
                    }else{
                        html += '<option value="{{ $item->id }}">{{ $item->code }} - {{ $item->name }}</option>';
                    }
                    html += ' @endforeach </select>';
                    html += '        </div>';
                    html += '    </div>';
                    html += '    <div class="col-span-12 lg:col-span-3 md:col-span-3 sm:col-span-6 mt-2">';
                    html += '        <div class="input-group">';
                    html += '            <div class="input-group-text">';
                    html += '                {{ __('advance-request.amount') }}';
                    html += '            </div>';
                    html += '            <input type="text" step="any" name="amount_'+ a +'" id="amount_'+ a +'" value="'+formatNumber(accounting.toFixed(data[a].amount),2)+'" class="form-control amount debet text-right" />';
                    html += '        </div>';
                    html += '    </div>';
                    html += '    <div class="col-span-12 lg:col-span-12 md:col-span-12 sm:col-span-12 mt-2">';
                    html += '        <div class="input-group">';
                    html += '            <div class="input-group-text">';
                    html += '                {{ __('advance-request.memo') }}';
                    html += '            </div>';
                    html += '            <input type="text" name="memo_'+ a +'" id="memo_'+ a +'" value="'+data[a].note+'" class="form-control" placeholder="{{ trans('jurnal.memo') }}"  />';
                    html += '            <button type="button" class="input-group-text remove">';
                    html += '                <x-feathericon-trash-2 class="w-4 h-4"></x-feathericon-trash-2>';
                    html += '            </button>';
                    html += '        </div>';
                    html += '    </div>';
                    html += '</div>';
    
                    $("#advance-list").append(html);
                    $('.select').select2();
                }
                calculateTotal();
            });
        }

        $(document).on('change keyup','.debet',function(){
            deb_arr = $(this).attr('id');
            id_deb = deb_arr.split("_");
    
            var deb_nStr = $('#debet_'+id_deb[1]).val();
            $('#debet_'+id_deb[1]).val((deb_nStr));
            calculateTotal();
        });
    
        $('.debet').on('keyup',function(event){
            if (event.key === 'Enter' ) {
                deb_arr = $(this).attr('id');
                id_deb = deb_arr.split("_");
    
                var deb_nStr = $('#amount_'+id_deb[1]).val();
                
                $('#amount_'+id_deb[1]).val(formatNumber(deb_nStr));
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
            html += '                {{ __('advance-request.job_order') }}';
            html += '            </div>';
            html += '            <select class="form-control select" id="job_order_'+ number +'" name="job_order_'+ number +'">';
            html += '               <option value="0">Pilih Job</option>';
            html += '               @foreach($jobs as $item) <option value="{{ $item->id }}">{{ $item->code }} - {{ $item->name }} @endforeach ';
            html += '            </select>';
            html += '        </div>';
            html += '    </div>';
            html += '    <div class="col-span-12 lg:col-span-3 md:col-span-3 sm:col-span-6 mt-2">';
            html += '        <div class="input-group">';
            html += '            <div class="input-group-text">';
            html += '                {{ __('advance-request.amount') }}';
            html += '            </div>';
            html += '            <input type="text" step="any" name="amount_'+ number +'" id="amount_'+ number +'" class="form-control amount debet text-right" />';
            html += '        </div>';
            html += '    </div>';
            html += '    <div class="col-span-12 lg:col-span-12 md:col-span-12 sm:col-span-12 mt-2">';
            html += '        <div class="input-group">';
            html += '            <div class="input-group-text">';
            html += '                {{ __('advance-request.memo') }}';
            html += '            </div>';
            html += '            <input type="text" name="memo_'+ number +'" id="memo_'+ number +'" class="form-control" placeholder="{{ trans('jurnal.memo') }}"  />';
            html += '            <button type="button" class="input-group-text remove">';
            html += '                <x-feathericon-trash-2 class="w-4 h-4"></x-feathericon-trash-2>';
            html += '            </button>';
            html += '        </div>';
            html += '    </div>';
            html += '</div>';
    
            $("#advance-list").append(html);
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