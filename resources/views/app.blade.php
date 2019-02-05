<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Сайт</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
    <body>
    <!-- route outlet -->
    <!-- component matched by the route will render here -->
        <div id="app"/>
    </body>
</html>
<script src="{{ asset("/js/app.js?v.1.7") }}" charset="utf-8"></script>
