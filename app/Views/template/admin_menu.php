<!-- begin:: Header Mobile -->
<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
    <div class="kt-header-mobile__brand">
        <a class="kt-header-mobile__logo" href="?page=index">
            <img alt="Logo" src="<?= base_url(); ?>/assets/media/logos/logo-5-sm.png" />
        </a>
        <div class="kt-header-mobile__nav">
            <div class="dropdown">
                <button type="button" class="btn btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--md kt-svg-icon--success">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24" />
                            <path d="M15.9956071,6 L9,6 C7.34314575,6 6,7.34314575 6,9 L6,15.9956071 C4.70185442,15.9316381 4,15.1706419 4,13.8181818 L4,6.18181818 C4,4.76751186 4.76751186,4 6.18181818,4 L13.8181818,4 C15.1706419,4 15.9316381,4.70185442 15.9956071,6 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                            <path d="M10.1818182,8 L17.8181818,8 C19.2324881,8 20,8.76751186 20,10.1818182 L20,17.8181818 C20,19.2324881 19.2324881,20 17.8181818,20 L10.1818182,20 C8.76751186,20 8,19.2324881 8,17.8181818 L8,10.1818182 C8,8.76751186 8.76751186,8 10.1818182,8 Z" fill="#000000" />
                        </g>
                    </svg> </button>
                <div class="dropdown-menu dropdown-menu-fit dropdown-menu-md">
                    <ul class="kt-nav kt-nav--bold kt-nav--md-space kt-margin-t-20 kt-margin-b-20">
                        <li class="kt-nav__item">
                            <a class="kt-nav__link active" href="#">
                                <span class="kt-nav__link-icon"><i class="flaticon2-user"></i></span>
                                <span class="kt-nav__link-text">Human Resources</span>
                            </a>
                        </li>
                        <li class="kt-nav__item">
                            <a class="kt-nav__link" href="#">
                                <span class="kt-nav__link-icon"><i class="flaticon-feed"></i></span>
                                <span class="kt-nav__link-text">Customer Relationship</span>
                            </a>
                        </li>
                        <li class="kt-nav__item">
                            <a class="kt-nav__link" href="#">
                                <span class="kt-nav__link-icon"><i class="flaticon2-settings"></i></span>
                                <span class="kt-nav__link-text">Order Processing</span>
                            </a>
                        </li>
                        <li class="kt-nav__item">
                            <a class="kt-nav__link" href="#">
                                <span class="kt-nav__link-icon"><i class="flaticon2-chart2"></i></span>
                                <span class="kt-nav__link-text">Accounting</span>
                            </a>
                        </li>
                        <li class="kt-nav__separator"></li>
                        <li class="kt-nav__item">
                            <a class="kt-nav__link" href="#">
                                <span class="kt-nav__link-icon"><i class="flaticon-security"></i></span>
                                <span class="kt-nav__link-text">Finance</span>
                            </a>
                        </li>
                        <li class="kt-nav__item">
                            <a class="kt-nav__link" href="#">
                                <span class="kt-nav__link-icon"><i class="flaticon2-cup"></i></span>
                                <span class="kt-nav__link-text">Administration</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="kt-header-mobile__toolbar">
        <button class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></button>
        <button class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more-1"></i></button>
    </div>
</div>

