    <header class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between w-100">
                <!-- User/Menu Icons Left (Placeholder) -->
                <div class="d-flex gap-3 align-items-center">
                    <div class="dropdown">
                        <a href="#" class="text-decoration-none dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false" style="color: var(--text-color)">
                            <i class="fa-solid fa-bars fs-5"></i>
                        </a>
                        <ul class="dropdown-menu text-end">
                            <li><a class="dropdown-item" href="index.html">الرئيسية</a></li>
                            <li>
                                <a class="dropdown-item" href="add-program.html">اضافة برنامج</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="requests.html">طلبات الزوار</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li>
                                <a class="dropdown-item" href="contact.html">اتصل بنا</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="privacy.html">سياسة الخصوصية</a>
                            </li>

                            @if (Route::has('login'))
                                <nav class="flex items-center justify-end gap-4">
                                    @auth
                                        <li>
                                            <a href="{{ url('/home') }}" class="dropdown-item">
                                                Home
                                            </a>
                                        </li>
                                    @else
                                        <li>
                                            <a class="dropdown-item" href="{{ route('login') }}">Log in</a>
                                        </li>

                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="dropdown-item">
                                                Register
                                            </a>
                                        @endif
                                    @endauth
                                </nav>
                            @endif


                        </ul>
                    </div>
                    <a href="login.html" style="color: var(--text-color)"><i class="fa-solid fa-user"></i></a>
                </div>

                <!-- Logo Center -->
                <div class="logo-container mx-auto">
                    <!-- Ideally an image, but using text/icon for clone if no asset provided -->
                    <h3 class="mb-0 fw-bold">
                        <span style="color: var(--accent-color)">Exceel</span>للحلو
                        البرمجية
                        <i class="fa-regular fa-circle-play" style="color: var(--accent-color)"></i>
                    </h3>
                </div>

                <!-- Search Right -->
                <div class="d-none d-md-block" style="width: 300px">
                    <div class="search-container">
                        <input type="text" class="search-input" placeholder="ابحث عن برنامج..." />
                        <i class="fa-solid fa-magnifying-glass search-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </header>
