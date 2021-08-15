<x-jet-dialog-modal wire:model="create">
    <x-slot name="title">
        {{ ( $this->service_id) ? trans('service.edit-title') : trans('service.add-title') }}
    </x-slot>
    <x-slot name="content">
        <div class="col-span-12 xl:col-span-6">
            <div>
                <label for="formCategory" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('item.category_id') }}</label>
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
                <label for="formCode" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('global.code') }}</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formCode" placeholder="Enter Code" wire:model="code">
                @error('code') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-span-12 xl:col-span-3">
            <div class="flex flex-col sm:flex-row text-right">
                <div class="form-check mr-2">
                    <input id="checkProject" class="form-check-input" type="checkbox" wire:model.lazy="selectCategory">
                    <label class="form-check-label" for="checkProject">{{ $selectCategory == true ? "Project" : "Service/General" }}</label>
                </div>
            </div>
        </div>
        <div class="col-span-12 xl:col-span-12">
            <div>
                <label for="formName" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('global.name') }}</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="formName" placeholder="Enter Name" wire:model="name">
                @error('name') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-span-12 xl:col-span-6">
            <div>
                <label for="formCategory" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('service.advance_id') }}</label>
                <select class="tom-select w-full" wire:model="advance_account_id" id="formCategory" placeholder="{{ trans('service.select_advance') }}" >
                    <option value="">{{ trans('service.select_advance') }}</option>
                    @foreach ($advances as $adv)
                        <option value="{{ $adv->id }}">{{ $adv->account_name }}</option>
                    @endforeach
                </select>
                @error('advance_account_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-span-12 xl:col-span-6">
            <div>
                <label for="formCategory" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('service.wip_id') }}</label>
                <select class="tom-select w-full" wire:model="wip_id" id="formCategory" placeholder="{{ trans('service.wip_id') }}" >
                    <option value="">{{ trans('service.select_wip') }}</option>
                    @foreach ($wips as $wip)
                        <option value="{{ $wip->id }}">{{ $wip->account_name }}</option>
                    @endforeach
                </select>
                @error('wip_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
       {{--  @if($selectCategory == true) --}}
        <div class="col-span-12 xl:col-span-6">
            <div>
                <label for="formCategory" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('service.cogs_id') }}</label>
                <select class="tom-select w-full" wire:model="cogs_id" id="formCategory" placeholder="{{ trans('service.cogs_id') }}" >
                    <option value="">{{ trans('service.select_cogs') }}</option>
                    @foreach ($cogs as $cog)
                        <option value="{{ $cog->id }}">{{ $cog->account_name }}</option>
                    @endforeach
                </select>
                @error('cogs_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
       {{--  @endif --}}
        <div class="col-span-12 xl:col-span-6">
            <div>
                <label for="formCategory" class="block text-gray-700 text-sm font-bold mb-2">{{ trans('service.expense_id') }}</label>
                <select class="tom-select w-full" wire:model="expense_id" id="formCategory" placeholder="{{ trans('service.expense_id') }}" >
                    <option value="">{{ trans('service.select_expense') }}</option>
                    @foreach ($expenses as $exp)
                        <option value="{{ $exp->id }}">{{ $exp->account_name }}</option>
                    @endforeach
                </select>
                @error('expense_id') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
            </div>
        </div>
    </x-slot>
    <x-slot name="footer">
        <button type="button" wire:click="closeModal" class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">{{ trans('global.cancel-button') }}</button>
        <button type="button" wire:click.prevent="save" class="btn btn-primary w-20">{{ trans('global.save-button') }}</button>
    </x-slot>
</x-jet-dialog-modal>
