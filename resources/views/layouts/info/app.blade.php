    <!doctype html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>WhoICard - This is Enough!</title>
        <link rel="canonical" href="https://store.whoicard.com/" />
        <meta property="og:locale" content="en_US" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="Home - WhoICard - This is Enough!" />
        <meta property="og:url" content="https://whoicard.com/info" />
        <meta property="og:site_name" content="WhoICard - This is Enough!" />
        <meta property="article:publisher" content="https://www.facebook.com/whoicard" />
        <link rel="shortcut icon" href="{{ asset('storage/img/favicon/favicon.ico') }}" type="image/x-icon">
        <link rel="icon" href="{{ asset('storage/img/favicon/favicon.ico') }}" type="image/x-icon">
        <script src="https://kit.fontawesome.com/0c3484bda3.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://unpkg.com/jodit@4.0.0-beta.24/es2021/jodit.min.css" />
        <script src="https://unpkg.com/jodit@4.0.0-beta.24/es2021/jodit.min.js"></script>
        <!-- Fonts -->


        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>

    <body>
        @include('layouts.info.header')

        <div id="app">
            <main class="py-4">
                @yield('content')
            </main>
        </div>

        @include('layouts.info.footer')
    </body>


    @yield('pageModels')

    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                    pageLanguage: 'en'
                },
                'google_translate_element'
            );
        }



    </script>

    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?
    cb=googleTranslateElementInit"></script>
    <script src="https://unpkg.com/jodit@4.0.0-beta.24/es2021/jodit.min.js"></script>

    @yield('scripts')


    </html>
