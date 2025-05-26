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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            color: #fff !important;
        }
        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            transition: color 0.3s ease;
        }
        .navbar-nav .nav-link:hover {
            color: #fff !important;
        }
        .navbar-nav .nav-link.active {
            color: #fff !important;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 0.375rem;
        }
        .footer {
            background-color: #343a40;
            color: white;
        }
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        .dropdown-menu {
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }
        .search-form {
            max-width: 300px;
        }
        @media (max-width: 992px) {
            .search-form {
                max-width: 100%;
                margin: 0.5rem 0;
            }
        }
        .btn-cart {
            position: relative;
            color: rgba(255, 255, 255, 0.85) !important;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
        }
        .btn-cart:hover {
            color: #fff !important;
            background-color: rgba(255, 255, 255, 0.1);
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
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <!-- Left Navigation -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                <i class="fas fa-home me-1"></i> Главная
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('catalog') ? 'active' : '' }}" href="{{ route('catalog') }}">
                                <i class="fas fa-th-large me-1"></i> Каталог
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                                <i class="fas fa-info-circle me-1"></i> О нас
                            </a>
                        </li>
                    </ul>
                    
                    <!-- Search Form -->
                    <form class="d-flex search-form mx-lg-3" action="{{ route('catalog') }}" method="GET" style="margin-bottom: 0px;">
                        <!-- Preserve current filters -->
                        @if(request('category_id'))
                            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                        @endif
                        @if(request('min_price'))
                            <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                        @endif
                        @if(request('max_price'))
                            <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                        @endif
                        @if(request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif
                        
                        <div class="input-group">
                            <input class="form-control" type="search" name="search" placeholder="Поиск товаров..." aria-label="Search" value="{{ request('search') }}">
                            <button class="btn btn-outline-light" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                    
                    <!-- Right Navigation -->
                    <ul class="navbar-nav">
                        @guest
                            <!-- Unauthorized User Navigation -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt me-1"></i> Войти
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus me-1"></i> Регистрация
                                </a>
                            </li>
                        @else
                            <!-- Basket Link (only for regular users) -->
                            @if(!Auth::user()->isAdmin())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('basket') ? 'active' : '' }}" href="{{ route('basket') }}">
                                        <i class="fas fa-shopping-cart me-1"></i> Корзина
                                        @if(session('cart_count', 0) > 0)
                                            <span class="cart-badge">{{ session('cart_count', 0) }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                            
                            <!-- User Dropdown -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="user-avatar me-2">
                                    @else
                                        <i class="fas fa-user-circle me-1"></i>
                                    @endif
                                    {{ Auth::user()->name }}
                                    @if(Auth::user()->isAdmin())
                                        <span class="badge bg-warning text-dark ms-2">Admin</span>
                                    @endif
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    @if(Auth::user()->isAdmin())
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                                <i class="fas fa-cogs me-2"></i> Админ-панель
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                    @else
                                        <li>
                                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                                <i class="fas fa-user me-2"></i> Профиль
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('orders') }}">
                                                <i class="fas fa-shopping-bag me-2"></i> Мои заказы
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                    @endif
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-sign-out-alt me-2"></i> Выйти
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show m-3" role="alert">
                <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

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
                {{-- Фото Visa, MasterCard & Mir (Платёжные системы) --}}
                {{-- <div class="col-md-6 text-center text-md-end">
                    <img src="https://via.placeholder.com/50x30" alt="Visa" class="me-2">
                    <img src="https://via.placeholder.com/50x30" alt="MasterCard" class="me-2">
                    <img src="https://via.placeholder.com/50x30" alt="Mir">
                </div> --}}
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Set CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('scripts')
</body>
</html>







<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        color: #fff !important;
    }
    .navbar-nav .nav-link {
        color: rgba(255, 255, 255, 0.85) !important;
        font-weight: 500;
        padding: 0.5rem 1rem !important;
        transition: color 0.3s ease;
    }
    .navbar-nav .nav-link:hover {
        color: #fff !important;
    }
    .navbar-nav .nav-link.active {
        color: #fff !important;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 0.375rem;
    }
    .footer {
        background-color: #343a40;
        color: white;
    }
    .cart-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background-color: #dc3545;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    .dropdown-menu {
        border-radius: 0.5rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
    }
    .search-form {
        max-width: 300px;
    }
    @media (max-width: 992px) {
        .search-form {
            max-width: 100%;
            margin: 0.5rem 0;
        }
    }
    .btn-cart {
        position: relative;
        color: rgba(255, 255, 255, 0.85) !important;
        text-decoration: none;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        transition: all 0.3s ease;
    }
    .btn-cart:hover {
        color: #fff !important;
        background-color: rgba(255, 255, 255, 0.1);
    }
</style>









                    <!-- Right Navigation -->
                    <ul class="navbar-nav">
                        @guest
                            <!-- Unauthorized User Navigation -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt me-1"></i> Войти
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus me-1"></i> Регистрация
                                </a>
                            </li>
                        @else
                            <!-- Basket Link (only for regular users) -->
                            @if(!Auth::user()->isAdmin())
                                <li class="nav-item">
                                    <a class="btn-cart" href="{{ route('basket') }}">
                                        <i class="fas fa-shopping-cart me-1"></i> Корзина
                                        @if(session('cart_count', 0) > 0)
                                            <span class="cart-badge">{{ session('cart_count', 0) }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                            
                            <!-- User Dropdown -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="user-avatar me-2">
                                    @else
                                        <i class="fas fa-user-circle me-1"></i>
                                    @endif
                                    {{ Auth::user()->name }}
                                    @if(Auth::user()->isAdmin())
                                        <span class="badge bg-warning text-dark ms-2">Admin</span>
                                    @endif
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    @if(Auth::user()->isAdmin())
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                                <i class="fas fa-cogs me-2"></i> Админ-панель
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                    @else
                                        <li>
                                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                                <i class="fas fa-user me-2"></i> Профиль
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('orders') }}">
                                                <i class="fas fa-shopping-bag me-2"></i> Мои заказы
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                    @endif
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-sign-out-alt me-2"></i> Выйти
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>