@extends('template.main')

@section('content')
    <div class="intro-y flex items-center mt-2">
        <h2 class="text-lg font-medium mr-auto">{{ empty($result) ? $title : $title }}</h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-2">
        <div class="intro-y col-span-6 lg:col-span-6">
            <!-- BEGIN: Form Layout -->
            @if(!empty($result))
            <form action="{{ route('departments.update',['department'=> $result['id']]) }}" method="post">
            @else
            <form action="{{ route('departments.store') }}" method="post">
            @endif
                @csrf
                @if(!empty($result))
                @method('PUT')
                @endif
                <div class="intro-y box p-5">
                    <div>
                        <label for="name" class="form-label">Department Name</label>
                        <input 
                            id="name" 
                            name="name" 
                            type="text" 
                            @if(!empty($result))
                                value="{{ $result['name'] }}"
                            @endif
                            class="form-control form-control-rounded" 
                            placeholder="Category Name">
                    </div>
                    <div class="text-right mt-5">
                        <a href="{{ route('departments.index') }}" class="btn closeModal btn-outline-secondary w-20 mr-1">Cancel</a>
                        <button type="submit" class="btn btn-primary w-auto">Save</button>
                    </div>
                </div>
            </form>
            <!-- END: Form Layout -->
        </div>
    </div>
@stop