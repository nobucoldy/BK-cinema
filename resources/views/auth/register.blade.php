@extends('layouts.app')

@section('content')
{{-- Thư viện icon Bootstrap --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    /* 1. XỬ LÝ AUTOFILL VÀ MÀU SẮC CHỦ ĐẠO */
    input:-webkit-autofill, input:-webkit-autofill:hover, input:-webkit-autofill:focus {
        -webkit-text-fill-color: #000 !important;
        -webkit-box-shadow: 0 0 0px 1000px #fff inset !important;
        transition: background-color 5000s ease-in-out 0s;
    }
    .register-wrapper { 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        width: 100%; 
        padding: 40px 20px; 
        min-height: 80vh; 
    }
    
    /* KHUNG ĐĂNG KÝ MÀU DEFE98 */
    .register-card { 
        background: #DEFE98; 
        border: 1px solid rgba(0, 0, 0, 0.1); 
        border-radius: 28px; 
        padding: 40px 30px; 
        width: 100%; 
        max-width: 420px; 
        box-shadow: 0 20px 40px rgba(0,0,0,0.15); 
    }
    
    /* CĂN GIỮ LOGO */
    .logo-circle-large { 
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: #000;
        display: flex; /* Để căn giữa ảnh bên trong */
        align-items: center;
        justify-content: center;
        margin: 0 auto 30px auto; /* auto ở trái/phải để đẩy vào giữa */
        text-decoration: none;
        overflow: hidden;
    }

    .logo-circle-large img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .floating-group { position: relative; margin-bottom: 20px; }
    .floating-group input { 
        width: 100%; 
        height: 55px; 
        background: rgba(255, 255, 255, 0.8) !important; 
        border: 1px solid rgba(0, 0, 0, 0.2) !important; 
        border-radius: 12px; 
        padding: 15px 45px 5px 15px; 
        color: #000 !important; 
        outline: none; 
        transition: 0.3s ease;
    }

    /* FOCUS EFFECT */
    .floating-group input:focus {
        border-color: #ff69b4 !important;
        box-shadow: 0 0 0 4px rgba(255, 105, 180, 0.2) !important;
    }

    .floating-group label { 
        position: absolute; 
        top: 50%; 
        left: 15px; 
        transform: translateY(-50%); 
        color: #4b5563; 
        transition: 0.3s; 
        pointer-events: none; 
    }
    
    .floating-group input:focus ~ label, 
    .floating-group input:not(:placeholder-shown) ~ label { 
        top: 12px; 
        font-size: 0.75rem; 
        color: #ff69b4; 
        font-weight: bold; 
    }
    
    .eye-toggle { 
        position: absolute; 
        right: 15px; 
        top: 50%; 
        transform: translateY(-50%); 
        cursor: pointer; 
        color: #4b5563; 
        font-size: 1.2rem; 
        z-index: 10; 
    }

    /* NÚT ĐĂNG KÝ */
    .btn-register { 
        background: #ff69b4; 
        border: none; 
        height: 52px; 
        border-radius: 12px; 
        font-weight: 600; 
        color: white; 
        margin-top: 10px; 
        width: 100%; 
        cursor: pointer; 
        transition: 0.3s ease; 
        box-shadow: 0 4px 15px rgba(255, 105, 180, 0.4);
        text-transform: uppercase;
    }
    .btn-register:hover { background: #ff47a1; transform: translateY(-2px); }

    .footer-text { margin-top: 25px; text-align: center; color: #1f2937; font-size: 0.95rem; }
    .footer-text a { 
        color: #000; 
        text-decoration: none; 
        font-weight: bold; 
        transition: 0.3s;
    }
    .footer-text a:hover { color: #ff69b4; text-decoration: underline; }

    /* TOAST & CHECKLIST */
    .toast-container { position: fixed; top: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 12px; }
    .custom-toast { background: #1e293b; color: white; padding: 15px 20px; border-radius: 12px; min-width: 300px; border-left: 5px solid #ff3131; animation: slideIn 0.4s ease-out; position: relative; }
    
    .checklist-box {
        max-height: 0; overflow: hidden; background: rgba(255, 255, 255, 0.5);
        padding: 0 15px; border-radius: 12px; transition: all 0.4s ease; margin-bottom: 0;
    }
    .checklist-box.active { max-height: 250px; padding: 15px; margin-bottom: 20px; border: 1px solid rgba(255, 105, 180, 0.3); }
    .checklist-box ul { padding: 0; margin: 0; }
    .checklist-box li { font-size: 0.75rem; margin-bottom: 5px; display: flex; align-items: center; gap: 8px; list-style: none; }
    .invalid { color: #dc2626; } 
    .valid { color: #059669; }

    @keyframes slideIn { from { transform: translateX(120%); } to { transform: translateX(0); } }
    @keyframes slideOut { from { transform: translateX(0); opacity: 1; } to { transform: translateX(120%); opacity: 0; } }
</style>

<div class="toast-container">
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="custom-toast">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="bi bi-exclamation-circle-fill" style="color: #ff3131;"></i>
                    <span style="font-size: 0.9rem;">{{ $error }}</span>
                </div>
                <button type="button" style="background:none; border:none; color:white; float:right;" onclick="this.parentElement.remove()">&times;</button>
            </div>
        @endforeach
    @endif
</div>

<div class="register-wrapper">
    <div class="register-card">
        {{-- LOGO ALREADY CENTERED --}}
        <a href="/" class="logo-circle-large">
            <img src="{{ asset('storage/logo2.jpg') }}" alt="Logo">
        </a>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="floating-group">
                <input type="text" name="name" id="name" placeholder=" " value="{{ old('name') }}" required>
                <label for="name">Full Name</label>
            </div>

            <div class="floating-group">
                <input type="email" name="email" id="email" placeholder=" " value="{{ old('email') }}" required>
                <label for="email">Email Address</label>
            </div>

            <div class="floating-group">
                <input type="text" name="phone" id="phone" placeholder=" " value="{{ old('phone') }}" required maxlength="10">
                <label for="phone">Phone Number</label>
            </div>

            <div id="phone_info" class="checklist-box">
                <ul>
                    <li id="p_start" class="invalid"><i class="bi bi-x-lg"></i> Valid Vietnam prefix (03, 05, 07, 08, 09)</li>
                    <li id="p_length" class="invalid"><i class="bi bi-x-lg"></i> Exactly 10 digits</li>
                    <li id="p_number" class="invalid"><i class="bi bi-x-lg"></i> Only contains numbers</li>
                </ul>
            </div>

            <div class="floating-group">
                <input type="password" name="password" id="password" placeholder=" " required>
                <label for="password">Password</label>
                <i class="bi bi-eye eye-toggle" onclick="togglePass('password', this)"></i>
            </div>

            <div id="pswd_info" class="checklist-box">
                <ul>
                    <li id="length" class="invalid"><i class="bi bi-x-lg"></i> At least 8 characters</li>
                    <li id="letter" class="invalid"><i class="bi bi-x-lg"></i> Contains letters</li>
                    <li id="number" class="invalid"><i class="bi bi-x-lg"></i> Contains numbers</li>
                    <li id="special" class="invalid"><i class="bi bi-x-lg"></i> Special characters (@, $, !...)</li>
                    <li id="space" class="valid"><i class="bi bi-check-lg"></i> No spaces</li>
                </ul>
            </div>

            <div class="floating-group">
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder=" " required>
                <label for="password_confirmation">Confirm Password</label>
                <i class="bi bi-eye eye-toggle" onclick="togglePass('password_confirmation', this)"></i>
            </div>
            
            <button type="submit" class="btn-register">SIGN UP NOW</button>
            
            <div class="footer-text">
                Already have an account? <a href="{{ route('login') }}">Login now</a>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePass(id, icon) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
        icon.classList.toggle('bi-eye'); icon.classList.toggle('bi-eye-slash');
    }

    // Logic xử lý Phone & Password giữ nguyên như cũ
    const phone = document.getElementById('phone');
    const phone_info = document.getElementById('phone_info');
    phone.addEventListener('focus', () => phone_info.classList.add('active'));
    phone.addEventListener('blur', () => phone_info.classList.remove('active'));
    phone.addEventListener('input', function() {
        const val = this.value;
        validateItem('p_start', /^(03|05|07|08|09)/.test(val));
        validateItem('p_length', val.length === 10);
        validateItem('p_number', /^[0-9]+$/.test(val) && val.length > 0);
    });

    const pswd = document.getElementById('password');
    const pswd_info = document.getElementById('pswd_info');
    pswd.addEventListener('focus', () => pswd_info.classList.add('active'));
    pswd.addEventListener('blur', () => pswd_info.classList.remove('active'));
    pswd.addEventListener('keyup', function() {
        const val = this.value;
        validateItem('length', val.length >= 8);
        validateItem('letter', /[a-zA-Z]/.test(val));
        validateItem('number', /[0-9]/.test(val));
        validateItem('special', /[@\-\.,$!%*?#]/.test(val));
        validateItem('space', !/\s/.test(val) && val.length > 0);
    });

    function validateItem(id, isValid) {
        const el = document.getElementById(id); 
        if(!el) return;
        const icon = el.querySelector('i');
        if (isValid) { 
            el.classList.replace('invalid', 'valid'); 
            icon.classList.replace('bi-x-lg', 'bi-check-lg'); 
        } else { 
            el.classList.replace('valid', 'invalid'); 
            icon.classList.replace('bi-check-lg', 'bi-x-lg'); 
        }
    }
</script>
@endsection