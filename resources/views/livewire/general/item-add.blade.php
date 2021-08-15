<div class="col-span-12">
    <div class="post intro-y overflow-hidden box">
        <div class="post__tabs nav nav-tabs flex-col sm:flex-row bg-gray-300 dark:bg-dark-2 text-gray-600" role="tablist">
            <a title="Item information" data-toggle="tab" data-target="#item" href="javascript:;" class="tooltip w-full sm:w-40 py-4 text-center flex justify-center items-center active" id="item-tab" role="tab" aria-controls="item" aria-selected="true">
                <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Item Info
            </a>
            <a title="Item Account Default" data-toggle="tab" data-target="#itemDefault" href="javascript:;" class="tooltip w-full sm:w-40 py-4 text-center flex justify-center items-center" id="itemDefault-tab" role="tab" aria-selected="false">
                <i data-feather="code" class="w-4 h-4 mr-2"></i> Item Default
            </a>
        </div>
        <div class="post__content tab-content">
            <div id="item" class="tab-pane p-5 active mr-2" role="tabpanel" aria-labelledby="item-tab">
                <div class="col-span-12">
                    <div class="col-span-12 xl:col-span-3">
                        <div>
                            <label for="formCategory" class="form-label mb-2">{{ trans('item.category_id') }}</label>
                            <select class="tom-select w-full" wire:model="editing.category_id" id="formCategory" placeholder="{{ trans('item.category_id') }}" >
                                <option value="">{{ trans('item.category') }}</option>
                                @foreach ($categorys as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('editing.category_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-3">
                        <div>
                            <label for="formCode" class="form-label mb-2">{{ trans('global.code') }}</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formCode" placeholder="Enter Code" wire:model="editing.code">
                            @error('editing.code') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-2">
                        <label class="form-label mb-2">Sales</label>
                        <div class="flex flex-col sm:flex-row mt-4">
                            <div class="form-check mr-2">
                                <input id="checkbox-switch-4" class="form-check-input" type="checkbox" name="sold_id" wire:model="editing.sold_id">
                                <label class="form-check-label" for="checkbox-switch-4">Yes/No</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-2">
                        <label class="form-label mb-2">Purchase</label>
                        <div class="flex flex-col sm:flex-row mt-4">
                            <div class="form-check mr-2">
                                <input id="checkbox-switch-4" class="form-check-input" type="checkbox" name="purchase_item_id" wire:model="editing.purchase_item_id">
                                <label class="form-check-label" for="checkbox-switch-4">Yes/No</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-2">
                        <label class="form-label mb-2">Stockable</label>
                        <div class="flex flex-col sm:flex-row mt-4">
                            <div class="form-check mr-2">
                                <input id="checkbox-switch-4" class="form-check-input" type="checkbox" name="stock_id" wire:model="editing.stock_id">
                                <label class="form-check-label" for="checkbox-switch-4">Yes/No</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-6">
                        <div>
                            <label for="formName" class="form-label mb-2">{{ trans('global.name') }}</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formName" placeholder="Enter Name" wire:model="editing.name">
                            @error('editing.name') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-6">
                        <div>
                            <label for="formAlias" class="form-label mb-2">{{ trans('global.alias') }}</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formAlias" placeholder="Enter Alias Name" wire:model="editing.alias_name">
                            @error('editing.alias_name') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-2 mt-3">
                        <div>
                            <label for="formUnit" class="form-label mb-2">{{ trans('item.unit_id') }}</label>
                            <select class="tom-select w-full" wire:model="editing.unit_id" id="formUnit" placeholder="{{ trans('item.unit_id') }}" >
                                <option value="">{{ trans('item.unit') }}</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                            @error('editing.unit_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-2 mt-3">
                        <div>
                            <label for="formTax" class="form-label mb-2">{{ trans('item.tax_id') }}</label>
                            <select class="tom-select w-full" wire:model="editing.tax_id" id="formTax" placeholder="{{ trans('item.tax_id') }}" >
                                <option value="">{{ trans('item.tax') }}</option>
                                @foreach ($taxs as $tax)
                                    <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                                @endforeach
                            </select>
                            @error('editing.tax_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-2 mt-3">
                        <div>
                            <label for="formSell" class="form-label mb-2">{{ trans('item.sell_price') }}</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-right" id="formSell" placeholder="Enter Sell Price" wire:model="editing.sell_price">
                            @error('editing.sell_price') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-2 mt-3">
                        <div>
                            <label for="formBuy" class="form-label mb-2">{{ trans('item.buy_price') }}</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-right" id="formBuy" placeholder="Enter Buy Price" wire:model="editing.buy_price">
                            @error('editing.buy_price') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
            </div>
            <div id="itemDefault" class="tab-pane p-5 active" role="tabpanel" aria-labelledby="itemDefault-tab">
            </div>
        </div>
    </div>
</div>