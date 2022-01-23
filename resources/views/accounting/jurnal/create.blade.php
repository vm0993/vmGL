@extends('template.main')

@section('content')
    <div class="col-span-12">
        <div class="box">
            <form method="post">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        {{ trans('jurnal.transaction') }}
                    </h2>
                    <div class="flex flex-col sm:flex-row text-right">
                        <div>
                            <input id="formCode" type="text" step="any" readonly name="balance" value="{{ $debet>$credit ? number_format($debet-$credit) : number_format($credit-$debet) }}" class="form-control text-right" placeholder="{{ __('global.balance') }}">
                        </div>
                    </div>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-12 gap-x-5">
                        <div class="col-span-12 xl:col-span-3">
                            <div>
                                <label for="formDate" class="form-label">{{ trans('jurnal.transaction_date') }}</label>
                                <x-jet-input type="date" wire:change="autoNumber()" class="form-control" id="formDate" 
                                placeholder="Enter Date" wire:model="transaction_date"></x-jet-input>
                                @error('transaction_date') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-span-12 xl:col-span-3">
                            <div>
                                <label for="formCode" class="form-label">{{ trans('jurnal.code') }}</label>
                                <input id="formCode" type="text" name="code" wire:model="code" class="form-control" placeholder="Voucher No">
                                @error('code') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-span-12 xl:col-span-12">
                            <div>
                                <label for="formDescription" class="form-label">{{ trans('jurnal.description') }}</label>
                                <input type="text" class="form-control" id="formDescription" 
                                placeholder="Enter Description" wire:model="description">
                                @error('description') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-x-5 mt-2">
                        <div class="col-span-12 lg:col-span-12">
                            <div>
                                <label for="formCode" class="form-label">{{ trans('jurnal.detail-transaction') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-x-5 mt-2 preview">
                        @foreach ($allJurnals as $index => $account)
                        <div class="col-span-12 lg:col-span-6 sm:col-span-3 mt-2">
                            <div class="input-group">
                                <div class="input-group-text">
                                    {{ __('jurnal.account') }}
                                </div>
                                <select name="allJurnals[{{$index}}][account_id]" wire:model="allJurnals.{{$index}}.account_id" class="tom-select w-full" data-placeholder="Select your Account">
                                    <option value="">{{ trans('jurnal.select_account') }}</option>
                                    @foreach ($allAccounts as $acc)
                                        <option value="{{ $acc->id }}"> {{ $acc->account_no }} - {{ $acc->account_name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-span-12 lg:col-span-3 sm:col-span-3 mt-2">
                            <div class="input-group">
                                <div class="input-group-text">
                                    {{ __('jurnal.debet') }}
                                </div>
                                <input type="number" step="any" name="allJurnals[{{$index}}][debet]" wire:change="getTotalDebet" class="form-control text-right" wire:model="allJurnals.{{$index}}.debet" />
                            </div>
                        </div>
                        <div class="col-span-12 lg:col-span-3 sm:col-span-3 mt-2">
                            <div class="input-group">
                                <div class="input-group-text">
                                    {{ __('jurnal.credit') }}
                                </div>
                                <input type="number" step="any" name="allJurnals[{{$index}}][credit]" wire:change="getTotalCredit" class="form-control text-right" wire:model="allJurnals.{{$index}}.credit" />
                            </div>
                        </div>
                        <div class="col-span-12 lg:col-span-12 sm:col-span-12 mt-2">
                            <div class="input-group">
                                <div class="input-group-text">
                                    {{ __('jurnal.memo') }}
                                </div>
                                <input type="text" name="allJurnals[{{$index}}][memo]" class="form-control" placeholder="{{ trans('jurnal.memo') }}" wire:model="allJurnals.{{$index}}.memo" />
                                <div class="input-group-text" wire:click.prevent="removeJurnal({{$index}})" >
                                    <x-feathericon-trash-2 class="w-4 h-4"></x-feathericon-trash-2>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="grid grid-cols-12 gap-x-5 intro-y p-0 col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                        <div class="col-span-12 lg:col-span-8 mt-2">
                            <button wire:click.prevent="addAccount" class="btn btn-primary shadow-md mr-2">{{ trans('jurnal.add-account') }}</button>
                        </div>
                        <div class="col-span-12 lg:col-span-2 mt-2">
                            <div>
                                <input type="number" readonly name="totDebet" class="form-control text-right" wire:model="debet" />
                            </div>
                        </div>
                        <div class="col-span-12 lg:col-span-2 mt-2">
                            <div>
                                <input type="number" readonly name="totCredit" class="form-control text-right" wire:model="credit" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex px-5 py-5 sm:py-3 border-t border-gray-200 dark:border-dark-5">
                    <div class="text-right">
                        <button type="button" wire:click="backIndex" class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">{{ trans('global.cancel-button') }}</button>
                        <button type="submit" wire:loading.attr="disabled" class="btn btn-primary w-24">{{ trans('global.save-button') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop