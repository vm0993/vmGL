@extends('template.guest')

@section('content')
<div class="error-page flex flex-col lg:flex-row items-center justify-center h-screen text-center lg:text-left">
    <div class="-intro-x lg:mr-20">
        <img alt="VIMA" class="h-48 lg:h-auto" src="{{ asset('dist/images/woman-illustration.svg') }}">
    </div>
    <div class="text-white mt-10 lg:mt-0">
        <div class="intro-x text-8xl font-medium">Success</div>
        <div class="intro-x text-xl lg:text-3xl font-medium mt-5">Your Registration successfull.</div>
        <div class="intro-x text-lg mt-3">Please Activated your account and enjoy to work!.</div>
        <div class="grid grid-cols-12 gap-2 mt-2">
            <div class="intro-x col-span-12 lg:col-span-6 md:col-span-6">
                <!-- BEGIN: Form Layout -->
                <div class="intro-y box p-5">
                    {{ $result['register']->name }}, successfull to created!<br>
                    {{ $result['register']->subdomain }}.{{ config('tenant.main_domain') }} to access your app.<br>
                    App can be access until {{ \Carbon\Carbon::parse($result['register']->experied_date)->format('d M Y') }}, you can continue with subscribe.
                </div>
            </div>
        </div>
        <a href="{{ url('/') }}" class="intro-x btn py-3 px-4 text-white border-white dark:border-darkmode-400 dark:text-slate-200 mt-10">Back to Home</a>
    </div>
</div>
@endsection