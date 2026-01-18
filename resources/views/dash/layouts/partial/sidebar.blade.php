<div class="sidebar-wrapper" data-layout="stroke-svg">

    {{-- LOGO --}}
    <div class="logo-wrapper">
        <a href="{{ route('dash.home') }}">
            <img class="img-fluid"
                 src="{{ asset('dash/assets/images/logo/logo.png') }}" alt="Logo">
        </a>
        <div class="back-btn">
            <i class="fa fa-angle-left"></i>
        </div>
        <div class="toggle-sidebar">
            <i class="status_toggle middle sidebar-toggle" data-feather="grid"></i>
        </div>
    </div>

    <div class="logo-icon-wrapper">
        <a href="{{ route('dash.home') }}">
            <img class="img-fluid"
                 src="{{ asset('dash/assets/images/logo/logo-icon.png') }}" alt="Logo">
        </a>
    </div>

    <nav class="sidebar-main">
        <div class="left-arrow" id="left-arrow">
            <i data-feather="arrow-left"></i>
        </div>

        <div id="sidebar-menu">
            <ul class="sidebar-links" id="simple-bar">

                {{-- MOBILE BACK --}}
                <li class="back-btn">
                    <a href="{{ route('dash.home') }}">
                        <img class="img-fluid"
                             src="{{ asset('dash/assets/images/logo/logo-icon.png') }}" alt="">
                    </a>
                    <div class="mobile-back text-end">
                        <span>Back</span>
                        <i class="fa fa-angle-right ps-2"></i>
                    </div>
                </li>

                {{-- ================= GENERAL ================= --}}
                <li class="sidebar-main-title">
                    <div><h6>General</h6></div>
                </li>

                {{-- Dashboard --}}
                <li class="sidebar-list {{ request()->routeIs('dash.home') ? 'active' : '' }}">
                    <a class="sidebar-link link-nav" href="{{ route('dash.home') }}">
                        <svg class="stroke-icon">
                            <use href="{{ asset('dash/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ asset('dash/assets/svg/icon-sprite.svg#fill-home') }}"></use>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- ================= PRODUCT MANAGEMENT ================= --}}
                <li class="sidebar-main-title">
                    <div><h6>Product Management</h6></div>
                </li>

                {{-- Categories --}}
                <li class="sidebar-list {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <a class="sidebar-link link-nav" href="{{ route('categories.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ asset('dash/assets/svg/icon-sprite.svg#stroke-widget') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ asset('dash/assets/svg/icon-sprite.svg#fill-widget') }}"></use>
                        </svg>
                        <span>Categories</span>
                    </a>
                </li>

                {{-- Tags --}}
                <li class="sidebar-list {{ request()->routeIs('tags.*') ? 'active' : '' }}">
                    <a class="sidebar-link link-nav" href="{{ route('tags.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ asset('dash/assets/svg/icon-sprite.svg#stroke-bookmark') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ asset('dash/assets/svg/icon-sprite.svg#fill-bookmark') }}"></use>
                        </svg>
                        <span>Tags</span>
                    </a>
                </li>

                {{-- Products --}}
                <li class="sidebar-list {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <a class="sidebar-link link-nav" href="{{ route('products.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ asset('dash/assets/svg/icon-sprite.svg#stroke-ecommerce') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ asset('dash/assets/svg/icon-sprite.svg#fill-ecommerce') }}"></use>
                        </svg>
                        <span>Products</span>
                    </a>
                </li>

                {{-- ================= CONTENT MANAGEMENT ================= --}}
                <li class="sidebar-main-title">
                    <div><h6>Content Management</h6></div>
                </li>

                {{-- About --}}
                <li class="sidebar-list {{ request()->routeIs('about-sections.*') ? 'active' : '' }}">
                    <a class="sidebar-link link-nav" href="{{ route('about-sections.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ asset('dash/assets/svg/icon-sprite.svg#stroke-info') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ asset('dash/assets/svg/icon-sprite.svg#fill-info') }}"></use>
                        </svg>
                        <span>About Sections</span>
                    </a>
                </li>

                {{-- Vision --}}
                <li class="sidebar-list {{ request()->routeIs('vision-sections.*') ? 'active' : '' }}">
                    <a class="sidebar-link link-nav" href="{{ route('vision-sections.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ asset('dash/assets/svg/icon-sprite.svg#stroke-eye') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ asset('dash/assets/svg/icon-sprite.svg#fill-eye') }}"></use>
                        </svg>
                        <span>Vision Sections</span>
                    </a>
                </li>

                {{-- Services --}}
                <li class="sidebar-list {{ request()->routeIs('services-sections.*') ? 'active' : '' }}">
                    <a class="sidebar-link link-nav" href="{{ route('services-sections.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ asset('dash/assets/svg/icon-sprite.svg#stroke-settings') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ asset('dash/assets/svg/icon-sprite.svg#fill-settings') }}"></use>
                        </svg>
                        <span>Services Sections</span>
                    </a>
                </li>

                {{-- Works --}}
                <li class="sidebar-list {{ request()->routeIs('works-sections.*') ? 'active' : '' }}">
                    <a class="sidebar-link link-nav" href="{{ route('works-sections.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ asset('dash/assets/svg/icon-sprite.svg#stroke-briefcase') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ asset('dash/assets/svg/icon-sprite.svg#fill-briefcase') }}"></use>
                        </svg>
                        <span>Works Sections</span>
                    </a>
                </li>

                {{-- Reviews --}}
                <li class="sidebar-list {{ request()->routeIs('reviews.*') ? 'active' : '' }}">
                    <a class="sidebar-link link-nav" href="{{ route('reviews.index') }}">
                        <svg class="stroke-icon">
                            <use href="{{ asset('dash/assets/svg/icon-sprite.svg#stroke-star') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ asset('dash/assets/svg/icon-sprite.svg#fill-star') }}"></use>
                        </svg>
                        <span>Reviews</span>
                    </a>
                </li>

            </ul>

            <div class="right-arrow" id="right-arrow">
                <i data-feather="arrow-right"></i>
            </div>
        </div>
    </nav>
</div>
