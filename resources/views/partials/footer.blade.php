<footer class="footer mt-auto">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="logo-group" href="/">
            <div class="logo-circle-footer">
                <img src="{{ asset('storage/logo2.jpg') }}" alt="BKL Cinema Logo">
            </div>
        </a>
        <div class="social-icons">
            {{-- Thêm thẻ a và sự kiện onclick --}}
            <a href="javascript:void(0)" onclick="showComingSoon()" class="text-white mx-2"><i class="bi bi-facebook"></i></a>
            <a href="javascript:void(0)" onclick="showComingSoon()" class="text-white mx-2"><i class="bi bi-instagram"></i></a>
            <a href="javascript:void(0)" onclick="showComingSoon()" class="text-white mx-2"><i class="bi bi-tiktok"></i></a>
        </div>
    </div>
    <div id="comingSoonModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 99999; align-items: center; justify-content: center; backdrop-filter: blur(5px);">
    <div style="background: #DEFE98; padding: 40px; border-radius: 25px; text-align: center; box-shadow: 0 0 30px rgba(222, 254, 152, 0.5); border: 3px solid #000; max-width: 350px; position: relative;">
        <div style="font-size: 4rem; margin-bottom: 10px;">🤫</div>
        <h2 style="font-weight: 800; color: #000; margin-bottom: 10px;">COMING SOON</h2>
        <p style="color: #4b5563; font-weight: 500;">BKL Cinema is working hard on this feature. See you soon!</p>
        <button onclick="closeComingSoon()" style="background: #ff69b4; border: none; padding: 10px 30px; border-radius: 12px; color: white; font-weight: bold; margin-top: 15px; cursor: pointer;">OK CẬU ƠI</button>
    </div>
</div>

<script>
    function showComingSoon() {
        document.getElementById('comingSoonModal').style.display = 'flex';
    }
    function closeComingSoon() {
        document.getElementById('comingSoonModal').style.display = 'none';
    }
</script>
</footer>