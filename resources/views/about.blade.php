@extends('layouts.app')

@section('title', 'ТехЦиф - Магазин цифровой техники')

@section('styles')
<style>
    .hero-section {
        background: linear-gradient(135deg, #0061f2 0%, #00baf2 100%);
        color: white;
        padding: 4rem 0;
    }
    .feature-icon {
        font-size: 2.5rem;
        color: #0061f2;
        margin-bottom: 1rem;
    }
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 2px;
        background-color: #0061f2;
    }
    .timeline-item {
        position: relative;
        padding-bottom: 30px;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -34px;
        top: 0;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background-color: #0061f2;
        border: 3px solid white;
        box-shadow: 0 0 0 2px #0061f2;
    }
    .team-member-img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #0061f2;
    }
    .brand-logo {
        height: 80px;
        object-fit: contain;
        filter: grayscale(100%);
        opacity: 0.7;
        transition: all 0.3s ease;
    }
    .brand-logo:hover {
        filter: grayscale(0%);
        opacity: 1;
    }
    .store-card {
        transition: transform 0.3s ease;
    }
    .store-card:hover {
        transform: translateY(-5px);
    }
</style>
@endsection
@section('content')

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 text-center">
                    <h1 class="display-4 fw-bold mb-4">О компании ТехЦиф</h1>
                    <p class="lead mb-0">Узнайте больше о нашей истории, миссии и ценностях</p>
                </div>
            </div>
        </div>
    </section>


    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="{{ asset('staticImages/about1.jpg') }}" alt="О компании ТехЦиф" class="img-fluid rounded shadow">
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">Наша история</h2>
                    <p class="lead mb-4">Мы - молодая и динамично развивающаяся компания на рынке цифровой техники России.</p>
                    <p class="mb-4">Компания ТехЦиф была основана в 2020 году группой энтузиастов и профессионалов IT-индустрии. Несмотря на сложный период пандемии, мы смогли быстро адаптироваться к новым реалиям и предложить клиентам удобный онлайн-сервис с доставкой техники на дом.</p>
                    <p>Начав с небольшого интернет-магазина, за короткий срок мы выросли до сети из 15 физических магазинов в крупнейших городах России. Наша команда постоянно растет, и сегодня в ТехЦиф работает более 200 специалистов, объединенных общей целью - делать современные технологии доступными для каждого.</p>
                </div>
            </div>

            <!-- Timeline -->
            <div class="row mb-5">
                <div class="col-12">
                    <h2 class="fw-bold text-center mb-5">Ключевые этапы развития</h2>
                    <div class="timeline">
                        <div class="timeline-item">
                            <h4 class="fw-bold">2020 - Основание компании</h4>
                            <p>Запуск интернет-магазина ТехЦиф в Москве. Первые 500 клиентов и формирование базового ассортимента.</p>
                        </div>
                        <div class="timeline-item">
                            <h4 class="fw-bold">2021 - Расширение ассортимента</h4>
                            <p>Заключение партнерских соглашений с ведущими производителями техники. Запуск собственной службы доставки.</p>
                        </div>
                        <div class="timeline-item">
                            <h4 class="fw-bold">2022 - Открытие первых физических магазинов</h4>
                            <p>Открытие первых 5 магазинов в Москве и Санкт-Петербурге. Запуск программы лояльности для постоянных клиентов.</p>
                        </div>
                        <div class="timeline-item">
                            <h4 class="fw-bold">2023 - Региональная экспансия</h4>
                            <p>Открытие магазинов в 8 крупнейших городах России. Запуск собственного сервисного центра.</p>
                        </div>
                        <div class="timeline-item">
                            <h4 class="fw-bold">2024 - Настоящее время</h4>
                            <p>15 магазинов по всей России, более 50 000 довольных клиентов и амбициозные планы на будущее.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mission and Values -->
            <div class="row mb-5 py-5 bg-light rounded">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="fw-bold mb-4">Наша миссия</h2>
                    <p class="lead">Делать современные технологии доступными для каждого, помогая людям улучшать качество жизни через инновации.</p>
                    <p>Мы стремимся не просто продавать технику, а помогать нашим клиентам находить идеальные решения для их потребностей. Наши консультанты всегда готовы подобрать оптимальный вариант, учитывая индивидуальные запросы и бюджет.</p>
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">Наши ценности</h2>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <div class="d-flex">
                                <div class="me-3 text-primary">
                                    <i class="fas fa-check-circle fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold">Качество</h5>
                                    <p>Мы предлагаем только сертифицированную технику от проверенных производителей.</p>
                                </div>
                            </div>
                        </li>
                        <li class="mb-3">
                            <div class="d-flex">
                                <div class="me-3 text-primary">
                                    <i class="fas fa-check-circle fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold">Клиентоориентированность</h5>
                                    <p>Интересы клиента всегда на первом месте. Мы стремимся превосходить ожидания.</p>
                                </div>
                            </div>
                        </li>
                        <li class="mb-3">
                            <div class="d-flex">
                                <div class="me-3 text-primary">
                                    <i class="fas fa-check-circle fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold">Инновации</h5>
                                    <p>Мы постоянно следим за новинками рынка и внедряем передовые технологии.</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex">
                                <div class="me-3 text-primary">
                                    <i class="fas fa-check-circle fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold">Доступность</h5>
                                    <p>Мы стремимся сделать современные технологии доступными для широкого круга потребителей.</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Team -->
            <div class="row mb-5">
                <div class="col-12 text-center mb-5">
                    <h2 class="fw-bold">Наша команда</h2>
                    <p class="lead">Познакомьтесь с профессионалами, которые делают ТехЦиф особенным</p>
                </div>
                <div class="col-md-6 col-lg-3 mb-4 text-center">
                    <img src="{{ asset('staticImages/employee1.jfif') }}" alt="Александр Петров" class="team-member-img mb-3">
                    <h5 class="fw-bold">Александр Петров</h5>
                    <p class="text-muted">Генеральный директор</p>
                </div>
                <div class="col-md-6 col-lg-3 mb-4 text-center">
                    <img src="{{ asset('staticImages/employee.jpg') }}" alt="Елена Смирнова" class="team-member-img mb-3">
                    <h5 class="fw-bold">Елена Смирнова</h5>
                    <p class="text-muted">Коммерческий директор</p>
                </div>
                <div class="col-md-6 col-lg-3 mb-4 text-center">
                    <img src="{{ asset('staticImages/employee2.jpg') }}" alt="Дмитрий Иванов" class="team-member-img mb-3">
                    <h5 class="fw-bold">Дмитрий Иванов</h5>
                    <p class="text-muted">Технический директор</p>
                </div>
                <div class="col-md-6 col-lg-3 mb-4 text-center">
                    <img src="{{ asset('staticImages/employee3.jpg') }}" alt="Ольга Козлова" class="team-member-img mb-3">
                    <h5 class="fw-bold">Ольга Козлова</h5>
                    <p class="text-muted">Директор по маркетингу</p>
                </div>
            </div>

            <!-- Achievements -->
            <div class="row mb-5 py-5 bg-light rounded">
                <div class="col-12 text-center mb-5">
                    <h2 class="fw-bold">Наши достижения</h2>
                    <p class="lead">Мы гордимся результатами нашей работы</p>
                </div>
                <div class="col-md-6 col-lg-3 mb-4 text-center">
                    <div class="feature-icon mx-auto">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="fw-bold">50,000+</h3>
                    <p>Довольных клиентов</p>
                </div>
                <div class="col-md-6 col-lg-3 mb-4 text-center">
                    <div class="feature-icon mx-auto">
                        <i class="fas fa-store"></i>
                    </div>
                    <h3 class="fw-bold">15</h3>
                    <p>Магазинов по России</p>
                </div>
                <div class="col-md-6 col-lg-3 mb-4 text-center">
                    <div class="feature-icon mx-auto">
                        <i class="fas fa-box"></i>
                    </div>
                    <h3 class="fw-bold">10,000+</h3>
                    <p>Товаров в ассортименте</p>
                </div>
                <div class="col-md-6 col-lg-3 mb-4 text-center">
                    <div class="feature-icon mx-auto">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="fw-bold">5</h3>
                    <p>Отраслевых наград</p>
                </div>
            </div>

            <!-- Store Locations -->
            <div class="row mb-5">
                <div class="col-12 text-center mb-5">
                    <h2 class="fw-bold">Наши магазины</h2>
                    <p class="lead">Посетите ближайший магазин ТехЦиф в вашем городе</p>
                </div>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card border-0 shadow h-100 store-card">
                        <img src="https://via.placeholder.com/400x200" class="card-img-top" alt="Магазин в Москве">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Москва</h5>
                            <p class="card-text">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i> ул. Технологическая, 42<br>
                                <i class="fas fa-phone text-primary me-2"></i> 8 (495) 123-45-67<br>
                                <i class="fas fa-clock text-primary me-2"></i> 10:00 - 22:00 ежедневно
                            </p>
                            <a href="#" class="btn btn-sm btn-primary">Подробнее</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card border-0 shadow h-100 store-card">
                        <img src="https://via.placeholder.com/400x200" class="card-img-top" alt="Магазин в Санкт-Петербурге">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Санкт-Петербург</h5>
                            <p class="card-text">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i> Невский пр-т, 128<br>
                                <i class="fas fa-phone text-primary me-2"></i> 8 (812) 765-43-21<br>
                                <i class="fas fa-clock text-primary me-2"></i> 10:00 - 22:00 ежедневно
                            </p>
                            <a href="#" class="btn btn-sm btn-primary">Подробнее</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card border-0 shadow h-100 store-card">
                        <img src="https://via.placeholder.com/400x200" class="card-img-top" alt="Магазин в Екатеринбурге">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Екатеринбург</h5>
                            <p class="card-text">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i> ул. Ленина, 56<br>
                                <i class="fas fa-phone text-primary me-2"></i> 8 (343) 987-65-43<br>
                                <i class="fas fa-clock text-primary me-2"></i> 10:00 - 22:00 ежедневно
                            </p>
                            <a href="#" class="btn btn-sm btn-primary">Подробнее</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-center mt-3">
                    <a href="#" class="btn btn-outline-primary">Все магазины</a>
                </div>
            </div>

            <!-- Partners -->

            <!-- CTA -->
            <div class="row py-5 bg-primary text-white rounded">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="fw-bold mb-4">Присоединяйтесь к нам!</h2>
                    <p class="lead mb-4">Станьте частью нашей истории успеха. Посетите ближайший магазин ТехЦиф или совершите покупку онлайн уже сегодня.</p>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="#" class="btn btn-light btn-lg">Каталог товаров</a>
                        <a href="#" class="btn btn-outline-light btn-lg">Контакты</a>
                    </div>
                </div>
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
                        <li class="mb-2"><a href="{{ route('about') }}" class="text-white text-decoration-none">О компании</a></li>
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
@endsection
@section('scripts')
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection