@extends('template.main')

@section('content')
    <div class="intro-y flex items-center mt-2">
        <h2 class="text-lg font-medium mr-auto">{{ empty($result) ? $title : $title }}</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-2">
        <div class="intro-y col-span-12 lg:col-span-8 md:col-span-8 sm:col-span-8">
            <!-- BEGIN: Form Layout -->
            @if(!empty($result))
            <form action="{{ route('personels.update',['personel'=> $result['id']]) }}" method="post">
            @else
            <form action="{{ route('personels.store') }}" method="post">
            @endif
                @csrf
                @if(!empty($result))
                @method('PUT')
                @endif
                <div class="preview">
                    <div class="intro-y box p-5">
                        <div class="mt-0">
                            <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
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
                                        placeholder="Name"/>
                                    @error('name') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="md:grid grid-cols-1 sm:grid grid-cols-1 gap-2">
                                <div class="input-group">
                                    <div for="address" class="input-group-text"><strong>Address</strong></div>
                                    <input
                                        name="address"
                                        id="address"
                                        rows="5"
                                        @if(!empty($result))
                                        value="{!! $result['address'] !!}"
                                        @endif
                                        class="form-control"
                                        placeholder="Address"/>
                                    @error('address') <span class="text-theme-21 mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="text-right mt-5">
                            <a href="{{ route('personels.index') }}" class="btn btn-outline-secondary w-24 mr-1">Cancel</a>
                            <button type="submit" class="btn btn-primary w-24">Save</button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END: Form Layout -->
        </div>
    </div>
@endsection

