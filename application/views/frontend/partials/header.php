<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Poll Market Solutions - <?php echo html_escape($title); ?></title>
    <meta name="description" content="Modern Indian ecommerce storefront for packaging, paper bags, stationery, foil, and RFID seals.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/frontend/css/frontend.css'); ?>" rel="stylesheet">
</head>
<body>
<div class="site-shell">
    <nav class="navbar navbar-expand-lg site-nav sticky-top">
        <div class="container py-2">
            <a class="navbar-brand d-flex align-items-center gap-2 site-brand-frame" href="<?php echo site_url('frontend'); ?>">
                <span class="site-logo-wrap">
                    <img src="<?php echo base_url('assets/frontend/images/poll-market-logo-transparent.png'); ?>" alt="Poll Market Solutions" class="site-logo">
                </span>
            </a>
            <button class="navbar-toggler" type="button" data-nav-toggle>
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="siteNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3">
                    <?php foreach ($nav_items as $item): ?>
                        <?php
                            $current = trim(uri_string(), '/');
                            $route = trim($item['url'], '/');
                            $is_active = ($current === '' && $route === 'frontend') || $current === $route;
                        ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $is_active ? 'active fw-bold text-dark' : 'text-secondary'; ?>" href="<?php echo site_url($item['url']); ?>">
                                <?php echo html_escape($item['label']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="d-flex gap-2">
                    <a class="btn btn-outline-dark btn-sm" href="<?php echo site_url('frontend/wishlist'); ?>"><i class="bi bi-suit-heart"></i></a>
                    <a class="btn btn-outline-dark btn-sm" href="<?php echo site_url('frontend/cart'); ?>"><i class="bi bi-bag"></i></a>
                    <a class="btn btn-primary btn-sm" href="<?php echo site_url('frontend/login'); ?>">Sign in</a>
                </div>
            </div>
        </div>
    </nav>
    <main>
        <div class="container py-4 py-lg-5">
