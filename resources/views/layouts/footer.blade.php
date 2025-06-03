{{-- <!-- Footer Section -->
<footer class="custom-footer bg-dark text-white pt-5">
    <div class="container">
        <div class="row g-4">
            <!-- Company Info -->
            <div class="col-lg-4 col-md-6">
                <div class="footer-brand mb-4">
                    <h2 class="text-gradient">🍏 NutriVerse</h2>
                    <p class="mt-3 text-white">
                        Your Ultimate Guide to a Healthier Life
                    </p>
                </div>
                <div class="social-links">
                    <h5 class="mb-3">Follow Us:</h5>
                    <div class="d-flex gap-3">
                        <a href="#" class="social-icon">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="bi bi-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6">
                <h5 class="mb-4">Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="#" class="footer-link">About Us</a>
                    </li>
                    <li class="mb-2"><a href="#" class="footer-link">Blog</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Nutrition Tips</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Privacy Policy</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Terms & Conditions</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3 col-md-6">
                <h5 class="mb-4">Contact Us</h5>
                <ul class="list-unstyled">
                    <li class="mb-3">
                        <i class="bi bi-geo-alt-fill me-2"></i>
                        456 Wellness Street, Jakarta
                    </li>
                    <li class="mb-3">
                        <i class="bi bi-telephone-fill me-2"></i>
                        +62 21 9876 5432
                    </li>
                    <li class="mb-3">
                        <i class="bi bi-envelope-fill me-2"></i>
                        support@nutriverse.id
                    </li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="col-lg-3 col-md-6">
                <h5 class="mb-4">Subscribe to Our Newsletter</h5>
                <p class="text-white">Get the latest health tips & exclusive offers!</p>
                <div class="input-group mb-3">
                    <input type="email" class="form-control2" placeholder="Enter your email" />
                    <button class="btn btn-primary2">
                        <i class="bi bi-send"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-top mt-5 pt-4 text-center">
            <p class="mb-0 text-white">
                &copy; 2024 NutriVerse. All rights reserved.
            </p>
        </div>
    </div>
</footer> --}}

<!-- footer  -->
<footer>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <section class="footer">
        <div class="box-container">
            <div class="box">
                <h3>nutriverse <i class="fas fa-shopping-basket"></i></h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Odit, ipsa!</p>
                <div class="share">
                    <a href="#" class="fab fa-facebook-f"></a>
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-instagram"></a>
                    <a href="#" class="fab fa-linkedin"></a>
                </div>
            </div>



            <div class="box">
                <h3>contact info</h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Odit, ipsa!</p>
                <a href="#" class="links"> <i class="fas fa-phone"></i> +123-456-7890</a>
                <a href="#" class="links"> <i class="fas fa-phone"></i> +111-222-3333</a>
                <a href="#" class="links"> <i class="fas fa-envelope"></i> nutriadmin@gmail.com</a>
                <a href="#" class="links"> <i class="fas fa-map-market-alt"></i> Denpasar, Bali - 400104</a>
            </div>

            <div class="box">
                <h3>quick links</h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Odit, ipsa!</p>
                <a href="#" class="links"> <i class="fas fa-arrow-right"></i> home </a>
                <a href="#" class="links"> <i class="fas fa-arrow-right"></i> features </a>
                <a href="#" class="links"> <i class="fas fa-arrow-right"></i> products </a>
                <a href="#" class="links"> <i class="fas fa-arrow-right"></i> categories </a>
                <a href="#" class="links"> <i class="fas fa-arrow-right"></i> review </a>
                <a href="#" class="links"> <i class="fas fa-arrow-right"></i> blogs </a>
            </div>

            <div class="box">
                <h3>newsletter</h3>
                <p>subscribe for latest updates</p>
                <input type="email" placeholder="your email.. " class="email">
                <input type="submit" value="subscribe" class="btn">
                <img src="" class="payment-img" alt="">
            </div>

        </div>

        <div class="credit">
            created by <span> group 2 with mr.web designer youtube tutorial </span> | all rights reserved
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</footer>
