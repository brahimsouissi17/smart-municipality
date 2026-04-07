<aside class="sidebar">
    <nav class="sidebar-nav">
        <a href="<?php echo BASE_URL; ?>/index.php?route=home/index" class="sidebar-link" title="Carte">
            <span class="icon">📍</span>
            <span class="label">Carte</span>
        </a>
        <a href="<?php echo BASE_URL; ?>/index.php?route=signalements/create" class="sidebar-link" title="Créer">
            <span class="icon">➕</span>
            <span class="label">Créer</span>
        </a>
        <a href="<?php echo BASE_URL; ?>/index.php?route=signalements/list" class="sidebar-link" title="Mes signalements">
            <span class="icon">📋</span>
            <span class="label">Mes signalements</span>
        </a>
        <?php if (!empty($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
            <a href="<?php echo BASE_URL; ?>/index.php?route=admin/list" class="sidebar-link admin-link" title="BackOffice">
                <span class="icon">⚙️</span>
                <span class="label">BackOffice</span>
            </a>
        <?php endif; ?>
    </nav>
</aside>
