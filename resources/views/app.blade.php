<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo env('APP_NAME'); ?></title>
        <link rel="icon" type="image/x-icon" href={{ asset('assets/favicon.png') }}>

        <!-- Styles -->
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
        <script src="{{ mix('/js/app.js') }}" defer></script>

        @inertiaHead
        @routes
    </head>
    <body>
        @inertia
    </body>
</html>
