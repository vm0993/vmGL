<x-jet-dialog-modal wire:model="create">
    <x-slot name="title">
        {{ ( $this->currency_default_account_id) ? trans('currency.edit-default') : trans('currency.add-default') }}
    </x-slot>

    <x-slot name="content">
        <div class="col-span-12 xl:col-span-12">
            <x-jet-label class="block text-gray-700 text-sm font-bold mb-2">{{ trans('currency.code') }}</x-jet-label>
            <x-jet-input type="text" readonly class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formCode" wire:model="code"/>
        </div>
        <div class="col-span-12 xl:col-span-6 mt-2">
            <div>
                <label for="formProject" class="form-label">{{ trans('currency.payable_id') }}</label>
                <select data-placeholder="Select Request" class="tom-select w-full" wire:model="payable_id">
                    <option value="">{{ trans('currency.select_curr_ap') }}</option>
                    @foreach (getAccountByType(9) as $accAP)
                        <option value="{{ $accAP->id }}">{{ $accAP->account_no }} - {{ $accAP->account_name }}</option>
                    @endforeach
                </select>
                @error('payable_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-span-12 xl:col-span-6 mt-2">
            <div>
                <label for="formProject" class="form-label">{{ trans('currency.receivable_id') }}</label>
                <select data-placeholder="Select Request" class="tom-select w-full" wire:model="receivable_id">
                    <option value="">{{ trans('currency.select_curr_ar') }}</option>
                    @foreach (getAccountByType(2) as $accAR)
                        <option value="{{ $accAR->id }}">{{ $accAR->account_no }} - {{ $accAR->account_name }}</option>
                    @endforeach
                </select>
                @error('receivable_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-span-12 xl:col-span-6 mt-2">
            <div>
                <label for="formProject" class="form-label">{{ trans('currency.dp_purchase_id') }}</label>
                <select data-placeholder="Select Request" class="tom-select w-full" wire:model="dp_purchase_id">
                    <option value="">{{ trans('currency.select_curr_purchase') }}</option>
                    @foreach (getAccountByType(2) as $accAP)
                        <option value="{{ $accAP->id }}">{{ $accAP->account_no }} - {{ $accAP->account_name }}</option>
                    @endforeach
                </select>
                @error('dp_purchase_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-span-12 xl:col-span-6 mt-2">
            <div>
                <label for="formProject" class="form-label">{{ trans('currency.dp_sales_id') }}</label>
                <select data-placeholder="Select Request" class="tom-select w-full" wire:model="dp_sales_id">
                    <option value="">{{ trans('currency.select_curr_sale') }}</option>
                    @foreach (getAccountByType(9) as $accAR)
                        <option value="{{ $accAR->id }}">{{ $accAR->account_no }} - {{ $accAR->account_name }}</option>
                    @endforeach
                </select>
                @error('dp_sales_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">
        <button type="button" wire:click="closeDefault" class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">{{ trans('global.cancel-button') }}</button>
        <button type="button" wire:click.prevent="saveDefaultCurrency" class="btn btn-primary w-20">{{ trans('global.save-button') }}</button>
    </x-slot>
</x-jet-dialog-modal>