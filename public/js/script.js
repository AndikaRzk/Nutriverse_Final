// Ambil semua elemen
const searchForm = document.querySelector(".search-form");
const shoppingCart = document.querySelector(".shopping-cart");
const loginForm = document.querySelector(".login-form");
const navbar = document.querySelector(".navbar");

// Tombol-tombol
const searchBtn = document.querySelector("#search-btn");
const cartBtn = document.querySelector("#cart-btn");
const loginBtn = document.querySelector("#login-btn");
const menuBtn = document.querySelector("#menu-btn");

// Toggle search form
if (searchBtn && searchForm) {
    searchBtn.onclick = () => {
        searchForm.classList.toggle("active");
        shoppingCart?.classList.remove("active");
        loginForm?.classList.remove("active");
        navbar?.classList.remove("active");
    };
}

// Toggle shopping cart
if (cartBtn && shoppingCart) {
    cartBtn.onclick = () => {
        shoppingCart.classList.toggle("active");
        searchForm?.classList.remove("active");
        loginForm?.classList.remove("active");
        navbar?.classList.remove("active");
    };
}

// Toggle login form
if (loginBtn && loginForm) {
    loginBtn.onclick = () => {
        loginForm.classList.toggle("active");
        searchForm?.classList.remove("active");
        shoppingCart?.classList.remove("active");
        navbar?.classList.remove("active");
    };
}

// Toggle navbar menu
if (menuBtn && navbar) {
    menuBtn.onclick = () => {
        navbar.classList.toggle("active");
        searchForm?.classList.remove("active");
        shoppingCart?.classList.remove("active");
        loginForm?.classList.remove("active");
    };
}

// Scroll event: sembunyikan semua panel
window.onscroll = () => {
    searchForm?.classList.remove("active");
    shoppingCart?.classList.remove("active");
    loginForm?.classList.remove("active");
    navbar?.classList.remove("active");
};

// Swiper untuk produk
const productSwiper = new Swiper(".product-slider", {
    loop: true,
    spaceBetween: 20,
    autoplay: {
        delay: 7500,
        disableOnInteraction: false,
    },
    centeredSlides: true,
    breakpoints: {
        0: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 2,
        },
        1020: {
            slidesPerView: 3,
        },
    },
});

// Swiper untuk review
// const reviewSwiper = new Swiper(".review-slider", {
//     loop: true,
//     spaceBetween: 20,
//     autoplay: {
//         delay: 7500,
//         disableOnInteraction: false,
//     },
//     centeredSlides: true,
//     breakpoints: {
//         0: {
//             slidesPerView: 1,
//         },
//         768: {
//             slidesPerView: 2,
//         },
//         1020: {
//             slidesPerView: 3,
//         },
//     },
// });
