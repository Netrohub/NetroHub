<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css','resources/css/stellar.css','resources/react/main.tsx'])
  </head>
  <body class="min-h-screen bg-background text-foreground">
    <div id="react-root"></div>
  </body>
</html>
