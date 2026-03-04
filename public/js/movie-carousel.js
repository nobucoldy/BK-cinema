// ==================================================
// 1. PHIM ĐANG CHIẾU (NOW SHOWING) – FIX FOCUS
// ==================================================
new Swiper(".now-showing-swiper", {
    slidesPerView: "auto",
    centeredSlides: true,
    spaceBetween: 25,
    loop: true,
    watchSlidesProgress: true,

    pagination: {
        el: ".now-showing-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".main-next",
        prevEl: ".main-prev",
    },
});



// ==================================================
// 2. PHIM SẮP CHIẾU (UPCOMING) – FIX FOCUS
// ==================================================
new Swiper(".upcoming-swiper", {
    slidesPerView: "auto",
    centeredSlides: true,
    spaceBetween: 25,
    loop: true,
    watchSlidesProgress: true,

    pagination: {
        el: ".upcoming-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".upcoming-next",
        prevEl: ".upcoming-prev",
    },
});




// ==================================================
// 3. HERO BANNER – GIỮ NGUYÊN
// ==================================================
const heroSwiper = new Swiper(".heroSwiper", {
    loop: true,
    speed: 1000,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".heroSwiper .swiper-pagination",
        clickable: true,
    },
    observer: true,
    observeParents: true,
});

// Điều hướng Hero
document.querySelector('.nav-prev')?.addEventListener('click', () => heroSwiper.slidePrev());
document.querySelector('.nav-next')?.addEventListener('click', () => heroSwiper.slideNext());
document.addEventListener('DOMContentLoaded', function() {
    // --- 1. Cấu hình Banner Hero ---
    const heroSwiper = new Swiper(".heroSwiper", {
        loop: true,
        speed: 1000,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: { 
            el: ".heroSwiper .swiper-pagination", 
            clickable: true 
        },
    });

    // Điều hướng Banner Hero bằng vùng click trái/phải
    document.querySelector('.nav-prev')?.addEventListener('click', () => heroSwiper.slidePrev());
    document.querySelector('.nav-next')?.addEventListener('click', () => heroSwiper.slideNext());

    // --- 2. Cấu hình chung cho các danh sách phim ---
    const commonConfig = {
        slidesPerView: 4,
        spaceBetween: 20,
        loop: true,
        watchSlidesProgress: true, // Giúp hiệu ứng hover mượt hơn
        breakpoints: { 
            1024: { slidesPerView: 4 }, 
            768: { slidesPerView: 3 }, 
            0: { slidesPerView: 1.5 } 
        }
    };

    // --- 3. Khởi tạo Now Showing ---
    new Swiper(".mySwiper", {
        ...commonConfig,
        pagination: { 
            el: ".mySwiper .swiper-pagination", 
            clickable: true 
        },
        navigation: { 
            nextEl: ".main-next", 
            prevEl: ".main-prev" 
        },
    });

    // --- 4. Khởi tạo Coming Soon (ĐÃ FIX ĐẦY ĐỦ NÚT BẤM) ---
    new Swiper(".mySwiperUpcoming", {
        ...commonConfig,
        pagination: { 
            el: ".mySwiperUpcoming .swiper-pagination", 
            clickable: true 
        },
        navigation: { 
            nextEl: ".upcoming-next", 
            prevEl: ".upcoming-prev" 
        },
    });

    // --- 5. Search Theater (Lọc rạp tại chỗ) ---
    const searchInput = document.getElementById('theaterSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            let term = e.target.value.toLowerCase().trim();
            let theaterItems = document.querySelectorAll('.theater-item');

            theaterItems.forEach(item => {
                let theaterName = item.innerText.toLowerCase();
                if (theaterName.includes(term)) {
                    item.style.setProperty('display', 'flex', 'important');
                } else {
                    item.style.setProperty('display', 'none', 'important');
                }
            });
        });
    }

    // --- 6. AJAX Schedule (Tải lịch chiếu không load lại trang) ---
    const scheduleCard = document.querySelector('.schedule-card');
    if (scheduleCard) {
        scheduleCard.addEventListener('click', function(e) {
            const target = e.target.closest('.theater-item, .date-btn');
            if (target) {
                e.preventDefault();
                const url = target.getAttribute('href');
                const contentArea = document.getElementById('schedule-content');
                const sidebarArea = document.querySelector('.theater-list');
                
                contentArea.style.opacity = '0.5';

                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(res => res.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        
                        // Cập nhật vùng nội dung phim
                        const newContent = doc.getElementById('schedule-content');
                        if(newContent) contentArea.innerHTML = newContent.innerHTML;
                        
                        // Cập nhật lại sidebar để giữ trạng thái active
                        const newSidebar = doc.querySelector('.theater-list');
                        if(newSidebar) sidebarArea.innerHTML = newSidebar.innerHTML;
                        
                        contentArea.style.opacity = '1';
                        window.history.pushState({}, '', url);
                    })
                    .catch(err => console.error("Lỗi tải lịch chiếu:", err));
            }
        });
    }
});

// Hàm đóng thông báo Toast
function closeHomeToast() {
    const toast = document.getElementById('successToast');
    if (toast) {
        toast.style.transform = "translateX(120%)";
        toast.style.opacity = "0";
        setTimeout(() => toast.remove(), 400);
    }
}