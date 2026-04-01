        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <a class="navbar-brand d-flex align-items-center gap-2 mb-3" href="<?php echo site_url('frontend'); ?>">
                        <img src="<?php echo base_url('assets/frontend/images/poll-market-logo-transparent.png'); ?>" alt="Poll Market Solutions" class="site-logo">
                    </a>
                    <p class="text-white-50 mb-3">Poll Market Solutions LLP serves Indian businesses with packaging, stationery, silver foil, RFID seals, and paper bags.</p>
                    <div class="footer-contact">
                        <div>Pollmarket Solutions LLP, Kalher, Thane, Bhiwandi 421302</div>
                        <div>9175141468</div>
                        <div>contact@pollmarket.com</div>
                    </div>
                </div>
                <div class="col-6 col-lg-2">
                    <h6 class="fw-bold mb-3">Products</h6>
                    <div class="d-grid gap-2">
                        <a href="<?php echo site_url('frontend/shop'); ?>">All Products</a>
                        <a href="<?php echo site_url('frontend/categories'); ?>">Categories</a>
                        <a href="<?php echo site_url('frontend/offers'); ?>">Offers</a>
                        <a href="<?php echo site_url('frontend/bulk-buyers'); ?>">Bulk Buyers</a>
                    </div>
                </div>
                <div class="col-6 col-lg-2">
                    <h6 class="fw-bold mb-3">Company</h6>
                    <div class="d-grid gap-2">
                        <a href="<?php echo site_url('frontend/about'); ?>">About Us</a>
                        <a href="<?php echo site_url('frontend/contact'); ?>">Contact Us</a>
                        <a href="<?php echo site_url('frontend/track-order'); ?>">Track Order</a>
                        <a href="<?php echo site_url('frontend/faq'); ?>">FAQ</a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-bold mb-3">Useful Links</h6>
                    <p class="text-white-50">A cleaner footer block with quick access to the pages bulk buyers care about most.</p>
                    <div class="d-grid gap-2">
                        <a href="<?php echo site_url('frontend/login'); ?>">Login</a>
                        <a href="<?php echo site_url('frontend/register'); ?>">Create Account</a>
                        <a href="<?php echo site_url('frontend/contact'); ?>">Request a Quote</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom border-top border-secondary border-opacity-25 mt-4 pt-3 d-flex flex-column flex-md-row justify-content-between gap-2">
                <small class="text-white-50">Copyright 2026 Poll Market Solutions.</small>
                <small class="text-white-50">Packaging and retail supply solutions for India.</small>
            </div>
        </div>
    </footer>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url('assets/frontend/js/frontend.js'); ?>"></script>
</body>
</html>
