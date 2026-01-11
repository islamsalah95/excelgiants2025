<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Techsup Track connects skilled Saudi professionals with flexible work opportunities, enhancing employment efficiency and individual income. Join our platform to leverage experience, grow careers, and support economic development.">
    <meta name="keywords"
        content="Techsup Track, flexible work Saudi Arabia, job opportunities, employment solutions, freelance jobs, workforce development, Saudi professionals, gig economy, career growth, remote work Saudi, income growth">
    <meta name="author" content="Techsup Track">
    <link rel="icon" href="{{ asset('dash/assets/images/favicon.ico') }}">
    <link rel="shortcut icon" href="{{ asset('dash/assets/images/favicon.ico') }}">
    <title>Dashboard | Techsup Track</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100..700;1,100..700&amp;display=swap"
        rel="stylesheet">
    @include('dash.layouts.partial.css.header_css')
</head>

<body>
    <!-- loader starts-->
    <div class="loader-wrapper">
        <div class="loader">
            <div class="loader4"></div>
        </div>
    </div>
    <!-- loader ends-->
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        @include('dash.layouts.partial.header')
        <!-- Page Header Ends                              -->
        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Start-->
            @include('dash.layouts.partial.sidebar')
            <!-- Page Sidebar Ends-->
            <div class="page-body">
                <div class="container-fluid">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-6">
                                <h4>Default</h4>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">
                                            <svg class="stroke-icon">
                                                <use href="{{ asset('dash/assets/svg/icon-sprite.svg#stroke-home') }}">
                                                </use>
                                            </svg></a></li>
                                    <li class="breadcrumb-item">Dashboard</li>
                                    <li class="breadcrumb-item active">Default</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid starts-->
                <div class="container-fluid">

                    @yield('content')

                </div>
                <!-- Container-fluid Ends-->
            </div>
            <!-- footer start-->
            @include('dash.layouts.partial.footer')
        </div>
    </div>
    @include('dash.layouts.partial.scripts.footer_js')
</body>

</html>
