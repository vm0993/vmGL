<!-- SIDEBAR MENU -->
<nav class="side-nav">
    <a href="" class="intro-x flex items-center pl-5 pt-4">
        <img alt="Vima" class="w-6" src="{{ asset('images/favico.ico') }}">
        <span class="hidden xl:block text-white text-lg ml-3">
        VI<span class="font-medium">MA</span>
        </span>
    </a>
    <div class="side-nav__devider my-6"></div>
    <ul>
        <li>
            <a href="javascript:;" class="side-menu side-menu--active">
                <div class="side-menu__icon">
                    <i data-feather="home"></i>
                </div>
                <div class="side-menu__title">
                    Dashboard
                    <div class="side-menu__sub-icon transform rotate-180"> </div>
                </div>
            </a>
        </li>
        <li class="side-nav__devider my-6"></li>
        <li>
            <a href="javascript:;" class="side-menu">
                <div class="side-menu__icon">
                    <i data-feather="box"></i>
                </div>
                <div class="side-menu__title">
                    Master
                    <div class="side-menu__sub-icon ">
                    <i data-feather="chevron-down"></i>
                    </div>
                </div>
            </a>
            <ul class="">
                <li>
                    <a href="{{ route('currencies.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Currency
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('accounts.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Account
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('categories.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Category
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('services.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Charge Code
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('ledgers.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Ledger
                        </div>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="side-menu">
                <div class="side-menu__icon">
                    <i data-feather="edit"></i>
                </div>
                <div class="side-menu__title">
                    Accounting
                    <div class="side-menu__sub-icon ">
                    <i data-feather="chevron-down"></i>
                    </div>
                </div>
            </a>
            <ul class="">
                <li>
                    <a href="{{ route('jurnals.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Jurnal
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('cash-banks.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Cash Bank
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('history-jurnals.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            History
                        </div>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="side-menu">
                <div class="side-menu__icon">
                    <i data-feather="users"></i>
                </div>
                <div class="side-menu__title">
                    Req. Advance
                    <div class="side-menu__sub-icon ">
                        <i data-feather="chevron-down"></i>
                    </div>
                </div>
            </a>
            <ul class="">
                <li>
                    <a href="{{ route('advance-requests.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Adv Request
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('advance-approvals.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Adv. Approve
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('advance-releases.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Adv. Release
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('advance-reports.index') }}" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Adv. Report
                        </div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="side-nav__devider my-6"></li>
        <li>
            <a href="javascript:;" class="side-menu">
                <div class="side-menu__icon">
                    <i data-feather="settings"></i>
                </div>
                <div class="side-menu__title">
                    Setting
                    <div class="side-menu__sub-icon ">
                        <i data-feather="chevron-down"></i>
                    </div>
                </div>
            </a>
            <ul class="">
                <li>
                    <a href="" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Company
                        </div>
                    </a>
                </li>
                <li>
                    <a href="" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Role
                        </div>
                    </a>
                </li>
                <li>
                    <a href="" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Permission
                        </div>
                    </a>
                </li>
                <li>
                    <a href="" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            User
                        </div>
                    </a>
                </li>
                <li>
                    <a href="" class="side-menu">
                        <div class="side-menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="side-menu__title">
                            Approval
                        </div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
<!-- END SIDEBAR MENU -->