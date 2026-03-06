@extends('layouts.app')

@section('content')
{{-- Thư viện icon Bootstrap --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    /* 1. TOAST NOTIFICATION (GIỮ NGUYÊN) */
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10000;
        display: flex;
        flex-direction: column;
        gap: 12px;
        pointer-events: none;
    }

    .custom-toast {
        pointer-events: auto;
        background: #1e293b;
        color: white;
        padding: 16px 20px;
        border-radius: 12px;
        min-width: 320px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        animation: slideInRight 0.4s ease forwards;
    }

    .progress-bar-toast {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 4px;
        background: #DEFE98;
        width: 100%;
        animation: progress 3s linear forwards;
    }

    .close-toast {
        background: none; border: none; color: #94a3b8;
        font-size: 1.2rem; cursor: pointer; transition: 0.3s;
        outline: none !important; box-shadow: none !important;
    }
    .close-toast:hover { color: #ff69b4; transform: scale(1.2); }

    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(100%); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes progress { from { width: 100%; } to { width: 0%; } }

    /* 2. MAIN INTERFACE COLOR DEFE98 */
    .login-wrapper {
        height: calc(100vh - 80px); 
        display: flex; align-items: center; justify-content: center; padding: 20px;
    }

    .login-card {
        background: #DEFE98; 
        border: 1px solid rgba(0, 0, 0, 0.1); 
        border-radius: 28px;
        padding: 40px 30px; 
        width: 100%; 
        max-width: 400px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .logo-container { display: flex; justify-content: center; margin-bottom: 25px; }
    .logo-circle-large {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: #000;          /* màu nền hình tròn */
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }
    .logo-circle-large img {
    width: 100%;
    height: 100%;
    border-radius: 50%;        /* đảm bảo ảnh cũng tròn */
    object-fit: cover; 
}

    .floating-group { position: relative; margin-bottom: 20px; }
    .floating-group input {
        width: 100%; height: 55px; 
        background: rgba(255, 255, 255, 0.8) !important;
        border: 1px solid rgba(0, 0, 0, 0.1) !important; 
        border-radius: 12px;
        padding: 15px 45px 5px 15px; 
        color: #000 !important; 
        outline: none;
        transition: 0.3s ease;
    }

    .floating-group input:focus {
        border-color: #ff69b4 !important;
        box-shadow: 0 0 0 4px rgba(255, 105, 180, 0.2) !important;
    }

    .floating-group label {
        position: absolute; top: 50%; left: 15px; transform: translateY(-50%);
        color: #4b5563; transition: all 0.3s ease; pointer-events: none;
    }
    .floating-group input:focus ~ label, .floating-group input:not(:placeholder-shown) ~ label {
        top: 12px; font-size: 0.75rem; color: #ff69b4; font-weight: bold;
    }

    .form-check-input:checked { background-color: #ff69b4; border-color: #ff69b4; }
    
    .btn-login {
        background: #ff69b4;
        border: none; height: 52px; border-radius: 12px;
        font-weight: bold; transition: 0.3s; color: white; margin-top: 10px;
        box-shadow: 0 4px 15px rgba(255, 105, 180, 0.4);
    }
    .btn-login:hover, .btn-login:focus {
        background: #ff47a1;
        transform: translateY(-2px);
        outline: none;
    }

    .signup-text { margin-top: 25px; text-align: center; color: #1f2937; font-size: 0.9rem; }
    
    .signup-text a { 
        color: #000; 
        text-decoration: none; 
        font-weight: bold; 
        transition: all 0.3s ease;
        display: inline-block;
        border-radius: 0;
        padding: 0;
    }

    .signup-text a:hover, .signup-text a:focus { 
        color: #ff69b4 !important; 
        background-color: transparent !important;
        transform: scale(1.1);
        outline: none;
        text-decoration: underline;
    }
    
    .forgot-link { color: #4b5563; text-decoration: none; transition: 0.3s; cursor: pointer; }
    .forgot-link:hover, .forgot-link:focus { color: #ff69b4; outline: none; }

    /* CSS CHO MODAL COMING SOON */
    #comingSoonModal {
        display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
        background: rgba(0,0,0,0.7); z-index: 99999; align-items: center; justify-content: center; 
        backdrop-filter: blur(5px);
    }
    .modal-content-custom {
        background: #DEFE98; padding: 40px; border-radius: 25px; text-align: center; 
        box-shadow: 0 0 30px rgba(222, 254, 152, 0.5); border: 3px solid #000; 
        max-width: 350px; position: relative; animation: zoomIn 0.3s ease;
    }
    @keyframes zoomIn {
        from { transform: scale(0.5); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
</style>

<div class="toast-container">
    {{-- HIỂN THỊ LỖI --}}
    @if ($errors->any())
    <div class="custom-toast common-toast" id="loginAlert" style="border-left: 5px solid #ff3131;">
        <div class="toast-content">
            <i class="bi bi-exclamation-circle-fill" style="color: #ff3131;"></i>
            <span>{{ $errors->first() }}</span>
        </div>
        <button class="close-toast" onclick="closeToast('loginAlert')">✕</button>
        <div class="progress-bar-toast" style="background: #ff3131;"></div>
    </div>
    @endif

    {{-- HIỂN THỊ THÀNH CÔNG --}}
    @if (session('success'))
    <div class="custom-toast common-toast" id="successAlert" style="border-left: 5px solid #DEFE98;">
        <div class="toast-content">
            <i class="bi bi-check-circle-fill" style="color: #DEFE98;"></i>
            <span>{{ session('success') }}</span>
        </div>
        <button class="close-toast" onclick="closeToast('successAlert')">✕</button>
        <div class="progress-bar-toast"></div>
    </div>
    @endif
</div>

<div class="login-wrapper">
    <div class="login-card">
        <div class="logo-container">
            <a href="/" class="logo-circle-large">
                <img src="{{ asset('storage/logo2.jpg') }}" alt="Logo">
            </a>
        </div>

        <form method="POST" action="/login">
            @csrf
            <div class="floating-group">
                <input type="text" name="login_field" id="login_field" placeholder=" " value="{{ old('login_field') }}" required autocomplete="off">
                <label for="login_field">Email/Phone Number</label>
            </div>

            <div class="floating-group">
                <input type="password" name="password" id="password" placeholder=" " required>
                <label for="password">Password</label>
                <i class="bi bi-eye position-absolute" id="togglePassword" style="right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #4b5563;"></i>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check d-flex align-items-center gap-2">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label style="color: #1f2937;" for="remember">Remember me</label>
                </div>
                {{-- EDIT FORGOT PASSWORD LINK HERE --}}
                <a href="javascript:void(0)" class="small forgot-link" onclick="showComingSoon()">Forgot Password?</a>
            </div>

            <button type="submit" class="btn btn-login w-100 shadow">LOGIN NOW</button>
        </form>

        <div class="signup-text">
            Don't have an account? <a href="/register">Sign up now</a>
        </div>
    </div>
</div>

{{-- MODAL COMING SOON --}}
<div id="comingSoonModal">
    <div class="modal-content-custom">
        <div style="font-size: 4rem; margin-bottom: 10px;">🤫</div>
        <h2 style="font-family: 'Permanent Marker', cursive; color: #000; margin-bottom: 10px;">COMING SOON</h2>
        <p style="color: #4b5563; font-weight: 500;">This feature is currently being developed by us. Check back later!</p>
        <button onclick="closeComingSoon()" style="background: #ff69b4; border: none; padding: 10px 30px; border-radius: 12px; color: white; font-weight: bold; margin-top: 15px; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 10px rgba(255, 105, 180, 0.3);">OK CẬU ƠI</button>
    </div>
</div>

<script>
    // LOGIC CHO COMING SOON
    function showComingSoon() {
        document.getElementById('comingSoonModal').style.display = 'flex';
    }

    function closeComingSoon() {
        document.getElementById('comingSoonModal').style.display = 'none';
    }

    // LOGIC CŨ CỦA CẬU
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
    });

    function closeToast(id) {
        const alert = document.getElementById(id);
        if (alert) {
            alert.style.transform = "translateX(120%)";
            alert.style.opacity = "0";
            alert.style.transition = "0.4s ease";
            setTimeout(() => alert.remove(), 400);
        }
    }

    document.querySelectorAll('.common-toast').forEach(toast => {
        setTimeout(() => {
            if(document.getElementById(toast.id)) closeToast(toast.id);
        }, 3000);
    });
</script>
@endsection