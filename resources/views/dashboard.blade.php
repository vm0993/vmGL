@extends('template.main')

@section('content')
    dd(request()->getHost());
    <div class="col-span-12 xxl:col-span-9 xl:col-span-8 md:col-span-9">
        <center>
            <button id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()" class="btn btn-danger btn-xs btn-flat">Allow for Notification</button>
        </center>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">General Report</h2>
                    <a href="" class="ml-auto flex items-center text-theme-1 dark:text-theme-10">
                    <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data
                    </a>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <i data-feather="shopping-cart" class="report-box__icon text-theme-10"></i>
                                <div class="ml-auto">
                                <div class="report-box__indicator bg-theme-9 tooltip cursor-pointer" title="33% Higher than last month">
                                    33% <i data-feather="chevron-up" class="w-4 h-4 ml-0.5"></i>
                                </div>
                                </div>
                            </div>
                            <div class="text-3xl font-medium leading-8 mt-6">4.710</div>
                            <div class="text-base text-gray-600 mt-1">Item Sales</div>
                        </div>
                    </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <i data-feather="credit-card" class="report-box__icon text-theme-11"></i>
                                <div class="ml-auto">
                                <div class="report-box__indicator bg-theme-6 tooltip cursor-pointer" title="2% Lower than last month">
                                    2% <i data-feather="chevron-down" class="w-4 h-4 ml-0.5"></i>
                                </div>
                                </div>
                            </div>
                            <div class="text-3xl font-medium leading-8 mt-6">3.721</div>
                            <div class="text-base text-gray-600 mt-1">New Orders</div>
                        </div>
                    </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <i data-feather="monitor" class="report-box__icon text-theme-12"></i>
                                <div class="ml-auto">
                                <div class="report-box__indicator bg-theme-9 tooltip cursor-pointer" title="12% Higher than last month">
                                    12% <i data-feather="chevron-up" class="w-4 h-4 ml-0.5"></i>
                                </div>
                                </div>
                            </div>
                            <div class="text-3xl font-medium leading-8 mt-6">2.149</div>
                            <div class="text-base text-gray-600 mt-1">Total Products</div>
                        </div>
                    </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <i data-feather="user" class="report-box__icon text-theme-9"></i>
                                <div class="ml-auto">
                                <div class="report-box__indicator bg-theme-9 tooltip cursor-pointer" title="22% Higher than last month">
                                    22% <i data-feather="chevron-up" class="w-4 h-4 ml-0.5"></i>
                                </div>
                                </div>
                            </div>
                            <div class="text-3xl font-medium leading-8 mt-6">152.040</div>
                            <div class="text-base text-gray-600 mt-1">Unique Visitor</div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <!-- END: General Report -->
        </div>
    </div>
    <div class="col-span-12 xxl:col-span-3 xl:col-span-4 md:col-span-3">
        <div class="xxl:border-l border-theme-5 -mb-10 pb-10">
            <div class="xxl:pl-6 xl:pl-6 md:pl-6 grid grid-cols-12 gap-6">
                <!-- BEGIN: Transactions -->
                <div class="col-span-12 md:col-span-12 sm:col-span-2 xxl:col-span-12 xl:col-span-12 mt-3 xxl:mt-8">
                    <div class="intro-x flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">Transactions</h2>
                    </div>
                    <div class="mt-5">
                        <div class="intro-x">
                            <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="Rubick Tailwind HTML Admin Template" src="https://rubick-laravel.left4code.com/dist/images/profile-5.jpg">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">Kevin Spacey</div>
                                    <div class="text-gray-600 text-xs mt-0.5">15 June 2020</div>
                                </div>
                                <div class="text-theme-9">+$95</div>
                            </div>
                        </div>
                        <div class="intro-x">
                            <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="Rubick Tailwind HTML Admin Template" src="https://rubick-laravel.left4code.com/dist/images/profile-12.jpg">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">Christian Bale</div>
                                    <div class="text-gray-600 text-xs mt-0.5">16 June 2020</div>
                                </div>
                                <div class="text-theme-6">-$31</div>
                            </div>
                        </div>
                        <div class="intro-x">
                            <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="Rubick Tailwind HTML Admin Template" src="https://rubick-laravel.left4code.com/dist/images/profile-15.jpg">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">Johnny Depp</div>
                                    <div class="text-gray-600 text-xs mt-0.5">29 May 2022</div>
                                </div>
                                <div class="text-theme-9">+$95</div>
                            </div>
                        </div>
                        <div class="intro-x">
                            <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="Rubick Tailwind HTML Admin Template" src="https://rubick-laravel.left4code.com/dist/images/profile-2.jpg">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">Johnny Depp</div>
                                    <div class="text-gray-600 text-xs mt-0.5">29 April 2020</div>
                                </div>
                                <div class="text-theme-6">-$165</div>
                            </div>
                        </div>
                        <div class="intro-x">
                            <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="Rubick Tailwind HTML Admin Template" src="https://rubick-laravel.left4code.com/dist/images/profile-9.jpg">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">Tom Cruise</div>
                                    <div class="text-gray-600 text-xs mt-0.5">29 December 2022</div>
                                </div>
                                <div class="text-theme-6">-$115</div>
                            </div>
                        </div>
                        <a href="" class="intro-x w-full block text-center rounded-md py-3 border border-dotted border-theme-15 dark:border-dark-5 text-theme-16 dark:text-gray-600">View More</a>
                    </div>
                </div>
                <!-- END: Transactions -->
            </div>
        </div>
    </div>
@stop

@section('footer')

    @push('scripts')
    
    @endpush
@stop