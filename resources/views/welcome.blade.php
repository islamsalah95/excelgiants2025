<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Exceel-للحلو البرمجية</title>
    <!-- Bootstrap 5 RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('web/style.css') }}" />
</head>

<body>
    <!-- Header -->
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

    <!-- Secondary Nav / Filter Bar -->
    <div class="filter-bar">
        <div class="container d-flex justify-content-center flex-wrap">
            <button class="filter-btn active">
                <i class="fa-solid fa-house"></i> الرئيسية
            </button>
            <button class="filter-btn">
                <i class="fa-solid fa-film"></i> برامج اكسل
            </button>
            <button class="filter-btn">
                <i class="fa-solid fa-tv"></i> برامج اوفيس
            </button>
            <button class="filter-btn">
                <i class="fa-solid fa-masks-theater"></i> برامج متنوعة
            </button>
            <button class="filter-btn">
                <i class="fa-solid fa-fire"></i> ترند
            </button>
        </div>
    </div>

    <!-- Advanced Filters -->
    <div class="container advanced-filters">
        <div class="row g-2">
            <div class="col-6 col-md-3">
                <span class="filter-label">التصنيف</span>
                <select class="custom-select">
                    <option>الكل</option>
                    <option>برامج اكسل</option>
                    <option>برامج اوفيس</option>
                    <option>برامج متنوعة</option>
                    <option>برامج ترند</option>
                </select>
            </div>
            <div class="col-6 col-md-3">
                <span class="filter-label">السنة</span>
                <select class="custom-select">
                    <option>بدون اختيار</option>
                    <option>2024</option>
                    <option>2023</option>
                </select>
            </div>
            <div class="col-6 col-md-3">
                <span class="filter-label">التقييم</span>
                <select class="custom-select">
                    <option>الاحدث</option>
                    <option>الاعلى تقييما</option>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <span class="filter-label">عرض</span>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-dark w-100" id="btnListView">
                        <i class="fa-solid fa-list"></i>
                    </button>
                    <button class="btn btn-sm btn-dark w-100 active" id="btnGridView">
                        <i class="fa-solid fa-border-all"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="text-black"><i class="fa-solid fa-tv"></i> برامج اكسل</h4>
            <a href="#" class="text-secondary text-decoration-none">مشاهدة الكل</a>
        </div>

        <div id="contentGrid" class="row row-cols-2 row-cols-md-4 row-cols-lg-4 g-3">
            <!-- Card 1 -->
            <div class="col">
                <div class="content-card">
                    <div class="ribbon">حصري</div>
                    <div class="card-img-container">
                        <a href="details.html">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/a/af/Adobe_Photoshop_CC_icon.svg"
                                alt="Avira" />
                        </a>
                    </div>
                    <div class="card-overlay">
                        <h5 class="card-title">تفعيل برنامج Avira Phantom VPN Pro</h5>
                        <div class="star-rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        </div>
                        <span class="price-tag price-free">مجاني</span>
                    </div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col">
                <div class="content-card">
                    <div class="card-img-container">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/af/Adobe_Photoshop_CC_icon.svg"
                            alt="Chrome" />
                    </div>
                    <div class="card-overlay">
                        <h5 class="card-title">متصفح جوجل كروم Google Chrome</h5>
                        <div class="star-rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star-half-stroke"></i>
                        </div>
                        <span class="price-tag price-free">مجاني</span>
                    </div>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="col">
                <div class="content-card">
                    <div class="ribbon">جديد</div>
                    <div class="card-img-container">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/af/Adobe_Photoshop_CC_icon.svg"
                            alt="IDM" />
                    </div>
                    <div class="card-overlay">
                        <h5 class="card-title">برنامج التحميل IDM كامل</h5>
                        <div class="star-rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <span class="price-tag">25$</span>
                    </div>
                </div>
            </div>
            <!-- Card 4 -->
            <div class="col">
                <div class="content-card">
                    <div class="card-img-container">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/af/Adobe_Photoshop_CC_icon.svg"
                            alt="WinRAR" />
                    </div>
                    <div class="card-overlay">
                        <h5 class="card-title">برنامج الضغط WinRAR</h5>
                        <div class="star-rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        </div>
                        <span class="price-tag price-free">مجاني</span>
                    </div>
                </div>
            </div>
            <!-- Card 5 -->
            <div class="col">
                <div class="content-card">
                    <div class="card-img-container">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/af/Adobe_Photoshop_CC_icon.svg"
                            alt="VLC" />
                    </div>
                    <div class="card-overlay">
                        <h5 class="card-title">مشغل الفيديا VLC Player</h5>
                        <div class="star-rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star-half-stroke"></i>
                        </div>
                        <span class="price-tag price-free">مجاني</span>
                    </div>
                </div>
            </div>
            <!-- Card 6 -->
            <div class="col">
                <div class="content-card">
                    <div class="card-img-container">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/af/Adobe_Photoshop_CC_icon.svg"
                            alt="Office" />
                    </div>
                    <div class="card-overlay">
                        <h5 class="card-title">حزمة اوفيس 2024 كاملة</h5>
                        <div class="star-rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <span class="price-tag price-discount">
                            <span class="text-white text-decoration-line-through me-1"
                                style="font-size: 0.8em; opacity: 0.7">150$</span>
                            99$
                        </span>
                    </div>
                </div>
            </div>
            <!-- Card 7 -->
            <div class="col">
                <div class="content-card">
                    <div class="card-img-container">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/af/Adobe_Photoshop_CC_icon.svg"
                            alt="Adobe" />
                    </div>
                    <div class="card-overlay">
                        <h5 class="card-title">ادوبي فوتوشوب 2024</h5>
                        <div class="star-rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star-half-stroke"></i>
                        </div>
                        <span class="price-tag">30$</span>
                    </div>
                </div>
            </div>
            <!-- Card 8 -->
            <div class="col">
                <div class="content-card">
                    <div class="card-img-container">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/af/Adobe_Photoshop_CC_icon.svg"
                            alt="Zoom" />
                    </div>
                    <div class="card-overlay">
                        <h5 class="card-title">برنامج المحادثات Zoom</h5>
                        <div class="star-rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-regular fa-star"></i>
                        </div>
                        <span class="price-tag price-free">مجاني</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <a href="#" class="page-link">&laquo;</a>
            <a href="#" class="page-link active">1</a>
            <a href="#" class="page-link">2</a>
            <a href="#" class="page-link">3</a>
            <span class="text-muted align-self-end mx-1">...</span>
            <a href="#" class="page-link">10</a>
            <a href="#" class="page-link">&raquo;</a>
        </div>
    </main>

    <!-- About Section -->
    <section id="about" style="background-color: var(--section-alt-bg)">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="about-img">
                        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
                            class="img-fluid" alt="About Us" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="about-text">
                        <h3>من نحن</h3>
                        <p>
                            نحن في "Exceel-للحلو البرمجية" نسعى لتقديم أفضل الحلول البرمجية
                            المتكاملة. متخصصون في توفير أحدث البرامج والتطبيقات الأصلية التي
                            تلبي احتياجات المستخدمين والشركات على حد سواء.
                        </p>
                        <p>
                            فريقنا مكرس لضمان تجربة مستخدم سلسة وآمنة، مع توفير دعم فني
                            متميز ومكتبة ضخمة ومتجددة باستمرار.
                        </p>
                        <button class="btn btn-warning text-white mt-2">
                            اقرأ المزيد
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission Section -->
    <section id="vision">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6">
                    <a class="vision-card" href="#">
                        <div class="rounded p-4">
                            <div class="icon mb-3">
                                <i class="fa-solid fa-eye"></i>
                            </div>
                            <h6>الرؤية</h6>
                            <span>نسعي ان نكون من افضل الشركات الرائدة في صناعة البرمجيات محليا
                                ودوليا</span>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <a class="vision-card" href="#">
                        <div class="rounded p-4">
                            <div class="icon mb-3">
                                <i class="fa-solid fa-bullseye"></i>
                            </div>
                            <h6>الأهداف</h6>
                            <span>تصميم وتطوير برمجيات مخصصة تلبي احتياجات ومتطلبات العملاء
                                الفريدة.</span>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <a class="vision-card" href="#">
                        <div class="rounded p-4">
                            <div class="icon mb-3">
                                <i class="fa-solid fa-paper-plane"></i>
                            </div>
                            <h6>الرسالة</h6>
                            <span>تحويل الأفكار الإبداعية إلى حلول برمجية مبتكرة لتلبي احتياجات
                                العملاء</span>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <a class="vision-card" href="#">
                        <div class="rounded p-4">
                            <div class="icon mb-3">
                                <i class="fa-solid fa-hand-holding-heart"></i>
                            </div>
                            <h6>القيم</h6>
                            <span>نضع احتياجات عملائنا في مقدمة أولوياتنا ونعمل جاهدين لتحقيق
                                رضاهم.</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services">
        <div class="container">
            <div class="section-title">
                <h2>خدماتنا</h2>
                <p>نقدم مجموعة واسعة من الخدمات التقنية لتلبية جميع احتياجاتكم</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fa-solid fa-cloud-arrow-down"></i>
                        </div>
                        <h4 class="service-title">تحميل برامج</h4>
                        <p class="service-desc">
                            نوفر روابط تحميل مباشرة وسريعة لأحدث البرامج والألعاب بجميع
                            إصداراتها.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <div class="service-icon"><i class="fa-solid fa-code"></i></div>
                        <h4 class="service-title">حلول برمجية</h4>
                        <p class="service-desc">
                            تطوير تطبيقات وأدوات مخصصة تساعد في تحسين الإنتاجية وإدارة
                            الأعمال.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <h4 class="service-title">دعم فني</h4>
                        <p class="service-desc">
                            فريق دعم فني جاهز للاجابة على استفساراتكم وحل المشاكل التقنية
                            التي تواجهكم.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Works Section -->
    <section id="works" style="background-color: var(--section-alt-bg)">
        <div class="container">
            <div class="section-title">
                <h2>اعمالنا</h2>
                <p>نظرة سريعة على بعض المشاريع والأنظمة التي قمنا بتطويرها</p>
            </div>
            <div class="row g-3">
                <div class="col-md-4 col-sm-6">
                    <div class="work-item">
                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"
                            alt="Work 1" />
                        <div class="work-overlay">
                            <h5 class="text-white">نظام إدارة المبيعات</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="work-item">
                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"
                            alt="Work 2" />
                        <div class="work-overlay">
                            <h5 class="text-white">تطبيق جوال للاخبار</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="work-item">
                        <img src="https://images.unsplash.com/photo-1555774698-0b77e0d5fac6?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"
                            alt="Work 3" />
                        <div class="work-overlay">
                            <h5 class="text-white">موقع تجارة الكترونية</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Client Reviews Section -->
    <section id="reviews">
        <div class="container">
            <div class="section-title">
                <h2>آراء عملائنا</h2>
                <p>ماذا يقول عملاؤنا عن خدماتنا وبرامجنا</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="review-card">
                        <div class="d-flex text-warning mb-3">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i>
                        </div>
                        <p class="review-text">
                            "موقع ممتاز جداً، وجدت فيه كل البرامج التي كنت أبحث عنها بروابط
                            مباشرة وآمنة. شكراً لكم!"
                        </p>
                        <div class="reviewer-info">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User"
                                class="reviewer-img" />
                            <div>
                                <h6 class="mb-0">أحمد محمد</h6>
                                <small class="text-muted">مصمم جرافيك</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="review-card">
                        <div class="d-flex text-warning mb-3">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                class="fa-regular fa-star"></i>
                        </div>
                        <p class="review-text">
                            "خدمة الدعم الفني رائعة وسريعة الاستجابة. ساعدوني في تفعيل نسخة
                            الاوفيس بسهولة تامة."
                        </p>
                        <div class="reviewer-info">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User"
                                class="reviewer-img" />
                            <div>
                                <h6 class="mb-0">سارة علي</h6>
                                <small class="text-muted">مديرة حسابات</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" style="background-color: var(--section-alt-bg)">
        <div class="container">
            <div class="section-title">
                <h2>اتصل بنا</h2>
                <p>نسعد بتواصلكم معنا في أي وقت</p>
            </div>
            <div class="row">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <div class="contact-info-item">
                        <div class="contact-icon">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold">العنوان</h5>
                            <p class="mb-0">
                                شارع التكنولوجيا، مبنى رقم 10، الطابق 4، القاهرة، مصر
                            </p>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-icon"><i class="fa-solid fa-phone"></i></div>
                        <div>
                            <h5 class="fw-bold">الهاتف</h5>
                            <p class="mb-0">+20 123 456 789</p>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold">البريد الالكتروني</h5>
                            <p class="mb-0">info@exceel-clone.com</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <form class="contact-form">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="الاسم الكامل" />
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control" placeholder="البريد الالكتروني" />
                            </div>
                        </div>
                        <input type="text" class="form-control" placeholder="الموضوع" />
                        <textarea class="form-control" rows="5" placeholder="رسالتك"></textarea>
                        <button type="submit" class="btn w-100"
                            style="background-color: var(--accent-color); color: white">
                            ارسال الرسالة
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-logo">
                <h3 class="mb-0 fw-bold">
                    <span style="color: var(--accent-color)">Exceel</span>للحلو البرمجية
                    <i class="fa-regular fa-circle-play" style="color: var(--accent-color)"></i>
                </h3>
            </div>
            <p class="footer-text">
                مكتبة متكاملة لتحميل أحدث البرامج والتطبيقات بروابط مباشرة،
                <br />
                بإصدارات أصلية وآمنة، وبدون إعلانات مزعجة أو روابط مضللة.
            </p>

            <div class="footer-social mb-4">
                <a href="#" class="social-icon facebook"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" class="social-icon whatsapp"><i class="fa-brands fa-whatsapp"></i></a>
                <a href="#" class="social-icon twitter"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="#" class="social-icon instagram"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="social-icon youtube"><i class="fa-brands fa-youtube"></i></a>
            </div>

            <div class="footer-links">
                <a href="privacy.html" class="btn">سياسة الخصوصية</a>
                <a href="contact.html" class="btn">اتصل بنا</a>
                <a href="requests.html" class="btn">طلبات الزوار</a>
                <a href="add-program.html" class="btn">اضافة برنامج</a>
            </div>
            <div class="copyright">
                جميع الحقوق محفوظة لصالح عرب سيد | 2026 &copy;
                <span>Exceel-للحلو البرمجية</span> | احد اعمال
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('web/script.js') }}"></script>
    <!-- Floating WhatsApp Icon -->
    <a href="https://wa.me/201272570173" class="whatsapp-float" target="_blank">
        <i class="fa-brands fa-whatsapp"></i>
    </a>

    <!-- Back to Top Button -->
    <button id="backToTop" class="back-to-top" title="Go to top">
        <i class="fa-solid fa-arrow-up"></i>
    </button>
</body>

</html>
