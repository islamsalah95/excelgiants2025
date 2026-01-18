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
    @stack('css')
</head>

<body>
    <!-- Header -->

    @include('web.partials.header')


    {{-- content --}}

    @yield('content')


    <!-- About Section -->
    @include('web.partials.about')

    <!-- Vision & Mission Section -->
    @include('web.partials.vision')


    <!-- Services Section -->
    @include('web.partials.services')


    <!-- Works Section -->
    @include('web.partials.works_section')

    <!-- Client Reviews Section -->
    @include('web.partials.reviews')

    <!-- Contact Section -->
    @include('web.partials.contact')

    <!-- Footer -->
    @include('web.partials.footer')


    @include('web.partials.buttons')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('web/script.js') }}"></script>
    @stack('js')
</body>

</html>
