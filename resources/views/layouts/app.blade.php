<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $meta_title ?? 'Welcome' }}</title>
    @if ($meta_description)
        <meta name="description" content="{{ $meta_description }}">
    @endif
    @if ($meta_robots)
        <meta name="robots" content="{{ $meta_robots }}">
    @endif
</head>
<body>
    {{ $slot }}
</body>
</html>