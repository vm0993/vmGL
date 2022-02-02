@extends('template.main')

@section('content')
<div class="grid grid-cols-12 gap-x-5 mt-2 preview">
    <div class="col-span-12 lg:col-span-6 sm:col-span-3 mt-2">
        <div class="input-group">
            <div class="input-group-text">
                {{ __('jurnal.account') }}
            </div>
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
</div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Form Layout -->
            <div class="intro-y box p-5">
                <div>
                    <label for="crud-form-1" class="form-label">Product Name</label>
                    <input id="crud-form-1" type="text" class="form-control w-full" placeholder="Input text">
                </div>
                <div class="mt-3">
                    <label for="crud-form-2" class="form-label">Category</label>
                    <select data-placeholder="Select your favorite actors" class="tom-select w-full" id="crud-form-2" multiple>
                        <option value="1" selected>Sport & Outdoor</option>
                        <option value="2">PC & Laptop</option>
                        <option value="3" selected>Smartphone & Tablet</option>
                        <option value="4">Photography</option>
                    </select>
                </div>
                <div class="mt-3">
                    <label for="crud-form-3" class="form-label">Quantity</label>
                    <div class="input-group">
                        <input id="crud-form-3" type="text" class="form-control" placeholder="Quantity" aria-describedby="input-group-1">
                        <div id="input-group-1" class="input-group-text">pcs</div>
                    </div>
                </div>
                <div class="mt-3">
                    <label for="crud-form-4" class="form-label">Weight</label>
                    <div class="input-group">
                        <input id="crud-form-4" type="text" class="form-control" placeholder="Weight" aria-describedby="input-group-2">
                        <div id="input-group-2" class="input-group-text">grams</div>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label">Price</label>
                    <div class="sm:grid grid-cols-3 gap-2">
                        <div class="input-group">
                            <div id="input-group-3" class="input-group-text">Unit</div>
                            <input type="text" class="form-control" placeholder="Unit" aria-describedby="input-group-3">
                        </div>
                        <div class="input-group mt-2 sm:mt-0">
                            <div id="input-group-4" class="input-group-text">Wholesale</div>
                            <input type="text" class="form-control" placeholder="Wholesale" aria-describedby="input-group-4">
                        </div>
                        <div class="input-group mt-2 sm:mt-0">
                            <div id="input-group-5" class="input-group-text">Bulk</div>
                            <input type="text" class="form-control" placeholder="Bulk" aria-describedby="input-group-5">
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <label>Active Status</label>
                    <div class="form-switch mt-2">
                        <input type="checkbox" class="form-check-input">
                    </div>
                </div>
                <div class="mt-3">
                    <label>Description</label>
                    <div class="mt-2">
                        <div class="editor">
                            <p>Content of the editor.</p>
                        </div>
                    </div>
                </div>
                <div class="text-right mt-5">
                    <button type="button" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                    <button type="button" class="btn btn-primary w-24">Save</button>
                </div>
            </div>
            <!-- END: Form Layout -->
        </div>
    </div>
@stop