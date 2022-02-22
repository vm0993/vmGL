@extends('template.main')

@section('css')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('content')
    <div class="intro-y flex items-center mt-2">
        <h2 class="text-lg font-medium mr-auto">{{ $title }}</h2>
    </div>
    <div class="grid grid-cols-12 gap-10 mt-2">
        <div class="intro-y col-span-12 lg:col-span-8 md:col-span-10 sm:col-span-10">
            @if(!empty($result))
            <form action="{{ route('items.update',['item'=> $result['id']]) }}" method="post">
            @else
            <form action="{{ route('items.store') }}" method="post">
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
                                    <div for="category_id" class="input-group-text"><strong>Category</strong></div>
                                    <select 
                                        class="form-control select" 
                                        name="category_id" 
                                        id="category_id" 
                                        placeholder="{{ trans('item.select_category') }}" >
                                        <option value="">{{ trans('item.select_category') }}</option>
                                        @if(!empty($result))
                                            @foreach ($categorys as $category)
                                                @if($result['category_id']==$category->id)
                                                <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                                @else
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach ($categorys as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('category_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
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
                                        <input 
                                            type="checkbox" 
                                            class="mt-3 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 form-check-input border mr-2" 
                                            name="inventory_type"
                                            @if(!empty($result))
                                                {{ $result['inventory'] == 1 ? checked : "" }}
                                            @endif
                                            id="inventory_type">
                                        <span class="text-theme-20 mt-2" id="tipeName">
                                            @if(!empty($result))
                                                {{ $result['inventory'] == 1 ? "Inventory Part" : "Non Inventory Part" }}
                                            @endif
                                        </span>
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
                                        placeholder="Item Name"/>
                                    @error('name') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                    <div class="input-group">
                                        <div for="unit_id" class="input-group-text"><strong>Unit</strong></div>
                                        <select 
                                            class="form-control select" 
                                            name="unit_id" 
                                            id="unit_id" 
                                            placeholder="{{ trans('item.select_unit') }}" >
                                            <option value="">{{ trans('item.select_unit') }}</option>
                                            @if(!empty($result))
                                                @foreach ($units as $unit)
                                                    @if($result['unit_id']==$unit->id)
                                                    <option value="{{ $unit->id }}" selected>{{ $unit->name }}</option>
                                                    @else
                                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                    @endif
                                                @endforeach
                                            @else
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('unit_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                    <div class="input-group">
                                        <div for="buy_price" class="input-group-text"><strong>Buy&nbsp;Price</strong></div>
                                        <input
                                            type="text"
                                            name="buy_price"
                                            id="buy_price"
                                            step="any" 
                                            type-currency="IDR"
                                            @if(!empty($result))
                                                value="{{ $result['buyPrice'] }}"
                                            @endif
                                            class="form-control text-right"
                                            placeholder="Buy Amount"/>
                                        @error('buy_price') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="input-group">
                                        <div for="sell_price" class="input-group-text"><strong>Sell&nbsp;Price</strong></div>
                                        <input
                                            type="text"
                                            name="sell_price"
                                            id="sell_price"
                                            step="any" 
                                            type-currency="IDR"
                                            @if(!empty($result))
                                                value="{{ $result['sellPrice'] }}"
                                            @endif
                                            class="form-control text-right"
                                            placeholder="Sell Amount"/>
                                        @error('sell_price') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                <div class="input-group"></div>
                                <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                    <div class="input-group">
                                        <div for="buy_tax_id" class="input-group-text"><strong>Purchase&nbsp;Tax</strong></div>
                                        <select 
                                            class="form-control select" 
                                            name="buy_tax_id" 
                                            id="buy_tax_id" 
                                            placeholder="{{ trans('item.select_purchase_tax') }}" >
                                            <option value="">{{ trans('item.select_purchase_tax') }}</option>
                                            @if(!empty($result))
                                                @foreach ($taxs as $tax)
                                                    @if($result['purchaseTaxID']==$tax->id)
                                                    <option value="{{ $tax->id }}" selected>{{ $tax->name }}</option>
                                                    @else
                                                    <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                                                    @endif
                                                @endforeach
                                            @else
                                                @foreach ($taxs as $tax)
                                                    <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('buy_tax_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="input-group">
                                        <div for="sell_tax_id" class="input-group-text"><strong>Sell&nbsp;Tax</strong></div>
                                        <select 
                                            class="form-control select" 
                                            name="sell_tax_id" 
                                            id="sell_tax_id" 
                                            placeholder="{{ trans('item.select_sales_tax') }}" >
                                            <option value="">{{ trans('item.select_sales_tax') }}</option>
                                            @if(!empty($result))
                                                @foreach ($taxs as $tax)
                                                    @if($result['saleTaxID']==$tax->id)
                                                    <option value="{{ $tax->id }}" selected>{{ $tax->name }}</option>
                                                    @else
                                                    <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                                                    @endif
                                                @endforeach
                                            @else
                                                @foreach ($taxs as $tax)
                                                    <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('sell_tax_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="md:grid grid-cols-1 sm:grid grid-cols-1 gap-2">
                                <div class="input-group">
                                    <div for="note" class="input-group-text"><strong>Note</strong></div>
                                    <input
                                        type="text"
                                        name="note"
                                        id="note"
                                        rows="4"
                                        @if(!empty($result))
                                            value="{{ $result['note'] }}"
                                        @endif
                                        class="form-control"
                                        placeholder="Note"/>
                                </div>
                            </div>
                        </div>
                        <div class="text-right mt-5">
                            <a href="{{ route('items.index') }}" class="btn btn-outline-secondary w-24 mr-1">Cancel</a>
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
        var parentId = "{{ request()->segment(count(request()->segments())) }}";
        var op = '';

        $('.select').select2();

        checkInventoryType();
        
        function checkInventoryType()
        {
            checkValue =  $('#inventory_type').is(":checked");
            if(checkValue == false){
                tipeValue = 0;
                $('#tipeName').text('Non Inventory Part');
            }else{
                tipeValue = 1;
                $('#tipeName').text('Inventory Part');
            }
        }
        $('#inventory_type').on('click',function(){
            checkInventoryType();
        });
    </script>
@endpush