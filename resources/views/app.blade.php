<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="/css/app.css">
    <meta name="client-secret" content="58porFc2or2W8ZNkJj3FFt2leMg99REtriNkTZaT">
</head>
    <body>
        <div id="app"/>
    </body>
</html>
<script src="{{ asset("/js/app.js?v.1.7") }}" charset="utf-8"></script>
