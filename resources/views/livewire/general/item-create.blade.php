<x-jet-dialog-modal wire:model="create">
    <x-slot name="title">
        {{ ( $this->item_id) ? trans('item.edit-title') : trans('item.add-title') }}
    </x-slot>
    <x-slot name="content">
        <div class="col-span-12 xl:col-span-3">
            <div>
                <label for="formCategory" class="form-label mb-2">{{ trans('item.category_id') }}</label>
                <select class="tom-select w-full" wire:model="category_id" id="formCategory" placeholder="{{ trans('item.category_id') }}" >
                    <option value="">{{ trans('item.category') }}</option>
                    @foreach ($categorys as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-span-12 xl:col-span-3">
            <div>
                <label for="formCode" class="form-label mb-2">{{ trans('global.code') }}</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formCode" placeholder="Enter Code" wire:model="code">
                @error('code') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-span-12 xl:col-span-2">
            <label class="form-label mb-2">Sales</label>
            <div class="flex flex-col sm:flex-row mt-4">
                <div class="form-check mr-2">
                    <input id="checkbox-switch-4" class="form-check-input" type="checkbox" name="sold_id" wire:model="sold_id">
                    <label class="form-check-label" for="checkbox-switch-4">Yes/No</label>
                </div>
            </div>
        </div>
        <div class="col-span-12 xl:col-span-2">
            <label class="form-label mb-2">Purchase</label>
            <div class="flex flex-col sm:flex-row mt-4">
                <div class="form-check mr-2">
                    <input id="checkbox-switch-4" class="form-check-input" type="checkbox" name="purchase_item_id" wire:model="purchase_item_id">
                    <label class="form-check-label" for="checkbox-switch-4">Yes/No</label>
                </div>
            </div>
        </div>
        <div class="col-span-12 xl:col-span-2">
            <label class="form-label mb-2">Stockable</label>
            <div class="flex flex-col sm:flex-row mt-4">
                <div class="form-check mr-2">
                    <input id="checkbox-switch-4" class="form-check-input" type="checkbox" name="stock_id" wire:model="stock_id">
                    <label class="form-check-label" for="checkbox-switch-4">Yes/No</label>
                </div>
            </div>
        </div>
        <div class="col-span-12 xl:col-span-6">
            <div>
                <label for="formName" class="form-label mb-2">{{ trans('global.name') }}</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formName" placeholder="Enter Name" wire:model="name">
                @error('name') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-span-12 xl:col-span-6">
            <div>
                <label for="formAlias" class="form-label mb-2">{{ trans('global.alias') }}</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formAlias" placeholder="Enter Alias Name" wire:model="alias_name">
                @error('alias_name') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-span-12 xl:col-span-3 mt-3">
            <div>
                <label for="formUnit" class="form-label mb-2">{{ trans('item.unit_id') }}</label>
                <select class="tom-select w-full" wire:model="unit_id" id="formUnit" placeholder="{{ trans('item.unit_id') }}" >
                    <option value="">{{ trans('item.unit') }}</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                    @endforeach
                </select>
                @error('unit_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-span-12 xl:col-span-3 mt-3">
            <div>
                <label for="formTax" class="form-label mb-2">{{ trans('item.tax_id') }}</label>
                <select class="tom-select w-full" wire:model="tax_id" id="formTax" placeholder="{{ trans('item.tax_id') }}" >
                    <option value="">{{ trans('item.tax') }}</option>
                    @foreach ($taxs as $tax)
                        <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                    @endforeach
                </select>
                @error('tax_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-span-12 xl:col-span-3 mt-3">
            <div>
                <label for="formSell" class="form-label mb-2">{{ trans('item.sell_price') }}</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-right" id="formSell" placeholder="Enter Sell Price" wire:model="sell_price">
                @error('sell_price') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-span-12 xl:col-span-3 mt-3">
            <div>
                <label for="formBuy" class="form-label mb-2">{{ trans('item.buy_price') }}</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-right" id="formBuy" placeholder="Enter Buy Price" wire:model="buy_price">
                @error('buy_price') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>{{-- 
        <div class="col-span-12 xl:col-span-6 mt-2">
            <div>
                <label for="formProject" class="form-label">{{ trans('setting.inventory_id') }}</label>
                <select data-placeholder="{{ trans('setting.select_inventory_id') }}" class="tom-select w-full" wire:model="inventory_id">
                    <option value="">{{ trans('setting.select_inventory_id') }}</option>
                    @foreach (getAccountByType(4) as $accAP)
                        <option value="{{ $accAP->id }}">{{ $accAP->account_no }} - {{ $accAP->account_name }}</option>
                    @endforeach
                </select>
                @error('inventory_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-span-12 xl:col-span-6 mt-2">
            <div>
                <label for="formProject" class="form-label">{{ trans('setting.sale_id') }}</label>
                <select data-placeholder="{{ trans('setting.select_sale_id') }}" class="tom-select w-full" wire:model="sale_id">
                    <option value="">{{ trans('setting.select_sale_id') }}</option>
                    @foreach (getAccountByType(16) as $accAR)
                        <option value="{{ $accAR->id }}">{{ $accAR->account_no }} - {{ $accAR->account_name }}</option>
                    @endforeach
                </select>
                @error('sale_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-span-12 xl:col-span-6 mt-2">
            <div>
                <label for="formProject" class="form-label">{{ trans('setting.sale_return_id') }}</label>
                <select data-placeholder="{{ trans('setting.select_sale_return_id') }}" class="tom-select w-full" wire:model="sale_return_id">
                    <option value="">{{ trans('setting.select_sale_return_id') }}</option>
                    @foreach (getAccountByType(16) as $accAP)
                        <option value="{{ $accAP->id }}">{{ $accAP->account_no }} - {{ $accAP->account_name }}</option>
                    @endforeach
                </select>
                @error('sale_return_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-span-12 xl:col-span-6 mt-2">
            <div>
                <label for="formProject" class="form-label">{{ trans('setting.sale_discount_id') }}</label>
                <select data-placeholder="{{ trans('setting.select_sale_discount_id') }}" class="tom-select w-full" wire:model="sale_discount_id">
                    <option value="">{{ trans('setting.select_sale_discount_id') }}</option>
                    @foreach (getAccountByType(16) as $accAR)
                        <option value="{{ $accAR->id }}">{{ $accAR->account_no }} - {{ $accAR->account_name }}</option>
                    @endforeach
                </select>
                @error('sale_discount_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-span-12 xl:col-span-6 mt-2">
            <div>
                <label for="formProject" class="form-label">{{ trans('setting.delivery_id') }}</label>
                <select data-placeholder="{{ trans('setting.select_delivery_id') }}" class="tom-select w-full" wire:model="delivery_id">
                    <option value="">{{ trans('setting.select_delivery_id') }}</option>
                    @foreach (getAccountByType(4) as $accAP)
                        <option value="{{ $accAP->id }}">{{ $accAP->account_no }} - {{ $accAP->account_name }}</option>
                    @endforeach
                </select>
                @error('delivery_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-span-12 xl:col-span-6 mt-2">
            <div>
                <label for="formProject" class="form-label">{{ trans('setting.cogs_id') }}</label>
                <select data-placeholder="{{ trans('setting.select_cogs_id') }}" class="tom-select w-full" wire:model="cogs_id">
                    <option value="">{{ trans('setting.select_cogs_id') }}</option>
                    @foreach (getAccountByType(17) as $accAR)
                        <option value="{{ $accAR->id }}">{{ $accAR->account_no }} - {{ $accAR->account_name }}</option>
                    @endforeach
                </select>
                @error('cogs_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-span-12 xl:col-span-6 mt-2">
            <div>
                <label for="formProject" class="form-label">{{ trans('setting.purchase_return_id') }}</label>
                <select data-placeholder="{{ trans('setting.select_purchase_return_id') }}" class="tom-select w-full" wire:model="purchase_return_id">
                    <option value="">{{ trans('setting.select_purchase_return_id') }}</option>
                    @foreach (getAccountByType(4) as $accAR)
                        <option value="{{ $accAR->id }}">{{ $accAR->account_no }} - {{ $accAR->account_name }}</option>
                    @endforeach
                </select>
                @error('purchase_return_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
            </div>
        </div> --}}
    </x-slot>
    <x-slot name="footer">
        <button type="button" wire:click="closeModal" class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">{{ trans('global.cancel-button') }}</button>
        <button type="button" wire:click.prevent="save" class="btn btn-primary w-20">{{ trans('global.save-button') }}</button>
    </x-slot>
</x-jet-dialog-modal>
