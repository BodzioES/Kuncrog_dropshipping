<!-- Cookie Banner -->
<div id="cookieBanner" class="cookie-banner fixed-bottom bg-dark text-white p-3">
    <div class="container d-flex justify-content-between align-items-center flex-wrap">
        <div class="mb-2 mb-md-0">
            This website uses cookies to improve site performance and personalize content.
            <a href="/privacy" class="text-info text-decoration-underline">Privacy Policy</a>
        </div>
        <div class="d-flex">
            <button id="acceptCookiesBtn" class="btn btn-primary btn-sm ms-2">Accept</button>
            <button id="declineCookiesBtn" class="btn btn-secondary btn-sm ms-2">Reject</button>
        </div>
    </div>
</div>
@section('js-files')
    @vite(['resources/js/cookie-navbar.js'])
@endsection
