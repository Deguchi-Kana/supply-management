<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>備品管理システム | {{ config('app.name') }}</title>
    <script>
        window.AppName = @json(config('app.name'));
    </script>
</head>
<body>
<div id="app">
    <router-view></router-view>
</div>

@vite(['resources/js/app.js'])
</body>
</html>
