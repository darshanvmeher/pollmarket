<aside class="sidebar" id="sidebar">
    <a class="brand" href="<?php echo site_url('admin'); ?>">
        <span class="brand-mark"><i class="bi bi-box-seam"></i></span>PackMart Admin
    </a>
    <div class="menu-label">Main</div>
    <nav class="nav flex-column">
        <?php foreach ($nav_items as $key => $item): ?>
            <a data-nav-item class="nav-link <?php echo ($active === $key) ? 'active' : ''; ?>" href="<?php echo site_url($item['url']); ?>">
                <i class="<?php echo html_escape($item['icon']); ?>"></i> <?php echo html_escape($item['label']); ?>
            </a>
        <?php endforeach; ?>
    </nav>
    <div class="sidebar-footer">
        <a class="nav-link" href="<?php echo site_url('admin/login'); ?>"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
</aside>
<div class="sidebar-overlay" id="sidebarOverlay"></div>
<main class="main">
    <div class="topbar d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-light d-lg-none" data-sidebar-toggle><i class="bi bi-list"></i></button>
            <div>
                <h1 class="h4 page-title"><?php echo html_escape($title); ?></h1>
                <p class="page-subtitle"><?php echo html_escape($subtitle); ?></p>
            </div>
        </div>
    </div>
