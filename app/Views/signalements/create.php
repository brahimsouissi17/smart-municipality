<div class="card">
    <h1>Créer un signalement</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form id="signalementForm" method="post" action="<?php echo BASE_URL; ?>/index.php?route=signalements/store" enctype="multipart/form-data" novalidate>
        <div class="grid grid-2">
            <div>
                <label for="titre">Titre</label>
                <input id="titre" name="titre" type="text" value="<?php echo e($old['titre'] ?? ''); ?>" placeholder="Ex: Nid de poule dangereux">
            </div>
            <div>
                <label for="categorie">Catégorie</label>
                <select id="categorie" name="categorie">
                    <option value="">Choisir</option>
                    <?php foreach (['route', 'eclairage', 'eau', 'transport', 'ordures', 'autre'] as $cat): ?>
                        <option value="<?php echo $cat; ?>" <?php echo (($old['categorie'] ?? '') === $cat) ? 'selected' : ''; ?>><?php echo ucfirst($cat); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <label for="description">Description</label>
        <textarea id="description" name="description" placeholder="Décrire le problème en détail"><?php echo e($old['description'] ?? ''); ?></textarea>

        <div class="grid grid-2">
            <div>
                <label for="latitude">Latitude</label>
                <input id="latitude" name="latitude" type="text" value="<?php echo e($old['latitude'] ?? ''); ?>" placeholder="36.80650000">
            </div>
            <div>
                <label for="longitude">Longitude</label>
                <input id="longitude" name="longitude" type="text" value="<?php echo e($old['longitude'] ?? ''); ?>" placeholder="10.18150000">
            </div>
        </div>

        <label for="image">Image (JPG/PNG, max 5Mo)</label>
        <input id="image" name="image" type="file" accept="image/jpeg,image/png">

        <p style="margin:0.75rem 0;">Cliquer sur la carte pour remplir latitude/longitude</p>
        <div id="map" style="height: 330px;"></div>

        <div id="formErrors" class="alert alert-error" style="display:none; margin-top: 12px;"></div>

        <div style="margin-top:1rem; display:flex; gap:8px;">
            <button type="submit" class="btn-principal">Enregistrer</button>
            <a class="btn-secondaire" href="<?php echo BASE_URL; ?>/index.php?route=signalements/list">Annuler</a>
        </div>
    </form>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="<?php echo BASE_URL; ?>/public/js/validation.js"></script>
<script>
const map = L.map('map').setView([36.8065, 10.1815], 12);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  maxZoom: 19,
  attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);
let marker = null;
map.on('click', (e) => {
  const lat = e.latlng.lat.toFixed(8);
  const lng = e.latlng.lng.toFixed(8);
  document.getElementById('latitude').value = lat;
  document.getElementById('longitude').value = lng;
  if (marker) marker.remove();
  marker = L.marker([lat, lng]).addTo(map);
});
</script>
