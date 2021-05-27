<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">New Account</h2>
</div>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 lg:col-span-6">
        <!-- BEGIN: Form Layout -->
        <div class="intro-y box p-5">
            <div>
                <label for="crud-form-1" class="form-label">Account No</label>
                <input id="crud-form-1" type="text" class="form-control w-full" placeholder="Input text">
            </div>
            <div class="mt-3">
                <label for="crud-form-1" class="form-label">Account Name</label>
                <input id="crud-form-1" type="text" class="form-control w-full" placeholder="Input text">
            </div>
            <div class="mt-3">
                <label for="crud-form-2" class="form-label">Account Type</label>
                <select data-placeholder="Select your Account Type" class="tail-select w-full" id="crud-form-2" multiple>
                    <option value="1" selected>Sport & Outdoor</option>
                    <option value="2">PC & Laptop</option>
                    <option value="3" selected>Smartphone & Tablet</option>
                    <option value="4">Photography</option>
                </select>
            </div>
            <div class="mt-3">
                <label for="crud-form-3" class="form-label">Sub Account</label>
                <div class="input-group">
                    <input id="crud-form-3" type="text" class="form-control" placeholder="Quantity" aria-describedby="input-group-1">
                    <div id="input-group-1" class="input-group-text">pcs</div>
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