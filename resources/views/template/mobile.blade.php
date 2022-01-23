<!-- MOBILE MENU -->
<div class="mobile-menu md:hidden">
    <div class="mobile-menu-bar">
        <a href="" class="flex mr-auto">
            <img alt="Vima" class="w-6" src="{{ asset('images/favico.ico') }}">
        </a>
        <a href="javascript:;" id="mobile-menu-toggler">
            <i data-feather="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i>
        </a>
    </div>
    <ul class="border-t border-theme-29 py-5 hidden">
        <li>
            <a href="javascript:;" class="menu menu--active">
                <div class="menu__icon">
                    <i data-feather="home"></i>
                </div>
                <div class="menu__title">
                    Dashboard
                </div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="menu">
                <div class="menu__icon">
                    <i data-feather="box"></i>
                </div>
                <div class="menu__title">
                    Master
                    <i data-feather="chevron-down" class="menu__sub-icon "></i>
                </div>
            </a>
            <ul class="">
                <li>
                    <a href="{{ route('currencies.index') }}" class="menu">
                        <div class="menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="menu__title">
                            Currency
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('accounts.index') }}" class="menu">
                        <div class="menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="menu__title">
                            Account
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('categories.index') }}" class="menu">
                        <div class="menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="menu__title">
                            Category
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('services.index') }}" class="menu">
                        <div class="menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="menu__title">
                            Charge Code
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('ledgers.index') }}" class="menu">
                        <div class="menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="menu__title">
                            Ledger
                        </div>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="menu">
                <div class="menu__icon">
                    <i data-feather="edit"></i>
                </div>
                <div class="menu__title">
                    Accounting
                    <i data-feather="chevron-down" class="menu__sub-icon "></i>
                </div>
            </a>
            <ul class="">
                <li>
                    <a href="{{ route('accounting.jurnals') }}" class="menu">
                        <div class="menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="menu__title">
                            Jurnal
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('accounting.cash-banks') }}" class="menu">
                        <div class="menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="menu__title">
                            Cash Bank
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('accounting.history-jurnals') }}" class="menu">
                        <div class="menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="menu__title">
                            History
                        </div>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="menu">
                <div class="menu__icon">
                    <i data-feather="users"></i>
                </div>
                <div class="menu__title">
                    Req. Advance
                    <i data-feather="chevron-down" class="menu__sub-icon "></i>
                </div>
            </a>
            <ul class="">
                <li>
                    <a href="{{ route('advance-management.advance-requests') }}" class="menu">
                        <div class="menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="menu__title">
                            Adv Request
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('advance-management.advance-approvals') }}" class="menu">
                        <div class="menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="menu__title">
                            Adv. Approve
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('advance-management.advance-releases') }}" class="menu">
                        <div class="menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="menu__title">
                            Adv. Release
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('advance-management.advance-reports') }}" class="menu">
                        <div class="menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="menu__title">
                            Adv. Report
                        </div>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="menu">
                <div class="menu__icon">
                    <i data-feather="settings"></i>
                </div>
                <div class="menu__title">
                    Settings
                    <i data-feather="chevron-down" class="menu__sub-icon "></i>
                </div>
            </a>
            <ul class="">
                <li>
                    <a href="javascript:;" class="menu">
                        <div class="menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="menu__title">
                            Company
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" class="menu">
                        <div class="menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="menu__title">
                            Role
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" class="menu">
                        <div class="menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="menu__title">
                            Permission
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" class="menu">
                        <div class="menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="menu__title">
                            User
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" class="menu">
                        <div class="menu__icon">
                            <i data-feather="activity"></i>
                        </div>
                        <div class="menu__title">
                            Approval
                        </div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>
<!-- END MOBILE MENU -->