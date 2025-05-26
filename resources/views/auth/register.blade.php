@extends('layouts.app')

@section('title', 'Регистрация - ТехЦиф')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white text-center">
                    <h4 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i>Регистрация
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Полное имя</label>
                            <input id="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   type="text" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autofocus 
                                   autocomplete="name"
                                   placeholder="Введите ваше полное имя">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email адрес</label>
                            <input id="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autocomplete="username"
                                   placeholder="Введите ваш email">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <div class="input-group">
                                <input id="password" 
                                       class="form-control @error('password') is-invalid @enderror"
                                       type="password"
                                       name="password"
                                       required 
                                       autocomplete="new-password"
                                       placeholder="Создайте надежный пароль">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                            <div class="form-text">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Пароль должен содержать минимум 8 символов
                                </small>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                            <div class="input-group">
                                <input id="password_confirmation" 
                                       class="form-control @error('password_confirmation') is-invalid @enderror"
                                       type="password"
                                       name="password_confirmation" 
                                       required 
                                       autocomplete="new-password"
                                       placeholder="Повторите пароль">
                                <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                    <i class="fas fa-eye" id="togglePasswordConfirmIcon"></i>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mb-3 form-check">
                            <input id="terms" 
                                   type="checkbox" 
                                   class="form-check-input" 
                                   name="terms"
                                   required>
                            <label class="form-check-label" for="terms">
                                Я согласен с <a href="#" class="text-decoration-none">условиями использования</a> и <a href="#" class="text-decoration-none">политикой конфиденциальности</a>
                            </label>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-user-plus me-2"></i>Зарегистрироваться
                            </button>
                        </div>

                        <div class="text-center">
                            <span class="text-muted">Уже есть аккаунт?</span>
                            <a class="text-decoration-none ms-1" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Войти
                            </a>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center text-muted">
                    <small>
                        <i class="fas fa-shield-alt me-1"></i>
                        Регистрируясь, вы получаете доступ к персональным скидкам и быстрому оформлению заказов
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePasswordIcon');
        
        const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
        const passwordConfirmInput = document.getElementById('password_confirmation');
        const toggleConfirmIcon = document.getElementById('togglePasswordConfirmIcon');
        
        // Password field toggle
        if (togglePassword) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                if (type === 'password') {
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                } else {
                    toggleIcon.classList.remove('fa-eye');
                    toggleIcon.classList.add('fa-eye-slash');
                }
            });
        }
        
        // Password confirmation field toggle
        if (togglePasswordConfirm) {
            togglePasswordConfirm.addEventListener('click', function() {
                const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirmInput.setAttribute('type', type);
                
                if (type === 'password') {
                    toggleConfirmIcon.classList.remove('fa-eye-slash');
                    toggleConfirmIcon.classList.add('fa-eye');
                } else {
                    toggleConfirmIcon.classList.remove('fa-eye');
                    toggleConfirmIcon.classList.add('fa-eye-slash');
                }
            });
        }
        
        // Password strength indicator
        const passwordField = document.getElementById('password');
        const confirmField = document.getElementById('password_confirmation');
        
        if (passwordField) {
            passwordField.addEventListener('input', function() {
                const password = this.value;
                const strength = getPasswordStrength(password);
                updatePasswordStrength(strength);
            });
        }
        
        // Password confirmation validation
        if (confirmField) {
            confirmField.addEventListener('input', function() {
                const password = passwordField.value;
                const confirm = this.value;
                
                if (confirm && password !== confirm) {
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else if (confirm) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            });
        }
        
        function getPasswordStrength(password) {
            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            return strength;
        }
        
        function updatePasswordStrength(strength) {
            // You can add a password strength indicator here if needed
        }
        
        // Auto-focus on name field
        const nameInput = document.getElementById('name');
        if (nameInput && !nameInput.value) {
            nameInput.focus();
        }
    });
</script>
@endsection
