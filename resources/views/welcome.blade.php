<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="minimum-scale=1, initial-scale=1, width=device-width">

        <title>GaliElo</title>
        <link rel="shortcut icon" href="storage/favicon.ico" />

        <!-- Roboto font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" />

        <!-- Material icons -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />

    </head>
    <body >
        <div id="thecontent"></div>

        <script src="{{ url(mix('js/app.js')) }}"> </script>
        
    </body>
</html>