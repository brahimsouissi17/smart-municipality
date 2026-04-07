<div class="card">
    <h1><?php echo e($item['titre']); ?></h1>
    <p><strong>Catégorie:</strong> <?php echo e($item['categorie']); ?></p>
    <p><strong>Statut:</strong> <span class="badge status-<?php echo e($item['statut']); ?>"><?php echo e($item['statut']); ?></span></p>
    <p><strong>Date:</strong> <?php echo e($item['date_signalement']); ?></p>
    <p><?php echo nl2br(e($item['description'])); ?></p>

    <?php if (!empty($item['image'])): ?>
        <img src="<?php echo UPLOAD_URL . e($item['image']); ?>" alt="photo" style="max-width:420px; width:100%; border-radius:8px;">
    <?php endif; ?>

    <div style="margin-top:1rem; display:flex; gap:8px;">
        <a class="btn-secondaire" href="<?php echo BASE_URL; ?>/index.php?route=signalements/list">Retour</a>
        <a class="btn-principal" href="<?php echo BASE_URL; ?>/index.php?route=admin/edit&id=<?php echo (int)$item['id']; ?>">Edition admin</a>
    </div>
</div>
