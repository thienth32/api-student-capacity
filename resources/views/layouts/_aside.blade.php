<div class="aside-menu flex-column-fluid">
    <!--begin::Aside Menu-->
    <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
        <!--begin::Menu-->
        <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">
            <div class="menu-item menu-accordion">
                <a class="menu-link" href="{{ route('dashboard') }}">
                    <span class="menu-icon">
                        <span class="svg-icon svg-icon-primary svg-icon-2x">
                            <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo2/dist/../src/media/svg/icons/Home/Home.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z" fill="#000000" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>

                    </span>
                    <span class="menu-title">Trang chủ</span>
                </a>

            </div>

            @foreach(\Menu::get() as $menu)
            @hasanyrole($menu['role'])
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                @if (isset($menu['link']))
                <a href="{{ route($menu['link']). $menu['param'] }}">
                    <span class="menu-link">
                            <span class="menu-icon">
                                {!! $menu['icon'] !!}
                            </span>
                            <span class="menu-title">{!! $menu['name'] !!}</span>
                            @if (isset($menu['subs-menu']))
                                <span class="menu-arrow"></span>
                            @endif
                        </span>
                    </a>
                @else
                    <span class="menu-link">
                        <span class="menu-icon">
                            {!! $menu['icon'] !!}
                        </span>
                        <span class="menu-title">{!! $menu['name'] !!}</span>
                        <span class="menu-arrow"></span>
                    </span>
                @endif
                <div class="menu-sub menu-sub-accordion menu-active-bg">
                    @if (isset($menu['subs-menu']))
                        @foreach($menu['subs-menu'] as $subMenu)
                            @hasanyrole($subMenu['role'])
                                <div class="menu-item">
                                    <a class="menu-link" href="{{ route($subMenu['link']). $subMenu['param'] }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ $subMenu['name'] }}</span>
                                    </a>
                                </div>
                            @endhasrole
                        @endforeach
                    @endif

                </div>
            </div>
            @endhasrole
            @endforeach

        </div>
        <!--end::Menu-->
    </div>
    <!--end::Aside Menu-->
</div>
