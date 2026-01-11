        <div class="sidebar-wrapper" data-layout="stroke-svg">
            <div class="logo-wrapper"><a href="{{ route('dash.home') }}"><img class="img-fluid"
                        src="{{ asset('dash/assets/images/logo/logo.png') }}" alt=""></a>
                <div class="back-btn"><i class="fa fa-angle-left"> </i></div>
                <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i>
                </div>
            </div>
            <div class="logo-icon-wrapper"><a href="{{ route('dash.home') }}"><img class="img-fluid"
                        src="{{ asset('dash/assets/images/logo/logo-icon.png') }}" alt=""></a></div>
            <nav class="sidebar-main">
                <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                <div id="sidebar-menu">
                    <ul class="sidebar-links" id="simple-bar">
                        <li class="back-btn"><a href="{{ route('dash.home') }}"><img class="img-fluid"
                                    src="{{ asset('dash/assets/images/logo/logo-icon.png') }}" alt=""></a>
                            <div class="mobile-back text-end"> <span>Back </span><i class="fa fa-angle-right ps-2"
                                    aria-hidden="true"></i></div>
                        </li>

                        <li class="pin-title sidebar-main-title">
                            <div>
                                <h6>Pinned</h6>
                            </div>
                        </li>

                        {{-- Dashboard --}}
                        <li class="sidebar-main-title">
                            <div>
                                <h6>General</h6>
                            </div>
                        </li>
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i><a
                                class="sidebar-link sidebar-title link-nav" href="{{ route('dash.home') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('dash/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('dash/assets/svg/icon-sprite.svg#fill-home') }}"></use>
                                </svg><span>Dashboard</span></a>
                        </li>

                        {{-- Product Management --}}
                        <li class="sidebar-main-title">
                            <div>
                                <h6>Product Management</h6>
                            </div>
                        </li>

                        {{-- Categories --}}
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                class="sidebar-link sidebar-title link-nav" href="{{ route('categories.index') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('dash/assets/svg/icon-sprite.svg#stroke-widget') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('dash/assets/svg/icon-sprite.svg#fill-widget') }}"></use>
                                </svg><span>Categories</span></a>
                        </li>

                        {{-- Tags --}}
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                class="sidebar-link sidebar-title link-nav" href="{{ route('tags.index') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('dash/assets/svg/icon-sprite.svg#stroke-bookmark') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('dash/assets/svg/icon-sprite.svg#fill-bookmark') }}"></use>
                                </svg><span>Tags</span></a>
                        </li>

                        {{-- Products --}}
                        <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                class="sidebar-link sidebar-title link-nav" href="{{ route('products.index') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('dash/assets/svg/icon-sprite.svg#stroke-ecommerce') }}"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('dash/assets/svg/icon-sprite.svg#fill-ecommerce') }}"></use>
                                </svg><span>Products</span></a>
                        </li>

                    </ul>
                    <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
                </div>
            </nav>
        </div>
