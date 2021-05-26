<!-- BEGIN: Top Bar -->
<div class="top-bar -mx-4 px-4 md:mx-0 md:px-0">
    <!-- BEGIN: Breadcrumb -->
    <div class="-intro-x breadcrumb mr-auto hidden sm:flex">
        <a href="">Application</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> 
        <a href="" class="breadcrumb--active">Dashboard</a>
    </div>
    <!-- END: Breadcrumb -->
    <!-- BEGIN: Search -->
    <div class="intro-x relative mr-3 sm:mr-6">
        <div class="search hidden sm:block">
            <input type="text" class="search__input form-control border-transparent placeholder-theme-13" placeholder="Search...">
            <i data-feather="search" class="search__icon dark:text-gray-300"></i> 
        </div>
        <a class="notification sm:hidden" href=""> <i data-feather="search" class="notification__icon dark:text-gray-300"></i> </a>
        <div class="search-result">
            <div class="search-result__content">
                <div class="search-result__content__title">Pages</div>
                <div class="mb-5">
                    <a href="" class="flex items-center">
                        <div class="w-8 h-8 bg-theme-17 text-theme-20 flex items-center justify-center rounded-full"> <i class="w-4 h-4" data-feather="inbox"></i> </div>
                        <div class="ml-3">Mail Settings</div>
                    </a>
                    <a href="" class="flex items-center mt-2">
                        <div class="w-8 h-8 bg-theme-18 text-theme-21 flex items-center justify-center rounded-full"> <i class="w-4 h-4" data-feather="users"></i> </div>
                        <div class="ml-3">Users & Permissions</div>
                    </a>
                    <a href="" class="flex items-center mt-2">
                        <div class="w-8 h-8 bg-theme-19 text-theme-22 flex items-center justify-center rounded-full"> <i class="w-4 h-4" data-feather="credit-card"></i> </div>
                        <div class="ml-3">Transactions Report</div>
                    </a>
                </div>
                <div class="search-result__content__title">Users</div>
                <div class="mb-5">
                    <a href="" class="flex items-center mt-2">
                        <div class="w-8 h-8 image-fit">
                            <img alt="Tinker Tailwind HTML Admin Template" class="rounded-full" src="{{ asset('images/profile-14.jpg') }}">
                        </div>
                        <div class="ml-3">Angelina Jolie</div>
                        <div class="ml-auto w-48 truncate text-gray-600 text-xs text-right">angelinajolie@left4code.com</div>
                    </a>
                    <a href="" class="flex items-center mt-2">
                        <div class="w-8 h-8 image-fit">
                            <img alt="Tinker Tailwind HTML Admin Template" class="rounded-full" src="{{ asset('images/profile-3.jpg') }}">
                        </div>
                        <div class="ml-3">Leonardo DiCaprio</div>
                        <div class="ml-auto w-48 truncate text-gray-600 text-xs text-right">leonardodicaprio@left4code.com</div>
                    </a>
                    <a href="" class="flex items-center mt-2">
                        <div class="w-8 h-8 image-fit">
                            <img alt="Tinker Tailwind HTML Admin Template" class="rounded-full" src="{{ asset('images/profile-2.jpg') }}">
                        </div>
                        <div class="ml-3">Robert De Niro</div>
                        <div class="ml-auto w-48 truncate text-gray-600 text-xs text-right">robertdeniro@left4code.com</div>
                    </a>
                    <a href="" class="flex items-center mt-2">
                        <div class="w-8 h-8 image-fit">
                            <img alt="Tinker Tailwind HTML Admin Template" class="rounded-full" src="{{ asset('images/profile-15.jpg') }}">
                        </div>
                        <div class="ml-3">Al Pacino</div>
                        <div class="ml-auto w-48 truncate text-gray-600 text-xs text-right">alpacino@left4code.com</div>
                    </a>
                </div>
                <div class="search-result__content__title">Products</div>
                <a href="" class="flex items-center mt-2">
                    <div class="w-8 h-8 image-fit">
                        <img alt="Tinker Tailwind HTML Admin Template" class="rounded-full" src="{{ asset('images/preview-11.jpg') }}">
                    </div>
                    <div class="ml-3">Nike Tanjun</div>
                    <div class="ml-auto w-48 truncate text-gray-600 text-xs text-right">Sport &amp; Outdoor</div>
                </a>
                <a href="" class="flex items-center mt-2">
                    <div class="w-8 h-8 image-fit">
                        <img alt="Tinker Tailwind HTML Admin Template" class="rounded-full" src="{{ asset('images/preview-7.jpg') }}">
                    </div>
                    <div class="ml-3">Apple MacBook Pro 13</div>
                    <div class="ml-auto w-48 truncate text-gray-600 text-xs text-right">PC &amp; Laptop</div>
                </a>
                <a href="" class="flex items-center mt-2">
                    <div class="w-8 h-8 image-fit">
                        <img alt="Tinker Tailwind HTML Admin Template" class="rounded-full" src="{{ asset('images/preview-9.jpg') }}">
                    </div>
                    <div class="ml-3">Oppo Find X2 Pro</div>
                    <div class="ml-auto w-48 truncate text-gray-600 text-xs text-right">Smartphone &amp; Tablet</div>
                </a>
                <a href="" class="flex items-center mt-2">
                    <div class="w-8 h-8 image-fit">
                        <img alt="Tinker Tailwind HTML Admin Template" class="rounded-full" src="{{ asset('images/preview-8.jpg') }}">
                    </div>
                    <div class="ml-3">Sony Master Series A9G</div>
                    <div class="ml-auto w-48 truncate text-gray-600 text-xs text-right">Electronic</div>
                </a>
            </div>
        </div>
    </div>
    <!-- END: Search -->
    <!-- BEGIN: Notifications -->
    <div class="intro-x dropdown mr-auto sm:mr-6">
        <div class="dropdown-toggle notification notification--bullet cursor-pointer" role="button" aria-expanded="false"> <i data-feather="bell" class="notification__icon dark:text-gray-300"></i> </div>
        <div class="notification-content pt-2 dropdown-menu">
            <div class="notification-content__box dropdown-menu__content box dark:bg-dark-6">
                <div class="notification-content__title">Notifications</div>
                <div class="cursor-pointer relative flex items-center ">
                    <div class="w-12 h-12 flex-none image-fit mr-1">
                        <img alt="Tinker Tailwind HTML Admin Template" class="rounded-full" src="{{ asset('images/profile-14.jpg') }}">
                        <div class="w-3 h-3 bg-theme-20 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                    </div>
                    <div class="ml-2 overflow-hidden">
                        <div class="flex items-center">
                            <a href="javascript:;" class="font-medium truncate mr-5">Angelina Jolie</a> 
                            <div class="text-xs text-gray-500 ml-auto whitespace-nowrap">01:10 PM</div>
                        </div>
                        <div class="w-full truncate text-gray-600 mt-0.5">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem </div>
                    </div>
                </div>
                <div class="cursor-pointer relative flex items-center mt-5">
                    <div class="w-12 h-12 flex-none image-fit mr-1">
                        <img alt="Tinker Tailwind HTML Admin Template" class="rounded-full" src="{{ asset('images/profile-3.jpg') }}">
                        <div class="w-3 h-3 bg-theme-20 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                    </div>
                    <div class="ml-2 overflow-hidden">
                        <div class="flex items-center">
                            <a href="javascript:;" class="font-medium truncate mr-5">Leonardo DiCaprio</a> 
                            <div class="text-xs text-gray-500 ml-auto whitespace-nowrap">05:09 AM</div>
                        </div>
                        <div class="w-full truncate text-gray-600 mt-0.5">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem </div>
                    </div>
                </div>
                <div class="cursor-pointer relative flex items-center mt-5">
                    <div class="w-12 h-12 flex-none image-fit mr-1">
                        <img alt="Tinker Tailwind HTML Admin Template" class="rounded-full" src="{{ asset('images/profile-2.jpg') }}">
                        <div class="w-3 h-3 bg-theme-20 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                    </div>
                    <div class="ml-2 overflow-hidden">
                        <div class="flex items-center">
                            <a href="javascript:;" class="font-medium truncate mr-5">Robert De Niro</a> 
                            <div class="text-xs text-gray-500 ml-auto whitespace-nowrap">03:20 PM</div>
                        </div>
                        <div class="w-full truncate text-gray-600 mt-0.5">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 20</div>
                    </div>
                </div>
                <div class="cursor-pointer relative flex items-center mt-5">
                    <div class="w-12 h-12 flex-none image-fit mr-1">
                        <img alt="Tinker Tailwind HTML Admin Template" class="rounded-full" src="{{ asset('images/profile-15.jpg') }}">
                        <div class="w-3 h-3 bg-theme-20 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                    </div>
                    <div class="ml-2 overflow-hidden">
                        <div class="flex items-center">
                            <a href="javascript:;" class="font-medium truncate mr-5">Al Pacino</a> 
                            <div class="text-xs text-gray-500 ml-auto whitespace-nowrap">05:09 AM</div>
                        </div>
                        <div class="w-full truncate text-gray-600 mt-0.5">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 20</div>
                    </div>
                </div>
                <div class="cursor-pointer relative flex items-center mt-5">
                    <div class="w-12 h-12 flex-none image-fit mr-1">
                        <img alt="Tinker Tailwind HTML Admin Template" class="rounded-full" src="{{ asset('images/profile-2.jpg') }}">
                        <div class="w-3 h-3 bg-theme-20 absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                    </div>
                    <div class="ml-2 overflow-hidden">
                        <div class="flex items-center">
                            <a href="javascript:;" class="font-medium truncate mr-5">Sean Connery</a> 
                            <div class="text-xs text-gray-500 ml-auto whitespace-nowrap">06:05 AM</div>
                        </div>
                        <div class="w-full truncate text-gray-600 mt-0.5">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 20</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Notifications -->
    <!-- BEGIN: Account Menu -->
    <div class="intro-x dropdown w-8 h-8">
        <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in" role="button" aria-expanded="false">
            <img alt="Tinker Tailwind HTML Admin Template" src="{{ asset('images/profile-10.jpg') }}">
        </div>
        <div class="dropdown-menu w-56">
            <div class="dropdown-menu__content box dark:bg-dark-6">
                <div class="p-4 border-b border-black border-opacity-5 dark:border-dark-3">
                    <div class="font-medium">Angelina Jolie</div>
                    <div class="text-xs text-gray-600 mt-0.5 dark:text-gray-600">Frontend Engineer</div>
                </div>
                <div class="p-2">
                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-gray-200 dark:hover:bg-dark-3 rounded-md"> <i data-feather="user" class="w-4 h-4 mr-2"></i> Profile </a>
                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-gray-200 dark:hover:bg-dark-3 rounded-md"> <i data-feather="edit" class="w-4 h-4 mr-2"></i> Add Account </a>
                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-gray-200 dark:hover:bg-dark-3 rounded-md"> <i data-feather="lock" class="w-4 h-4 mr-2"></i> Reset Password </a>
                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-gray-200 dark:hover:bg-dark-3 rounded-md"> <i data-feather="help-circle" class="w-4 h-4 mr-2"></i> Help </a>
                </div>
                <div class="p-2 border-t border-black border-opacity-5 dark:border-dark-3">
                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-gray-200 dark:hover:bg-dark-3 rounded-md"> <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i> Logout </a>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Account Menu -->
</div>
<!-- END: Top Bar -->