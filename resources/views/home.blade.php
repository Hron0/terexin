<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ТехЦиф - Цифровая техника будущего</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Swiper CSS for slider -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <style>
        .hero-section {
            background: linear-gradient(135deg, #0061f2 0%, #00baf2 100%);
            color: white;
            padding: 6rem 0;
        }
        .category-card {
            transition: transform 0.3s ease;
            height: 100%;
        }
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .swiper {
            width: 100%;
            padding-top: 20px;
            padding-bottom: 50px;
        }
        .swiper-slide {
            background-position: center;
            background-size: cover;
            width: 300px;
            height: 300px;
        }
        .about-section {
            background-color: #f8f9fa;
        }
        .feature-icon {
            font-size: 2.5rem;
            color: #0061f2;
            margin-bottom: 1rem;
        }
        .category-image {
            height: 200px;
            object-fit: cover;
        }
        .no-categories {
            padding: 50px;
            text-align: center;
            background-color: #f8f9fa;
            border-radius: 8px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <nav class="navbar navbar-expand-lg navbar-light container py-3">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold text-primary fs-3" href="#">
                    <i class="fas fa-microchip me-2"></i>ТехЦиф
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Главная</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Каталог</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">О компании</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Контакты</a>
                        </li>
                    </ul>
                    <div class="d-flex ms-lg-4">
                        <a href="#" class="btn btn-outline-primary me-2">
                            <i class="fas fa-user me-1"></i> Войти
                        </a>
                        <a href="#" class="btn btn-primary position-relative">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                0
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Цифровая техника будущего - уже сегодня!</h1>
                    <p class="lead mb-4">Откройте для себя мир инновационных технологий с ТехЦиф - вашим надежным партнером в мире цифровых устройств.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="#" class="btn btn-light btn-lg">Каталог товаров</a>
                        <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg">Узнать больше</a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="https://via.placeholder.com/600x400" alt="Современные гаджеты" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Slider -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold">Категории товаров</h2>
            
            @if(count($categories) > 0)
                <!-- Swiper -->
                <div class="swiper categoriesSwiper">
                    <div class="swiper-wrapper">
                        @foreach($categories as $category)
                            <div class="swiper-slide">
                                <div class="category-card card border-0 shadow h-100">
                                    @if($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" class="card-img-top category-image" alt="{{ $category->name }}">
                                    @else
                                        <img src="https://via.placeholder.com/300x200?text={{ urlencode($category->name) }}" class="card-img-top category-image" alt="{{ $category->name }}">
                                    @endif
                                    <div class="card-body text-center">
                                        <h5 class="card-title fw-bold">{{ $category->name }}</h5>
                                        <p class="card-text">{{ $category->description ?? 'Описание категории отсутствует' }}</p>
                                        <a href="{{ route('home') }}?category={{ $category->id }}" class="btn btn-sm btn-primary">Перейти</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            @else
                <div class="no-categories">
                    <i class="fas fa-folder-open text-muted mb-3" style="font-size: 3rem;"></i>
                    <h3 class="fw-bold">Нет Категорий</h3>
                    <p class="text-muted">В данный момент категории товаров не добавлены.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- About Company Section -->
    <section class="about-section py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="https://via.placeholder.com/600x400" alt="О компании ТехЦиф" class="img-fluid rounded shadow">
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">О компании ТехЦиф</h2>
                    <p class="lead mb-4">Мы - молодая и динамично развивающаяся компания на рынке цифровой техники России.</p>
                    <p class="mb-4">Основанная в 2020 году группой энтузиастов и профессионалов IT-индустрии, компания ТехЦиф быстро завоевала доверие клиентов благодаря качественным товарам, конкурентным ценам и отличному сервису.</p>
                    <p class="mb-4">Наша миссия - делать современные технологии доступными для каждого. Мы тщательно отбираем товары, предлагая нашим клиентам только лучшие и проверенные устройства от ведущих мировых производителей.</p>
                    <div class="d-flex gap-3 mt-4">
                        <div class="text-primary">
                            <i class="fas fa-store fs-1"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold">15 магазинов</h5>
                            <p>По всей России</p>
                        </div>
                        <div class="text-primary ms-4">
                            <i class="fas fa-users fs-1"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold">50,000+ клиентов</h5>
                            <p>Довольных покупателей</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">Почему выбирают нас</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow h-100 p-4 text-center">
                        <div class="feature-icon mx-auto">
                            <i class="fas fa-truck"></i>
                        </div>
                        <h4 class="fw-bold">Быстрая доставка</h4>
                        <p>Доставляем заказы по всей России в кратчайшие сроки. Бесплатная доставка при заказе от 5000 ₽.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow h-100 p-4 text-center">
                        <div class="feature-icon mx-auto">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4 class="fw-bold">Гарантия качества</h4>
                        <p>Все товары сертифицированы и имеют официальную гарантию производителя от 1 года.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow h-100 p-4 text-center">
                        <div class="feature-icon mx-auto">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h4 class="fw-bold">Поддержка 24/7</h4>
                        <p>Наши специалисты всегда готовы помочь с выбором и ответить на любые вопросы.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section with Tailwind -->
    <section class="py-12 bg-gradient-to-r from-blue-600 to-blue-400 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl font-bold mb-6">Подпишитесь на наши новости</h2>
                <p class="text-xl mb-8">Получайте информацию о новинках, акциях и специальных предложениях первыми!</p>
                <form class="flex flex-col sm:flex-row gap-2 justify-center">
                    <input type="email" placeholder="Ваш email" class="px-4 py-3 rounded-lg text-gray-800 w-full sm:w-96">
                    <button type="submit" class="bg-white text-blue-600 font-bold px-6 py-3 rounded-lg hover:bg-blue-50 transition">
                        Подписаться
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-microchip me-2"></i>ТехЦиф
                    </h5>
                    <p>Цифровая техника будущего - уже сегодня!</p>
                    <p class="mb-3">© 2024 ТехЦиф. Все права защищены.</p>
                    <div class="d-flex gap-2">
                        <a href="#" class="text-white bg-primary p-2 rounded-circle">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-white bg-primary p-2 rounded-circle">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-white bg-primary p-2 rounded-circle">
                            <i class="fab fa-vk"></i>
                        </a>
                        <a href="#" class="text-white bg-primary p-2 rounded-circle">
                            <i class="fab fa-telegram"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5 class="fw-bold mb-3">Каталог</h5>
                    <ul class="list-unstyled">
                        @if(count($categories) > 0)
                            @foreach($categories->take(5) as $category)
                                <li class="mb-2">
                                    <a href="{{ route('home') }}?category={{ $category->id }}" class="text-white text-decoration-none">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        @else
                            <li class="mb-2">
                                <span class="text-muted">Категории не добавлены</span>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h5 class="fw-bold mb-3">Информация</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">О компании</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Доставка</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Оплата</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Гарантия</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Контакты</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4">
                    <h5 class="fw-bold mb-3">Контакты</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i> г. Москва, ул. Технологическая, 42
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-phone me-2"></i> 8 (800) 123-45-67
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-envelope me-2"></i> info@techcif.ru
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-clock me-2"></i> Пн-Вс: 10:00 - 22:00
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    
    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".categoriesSwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                992: {
                    slidesPerView: 3,
                },
                1200: {
                    slidesPerView: 4,
                },
            },
        });
    </script>
</body>
</html>