<!-- end:: Header Mobile -->
<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper " id="kt_wrapper">

            <!-- begin:: Header -->
            <div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed " data-ktheader-minimize="on">
                <div class="kt-header__top">
                    <div class="kt-container ">

                        <!-- begin:: Brand -->
                        <div class="kt-header__brand   kt-grid__item" id="kt_header_brand">
                            <div class="kt-header__brand-logo">
                                <a href="index.html">
                                    <img alt="Logo" src="<?= base_url(); ?>/assets/media/logos/logo-5.png" />
                                </a>
                            </div>
                        </div>

                        <!-- end:: Brand -->

                        <!-- begin:: Header Topbar -->
                        <div class="kt-header__topbar">

                            <!--begin: Search -->
                            <div class="kt-header__topbar-item kt-header__topbar-item--search dropdown kt-hidden-desktop" id="kt_quick_search_toggle">
                                <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,10px">
											<span class="kt-header__topbar-icon kt-header__topbar-icon--success">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24" />
														<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
														<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
													</g>
												</svg>

                                                <!--<i class="flaticon2-search-1"></i>-->
											</span>
                                </div>
                                <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-lg">
                                    <div class="kt-quick-search kt-quick-search--dropdown kt-quick-search--result-compact" id="kt_quick_search_dropdown">
                                        <form method="get" class="kt-quick-search__form">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-search-1"></i></span></div>
                                                <input type="text" class="form-control kt-quick-search__input" placeholder="Search...">
                                                <div class="input-group-append"><span class="input-group-text"><i class="la la-close kt-quick-search__close"></i></span></div>
                                            </div>
                                        </form>
                                        <div class="kt-quick-search__wrapper kt-scroll" data-scroll="true" data-height="325" data-mobile-height="200">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--end: Search -->

                            <!--begin: User bar -->
                            <div class="kt-header__topbar-item kt-header__topbar-item--user">
                                <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,10px">
                                    <span class="kt-hidden kt-header__topbar-welcome">Hi,</span>
                                    <span class="kt-hidden kt-header__topbar-username">Nick</span>
                                    <img class="kt-hidden-" alt="Pic" src="<?= base_url(); ?>/assets/media/users/300_21.jpg" />
                                    <span class="kt-header__topbar-icon kt-header__topbar-icon--brand kt-hidden"><b>S</b></span>
                                </div>
                                <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">

                                    <!--begin: Head -->
                                    <div class="kt-user-card kt-user-card--skin-light kt-notification-item-padding-x">
                                        <div class="kt-user-card__avatar">
                                            <img class="kt-hidden-" alt="Pic" src="<?= base_url(); ?>/assets/media/users/300_25.jpg" />

                                            <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                                            <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold kt-hidden">S</span>
                                        </div>
                                        <div class="kt-user-card__name">
                                            Sean Stone
                                        </div>
                                        <div class="kt-user-card__badge">
                                            <span class="btn btn-label-primary btn-sm btn-bold btn-font-md">23 messages</span>
                                        </div>
                                    </div>

                                    <!--end: Head -->

                                    <!--begin: Navigation -->
                                    <div class="kt-notification">
                                        <a href="custom/apps/user/profile-1/personal-information.html" class="kt-notification__item">
                                            <div class="kt-notification__item-icon">
                                                <i class="flaticon2-calendar-3 kt-font-success"></i>
                                            </div>
                                            <div class="kt-notification__item-details">
                                                <div class="kt-notification__item-title kt-font-bold">
                                                    My Profile
                                                </div>
                                                <div class="kt-notification__item-time">
                                                    Account settings and more
                                                </div>
                                            </div>
                                        </a>
                                        <div class="kt-notification__custom kt-space-between">
                                            <a href="<?= base_url(); ?>/logout" class="btn btn-label btn-label-brand btn-sm btn-bold">Sign Out</a>
                                        </div>
                                    </div>

                                    <!--end: Navigation -->
                                </div>
                            </div>

                            <!--end: User bar -->
                        </div>

                        <!-- end:: Header Topbar -->
                    </div>
                </div>
                <div class="kt-header__bottom">
                    <div class="kt-container ">

                        <!-- begin: Header Menu -->
                        <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
                        <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
                            <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile ">
                                <ul class="kt-menu__nav ">
                                    <li class="kt-menu__item<?php if($active == 'dashboard'): ?> kt-menu__item--here<?php endif; ?>">
                                        <a href="/admin/reports/manage" class="kt-menu__link">
                                            <span class="kt-menu__link-text">Dashboard</span>
                                        </a>
                                    </li>
                                    <li class="kt-menu__item<?php if($active == 'accounts'): ?> kt-menu__item--here<?php endif; ?>">
                                        <a href="/admin/accounts/manage" class="kt-menu__link">
                                            <span class="kt-menu__link-text">Accounts</span>
                                        </a>
                                    </li>
                                    <li class="kt-menu__item<?php if($active == 'users'): ?> kt-menu__item--here<?php endif; ?>">
                                        <a href="/admin/users/manage" class="kt-menu__link">
                                            <span class="kt-menu__link-text">Users</span>
                                        </a>
                                    </li>
                                    <li class="kt-menu__item<?php if($active == 'plans'): ?> kt-menu__item--here<?php endif; ?>">
                                        <a href="/admin/plans/manage" class="kt-menu__link">
                                            <span class="kt-menu__link-text">Plans</span>
                                        </a>
                                    </li>
                                    <li class="kt-menu__item<?php if($active == 'orders'): ?> kt-menu__item--here<?php endif; ?>">
                                        <a href="/admin/orders/manage" class="kt-menu__link">
                                            <span class="kt-menu__link-text">Orders</span>
                                        </a>
                                    </li>
                                    <li class="kt-menu__item<?php if($active == 'discounts'): ?> kt-menu__item--here<?php endif; ?>">
                                        <a href="/admin/discounts/manage" class="kt-menu__link">
                                            <span class="kt-menu__link-text">Discounts</span>
                                        </a>
                                    </li>
                                    <li class="kt-menu__item<?php if($active == 'logs'): ?> kt-menu__item--here<?php endif; ?>">
                                        <a href="/admin/logs/manage" class="kt-menu__link">
                                            <span class="kt-menu__link-text">Logs</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="kt-header-toolbar">
                                <div class="kt-quick-search kt-quick-search--inline kt-quick-search--result-compact" id="kt_quick_search_inline">
                                    <form method="get" class="kt-quick-search__form">
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-search-1"></i></span></div>
                                            <input type="text" class="form-control kt-quick-search__input" placeholder="Search...">
                                            <div class="input-group-append"><span class="input-group-text"><i class="la la-close kt-quick-search__close" style="display: none;"></i></span></div>
                                        </div>
                                    </form>
                                    <div id="kt_quick_search_toggle" data-toggle="dropdown" data-offset="0px,10px"></div>
                                    <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-lg">
                                        <div class="kt-quick-search__wrapper kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- end: Header Menu -->
                    </div>
                </div>
            </div>