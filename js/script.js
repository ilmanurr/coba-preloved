// Toggle class active untuk hamburger menu
const isiNavbar = document.querySelector('.isinavbar');
// Ketika hamburger menu diklik
document.querySelector('#hamburger-menu').onclick = (e) => {
    isiNavbar.classList.toggle('active');
    e.preventDefault(); // Prevent page scroll when clicking the hamburger menu
};

// Toggle class active untuk search form
const searchForm = document.querySelector('.search-form');
const searchBox = document.querySelector('#search-box');
// Ketika search button diklik
document.querySelector('#search-button').onclick = (e) => {
    searchForm.classList.toggle('active');
    searchBox.focus();
    e.preventDefault();
};

// Toggle class active untuk login form
const loginForm = document.querySelector('.login-form');
// Ketika profil menu diklik
document.querySelector('#profil-menu').onclick = (e) => {
    loginForm.classList.toggle('active');
    loginForm.focus();
    e.preventDefault();
};

// Menutup navigasi jika diklik di luar navigasi
// Fungsi untuk menutup navigasi
function closeNavigation() {
    isiNavbar.classList.remove('active');
    searchForm.classList.remove('active');
    loginForm.classList.remove('active');
}

// Event listener untuk menutup navigasi saat klik di luar
document.addEventListener('DOMContentLoaded', () => {
    document.body.addEventListener('click', (e) => {
        if (!e.target.closest('.isinavbar') &&
            !e.target.closest('#hamburger-menu') &&
            !e.target.closest('.search-form') &&
            !e.target.closest('#search-button') &&
            !e.target.closest('.login-form') &&
            !e.target.closest('#profil-menu')) {
            closeNavigation();
        }
    });
});

// Modal Box
const itemDetailButtons = document.querySelectorAll('.detail-produk');

itemDetailButtons.forEach((btn, index) => {
    btn.onclick = (e) => {
        const itemDetailBoxes = document.querySelectorAll('.detail-box');
        if (itemDetailBoxes.length > index) {
            itemDetailBoxes[index].style.display = 'flex';
        }
        e.preventDefault();
    };
});

// Ketika diklik tombol close di modal box
document.querySelectorAll('.close-icon').forEach((closeIcon) => {
    closeIcon.onclick = (e) => {
        const itemDetailBoxes = document.querySelectorAll('.detail-box');
        itemDetailBoxes.forEach((box) => {
            box.style.display = 'none';
        });
        e.preventDefault();
    };
});

// Ketika klik di luar modal box
window.onclick = (e) => {
    const itemDetailBoxes = document.querySelectorAll('.detail-box');
    itemDetailBoxes.forEach((box) => {
        if (e.target === box) {
            box.style.display = 'none';
        }
    });
};

// detail image
document.addEventListener("DOMContentLoaded", function () {
    var slideIndex = 1; 

    var modals = document.querySelectorAll('.detail-box-container');
    
    modals.forEach(function (modal) {
        showSlides(slideIndex, modal);

        var prevBtn = modal.querySelector("#prevBtn");
        var nextBtn = modal.querySelector("#nextBtn");

        prevBtn.addEventListener("click", function () {
            plusSlides(-1, modal);
        });

        nextBtn.addEventListener("click", function () {
            plusSlides(1, modal);
        });
    });

    function plusSlides(n, modal) {
        showSlides((slideIndex += n), modal);
    }

    function showSlides(n, modal) {
        var i;
        var slides = modal.querySelectorAll('.slide-img');

        if (n > slides.length) {
            slideIndex = 1;
        }
        if (n < 1) {
            slideIndex = slides.length;
        }

        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = 'none';
        }

        slides[slideIndex - 1].style.display = 'flex';
    }
});

