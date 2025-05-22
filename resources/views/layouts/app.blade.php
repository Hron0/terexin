<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ТехЦиф - Магазин цифровой техники')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .main-content {
            flex: 1;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        .footer {
            background-color: #343a40;
            color: white;
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <i class="fas fa-microchip me-2"></i>ТехЦиф
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Главная</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('catalog') ? 'active' : '' }}" href="{{ route('catalog') }}">Каталог</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">О нас</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <form class="d-flex me-2" action="{{ route('catalog') }}" method="GET">
                            <input class="form-control me-2" type="search" name="search" placeholder="Поиск товаров..." aria-label="Search">
                            <button class="btn btn-outline-light" type="submit">Поиск</button>
                        </form>
                        <div class="d-flex align-items-center">
                            <a href="#" class="btn btn-link text-white me-2" title="Избранное">
                                <i class="far fa-heart"></i>
                            </a>
                            <a href="#" class="btn btn-link text-white position-relative" title="Корзина">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    0
                                </span>
                            </a>
                            <a href="#" class="btn btn-link text-white ms-2" title="Личный кабинет">
                                <i class="far fa-user"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer py-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="text-uppercase mb-3">ТехЦиф</h5>
                    <p>Магазин цифровой техники с широким ассортиментом товаров и отличным сервисом.</p>
                    <div class="d-flex mt-3">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-vk"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-telegram"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-3">Информация</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('about') }}" class="text-white text-decoration-none">О нас</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Доставка</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Оплата</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Гарантия</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-3">Каталог</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('catalog') }}#смартфоны" class="text-white text-decoration-none">Смартфоны</a></li>
                        <li class="mb-2"><a href="{{ route('catalog') }}#ноутбуки" class="text-white text-decoration-none">Ноутбуки</a></li>
                        <li class="mb-2"><a href="{{ route('catalog') }}#планшеты" class="text-white text-decoration-none">Планшеты</a></li>
                        <li class="mb-2"><a href="{{ route('catalog') }}#аксессуары" class="text-white text-decoration-none">Аксессуары</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4">
                    <h5 class="text-uppercase mb-3">Контакты</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> г. Москва, ул. Примерная, д. 123</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> +7 (123) 456-78-90</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@techcif.ru</li>
                        <li class="mb-2"><i class="fas fa-clock me-2"></i> Пн-Вс: 10:00 - 22:00</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 bg-light">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; {{ date('Y') }} ТехЦиф. Все права защищены.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <img src="https://via.placeholder.com/50x30" alt="Visa" class="me-2">
                    <img src="https://via.placeholder.com/50x30" alt="MasterCard" class="me-2">
                    <img src="https://via.placeholder.com/50x30" alt="Mir">
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('scripts')
</body>
</html>
