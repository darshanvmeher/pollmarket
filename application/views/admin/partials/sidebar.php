<aside class="sidebar" id="sidebar">
    <a class="brand" href="<?php echo site_url('admin'); ?>">
        <span class="brand-mark"><i class="bi bi-box-seam"></i></span>PackMart Admin
    </a>
    <div class="menu-label">Main</div>
    <nav class="nav flex-column">
        <?php foreach ($nav_items as $key => $item): ?>
            <?php if (!empty($item['children'])): ?>
                <?php
                $is_reports_open = in_array($active, array_keys($item['children']), true);
                ?>
                <div class="nav-group <?php echo $is_reports_open ? 'open' : ''; ?>">
                    <a data-nav-item class="nav-link nav-group-toggle <?php echo ($active === $key || $is_reports_open) ? 'active' : ''; ?>" href="<?php echo site_url($item['url']); ?>">
                        <span class="d-inline-flex align-items-center gap-2">
                            <i class="<?php echo html_escape($item['icon']); ?>"></i>
                            <?php echo html_escape($item['label']); ?>
                        </span>
                        <i class="bi bi-chevron-down nav-group-caret"></i>
                    </a>
                    <div class="nav-submenu">
                        <?php foreach ($item['children'] as $child_key => $child): ?>
                            <a data-nav-item class="nav-link nav-submenu-link <?php echo ($active === $child_key) ? 'active' : ''; ?>" href="<?php echo site_url($child['url']); ?>">
                                <?php echo html_escape($child['label']); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <a data-nav-item class="nav-link <?php echo ($active === $key) ? 'active' : ''; ?>" href="<?php echo site_url($item['url']); ?>">
                    <i class="<?php echo html_escape($item['icon']); ?>"></i> <?php echo html_escape($item['label']); ?>
                </a>
            <?php endif; ?>
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
