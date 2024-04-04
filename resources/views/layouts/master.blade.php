<!DOCTYPE html>
<html lang="en">
    @include('layouts.head')
<body>
    <div class="overlay" id="overlay"></div>
    <div class="spinner" id="spinner"></div>
    @include('layouts.header')
    @yield('content')
    @include('layouts.sidebar')
    @include('layouts.right-sidebar')
    @include('layouts.footer')
    @include('layouts.scripts')
</body>
</html>