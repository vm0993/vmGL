<div class="col-span-12">
    <div class="box">
        <form wire:submit.prevent="save">
            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                <h2 class="font-medium text-base mr-auto">
                    {{ trans('cash-bank.add-title') }}
                </h2>
                <div class="flex flex-col sm:flex-row text-right">
                    <div class="form-check mr-2">
                        <input id="checkTipe" class="form-check-input" type="checkbox" wire:model.lazy="selectCashBankType">
                        <label class="form-check-label" for="checkTipe">{{ $selectCashBankType == true ? "Kas/Bank Keluar" : "Kas Bank Masuk" }}</label>
                    </div>
                </div>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-12 gap-x-5">
                    <div class="col-span-12 xl:col-span-3">
                        <div>
                            <label for="formDate" class="form-label">{{ trans('cash-bank.transaction_date') }}</label>
                            <input type="date" wire:change="autoNumber" class="form-control" id="formDate" wire:model="transaction_date"></input>
                            @error('transaction_date') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-3">
                        <div>
                            <label for="formCode" class="form-label">{{ trans('cash-bank.code') }}</label>
                            <input id="formCode" type="text" name="code" wire:model="code" class="form-control" placeholder="Voucher No"></input>
                            @error('code') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-6">
                        <div>
                            <label for="formSourceAccount" class="form-label">{{ $selectCashBankType == true ? "Debet Akun" : "Kredit Akun" }}</label>
                            <select data-placeholder="Select Project" class="tom-select w-full" wire:model="source_account_id" id="formSourceAccount">
                                <option value="">{{ trans('cash-bank.select_source') }}</option>
                                @foreach ($sourceAccounts as $akun)
                                    <option value="{{ $akun->id }}">{{ $akun->account_no }} - {{ $akun->account_name }}</option>
                                @endforeach
                            </select>
                            @error('source_account_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-12">
                        <div>
                            <label for="formDescription" class="form-label">{{ trans('cash-bank.description') }}</label>
                            <input type="text" class="form-control" id="formDescription" placeholder="Enter Description" wire:model="description"></input>
                            @error('description') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-x-5 mt-2">
                    <div class="col-span-12 lg:col-span-8">
                        <div>
                            <label for="formCode" class="form-label">{{ trans('cash-bank.account_name') }}</label>
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-2">
                        <div>
                            <label for="formCode" class="form-label text-right">{{ trans('cash-bank.amount') }}</label>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-x-5 mt-2 preview">
                    @foreach ($allJurnals as $index => $account)
                    <div class="col-span-12 lg:col-span-8 mt-2">
                        <div>
                            <select name="allJurnals[{{$index}}][account_id]" wire:model="allJurnals.{{$index}}.account_id" class="tom-select w-full" data-placeholder="Select your Account">
                                <option value="">{{ trans('jurnal.select_account') }}</option>
                                @foreach ($allAccounts as $acc)
                                    <option value="{{ $acc->id }}"> {{ $acc->account_no }} - {{ $acc->account_name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-2 mt-2">
                        <div>
                            <input type="number" name="allJurnals[{{$index}}][amount]" class="form-control text-right" wire:model="allJurnals.{{$index}}.amount" />
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-8 mt-2">
                        <input type="text" name="allJurnals[{{$index}}][memo]" class="form-control" placeholder="{{ trans('jurnal.memo') }}" wire:model="allJurnals.{{$index}}.memo" />
                    </div>
                    <div class="col-span-12 lg:col-span-2 mt-2">
                        <button wire:click.prevent="removeJurnal({{$index}})" class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300">
                            <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-feather="delete"></i> Delete </span>
                        </button>
                    </div>
                    @endforeach
                </div>
                <div class="grid grid-cols-12 gap-x-5 intro-y p-0 col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                    <div class="col-span-12 lg:col-span-8 mt-2">
                        <button wire:click.prevent="addAccount" class="btn btn-primary shadow-md mr-2">{{ trans('jurnal.add-account') }}</button>
                    </div>
                    <div class="col-span-12 lg:col-span-2 mt-2">
                        <div>
                            <input type="number" readonly name="totDebet" class="form-control text-right" wire:model="amount" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex px-5 py-5 sm:py-3 border-t border-gray-200 dark:border-dark-5">
                <div class="text-right">
                    <button type="button" wire:click="backCashBank" class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">{{ trans('global.cancel-button') }}</button>
                    <button type="submit" class="btn btn-primary w-24">{{ trans('global.save-button') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>