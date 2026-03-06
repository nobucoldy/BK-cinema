/* =====================
   GLOBAL FUNCTIONS
===================== */

let currentZoom = 1;

function zoomGrid(step) {
    currentZoom = Math.min(Math.max(currentZoom + step, 0.6), 1.3);
    const area = document.getElementById('main-booking-area');
    if (area) area.style.transform = `scale(${currentZoom})`;
}

function removeToast(el) {
    if (!el) return;
    el.style.animation = "slideOut 0.4s ease-in forwards";
    setTimeout(() => el.remove(), 400);
}

function createToast(msg) {
    const wrapper = document.getElementById('toast-wrapper');
    if (!wrapper) return;

    const toast = document.createElement('div');
    toast.className = 'custom-toast';
    toast.innerHTML = `
        <div style="display:flex;align-items:center;gap:10px">
            <i class="bi bi-exclamation-circle-fill" style="color:#ff3131"></i>
            <span style="font-size:0.9rem">${msg}</span>
        </div>
        <button class="close-btn" onclick="removeToast(this.parentElement)">&times;</button>
        <div class="toast-progress"></div>
    `;
    wrapper.appendChild(toast);
    setTimeout(() => removeToast(toast), 3000);
}

function togglePayTab(type) {
    const qrBtn = document.getElementById('tab-qr-btn');
    const appBtn = document.getElementById('tab-app-btn');
    const viewQr = document.getElementById('view-qr');
    const viewApp = document.getElementById('view-app');

    if (type === 'qr') {
        qrBtn.classList.add('active');
        appBtn.classList.remove('active');
        viewQr.classList.remove('d-none');
        viewApp.classList.add('d-none');
    } else {
        appBtn.classList.add('active');
        qrBtn.classList.remove('active');
        viewApp.classList.remove('d-none');
        viewQr.classList.add('d-none');
    }
}

function goBackToCombo() {
    const payModal = bootstrap.Modal.getInstance(
        document.getElementById('paymentModal')
    );
    if (payModal) payModal.hide();

    setTimeout(() => {
        new bootstrap.Modal(document.getElementById('comboModal')).show();
    }, 300);
}

/* =====================
   MAIN LOGIC
===================== */

document.addEventListener('DOMContentLoaded', () => {

    const { showtimeId, bookingStoreUrl, soldSeatCodes = [] } = window.bookingConfig;

    let selectedSeats = [];
    let selectedCombos = {};

    const fmt = n => new Intl.NumberFormat('vi-VN').format(n) + 'đ';

    /* ===== SEAT SOLD SAFETY ===== */
    soldSeatCodes.forEach(code => {
        const el = document.querySelector(`[data-name="${code}"]`);
        if (el) el.classList.add('seat-sold');
    });

    /* ===== SEAT SELECTION ===== */
    document.querySelectorAll('.seat:not(.seat-sold)').forEach(seat => {
        seat.addEventListener('click', () => {
            const id = parseInt(seat.dataset.id);
            const name = seat.dataset.name;
            const price = parseInt(seat.dataset.price);

            if (!seat.classList.contains('seat-selected')) {
                if (selectedSeats.length >= 8) {
                    createToast("You can select a maximum of 8 seats!");
                    return;
                }
                seat.classList.add('seat-selected');
                selectedSeats.push({ id, name, price });
            } else {
                seat.classList.remove('seat-selected');
                selectedSeats = selectedSeats.filter(s => s.id !== id);
            }

            updateSeatUI();
        });
    });

    function updateSeatUI() {
        const total = selectedSeats.reduce((s, x) => s + x.price, 0);
        document.getElementById('seat-counter').innerText =
            `Selected ${selectedSeats.length} seats:`;
        document.getElementById('display-seats').innerText =
            selectedSeats.map(s => s.name).join(', ') || '-';
        document.getElementById('display-total-tickets').innerText = fmt(total);
    }

    document.getElementById('next-button').onclick = () => {
        if (!selectedSeats.length) {
            createToast("Please select at least one seat!");
            return;
        }
        new bootstrap.Modal(document.getElementById('comboModal')).show();
    };

    /* ===== COMBO LOGIC ===== */
    document.querySelectorAll('.btn-qty-vnpay').forEach(btn => {
        btn.addEventListener('click', () => {
            const card = btn.closest('.combo-modal-item');
            const name = card.dataset.name;
            const price = parseInt(card.dataset.price);
            const qtyEl = card.querySelector('.qty');

            let qty = parseInt(qtyEl.innerText);
            qty = btn.classList.contains('plus') ? qty + 1 : Math.max(0, qty - 1);

            qtyEl.innerText = qty;
            selectedCombos[name] = { qty, price };

            let comboTotal = 0;
            Object.values(selectedCombos).forEach(c => {
                comboTotal += c.qty * c.price;
            });

            document.getElementById('modal-combo-total').innerText = fmt(comboTotal);
        });
    });

    /* ===== MOVE TO PAYMENT ===== */
    document.getElementById('btn-to-payment').onclick = () => {
        const ticketTotal = selectedSeats.reduce((s, x) => s + x.price, 0);

        // Seats summary
        document.getElementById('final-seats-list').innerHTML =
            selectedSeats.map(s =>
                `<div class="summary-item">
                    <span class="summary-label">${s.name}</span>
                    <span class="summary-value">${fmt(s.price)}</span>
                </div>`).join('');

        // Combos summary
        let comboHtml = '';
        let comboTotal = 0;

        Object.entries(selectedCombos).forEach(([name, c]) => {
            if (c.qty > 0) {
                const sum = c.qty * c.price;
                comboTotal += sum;
                comboHtml += `
                    <div class="summary-item">
                        <span class="summary-label">${name} x${c.qty}</span>
                        <span class="summary-value">${fmt(sum)}</span>
                    </div>`;
            }
        });

        document.getElementById('final-combos-list').innerHTML =
            comboHtml || '<div class="text-muted small">No combo selected</div>';

        const finalTotal = ticketTotal + comboTotal;
        document.getElementById('final-total-all').innerText = fmt(finalTotal);

        document.getElementById('qr-image').src =
            `https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=BKL-${finalTotal}`;

        bootstrap.Modal.getInstance(document.getElementById('comboModal')).hide();
        new bootstrap.Modal(document.getElementById('paymentModal')).show();
    };

    /* ===== FINAL CONFIRM & SAVE BOOKING ===== */
    window.simulateFinalSuccess = async function () {
        try {
            const res = await fetch(bookingStoreUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    showtime_id: showtimeId,
                    seat_ids: selectedSeats.map(s => s.id)
                })
            });

            const data = await res.json();

            if (!data.success) {
                createToast("Booking failed!");
                return;
            }

            bootstrap.Modal.getInstance(document.getElementById('paymentModal')).hide();

            setTimeout(() => {
                document.getElementById('successModalOverlay').style.display = 'flex';
            }, 300);

        } catch (e) {
            createToast("Server error!");
        }
    };

});
