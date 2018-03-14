<header id="header-bar__mobile">
    <div class="header-bar__btns">
        <button class="header-bar__hamburger" id="header-hamburger">
            <i class="fas fa-bars"></i>
        </button>
        <a href="/">
            <img class="header__logo" src="{{ asset('images/logo.png') }}" height="40">
        </a>
        <button class="header-bar__ellips" id="header-ellips">
            <i class="fas fa-ellipsis-v"></i>
        </button>
    </div>

    <div class="header-bar__nav" id="header-hamburger__nav">
        <ul class="header-bar__nav-list">
            <li class="header-bar__nav-list-itme close-nav" id="header-hamburger__close">
                <button><i class="fas fa-times"></i></button>
            </li>
            <li class="header-bar__nav-list-itme">
                <a href="/activities/1">登山健行</a>
            </li>
            <li class="header-bar__nav-list-itme">
                <a href="/activities/2">朔溪</a>
            </li>
            <li class="header-bar__nav-list-itme">
                <a href="/activities/3">攀岩</a>
            </li>
            <li class="header-bar__nav-list-itme">
                <a href="/activities/4">職人課程</a>
            </li>
            <li class="header-bar__nav-list-itme">
                <a href="/activities/5">立式划槳</a>
            </li>
            <li class="header-bar__nav-list-itme">
                <a href="/activities/6">團體教育</a>
            </li>
            <li class="header-bar__nav-list-itme">
                <a href="/reserve_car">接送預約</a>
            </li>
        </ul>
    </div>

    <div class="header-bar__user" id="header-ellips__nav">
        <ul class="header-bar__nav-list">
            <li class="header-bar__nav-list-itme close-nav" id="header-ellips__close">
                <button><i class="fas fa-times"></i></button>
            </li>
            <li class="header-bar__nav-list-itme">
                <a href="/member">會員資料</a>
            </li>
            <li class="header-bar__nav-list-itme">
                <a href="/member/order">訂單資料</a>
            </li>
        </ul>
    </div>
</header>

