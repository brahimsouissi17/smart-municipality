const cfg = window.SMART_MAP_CONFIG || {};

const map = L.map('map').setView([36.8065, 10.1815], 12);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  maxZoom: 19,
  attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

const markerLayer = L.layerGroup().addTo(map);
const zoneLayer = L.layerGroup().addTo(map);

function statusColor(statut) {
  if (statut === 'resolu') return 'green';
  if (statut === 'en_cours') return 'orange';
  if (statut === 'rejete') return 'red';
  return 'orange';
}

function getIcon(color) {
  return L.divIcon({
    className: 'custom-pin',
    html: `<svg width="22" height="22" viewBox="0 0 24 24" fill="${color}" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>`,
    iconSize: [22, 22],
    iconAnchor: [11, 22]
  });
}

function escapeHtml(v) {
  return String(v || '').replace(/[&<>\"']/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '\"': '&quot;', "'": '&#39;' }[m]));
}

function drawCriticalZones(items) {
  zoneLayer.clearLayers();
  if (!cfg.isAdmin) return;

  const buckets = {};
  items.forEach((it) => {
    const key = `${Math.round(Number(it.latitude) * 20) / 20}_${Math.round(Number(it.longitude) * 20) / 20}`;
    buckets[key] = (buckets[key] || 0) + 1;
  });

  Object.keys(buckets).forEach((key) => {
    const count = buckets[key];
    if (count < 3) return;

    const [lat, lng] = key.split('_').map(Number);
    const color = count >= 7 ? '#dc2626' : '#f59e0b';

    L.rectangle(
      [[lat - 0.02, lng - 0.02], [lat + 0.02, lng + 0.02]],
      { color, weight: 1, fillColor: color, fillOpacity: 0.25 }
    ).bindPopup(`Zone critique: ${count} signalement(s)`).addTo(zoneLayer);
  });
}

async function loadMarkers() {
  const categorie = document.getElementById('filterCategorie')?.value || '';
  const date = document.getElementById('filterDate')?.value || '';
  const zone = document.getElementById('filterZone')?.value || '';

  const query = new URLSearchParams({ categorie, date, zone });
  const response = await fetch(`${cfg.apiUrl}&${query.toString()}`);
  const items = await response.json();

  markerLayer.clearLayers();

  items.forEach((it) => {
    const marker = L.marker([Number(it.latitude), Number(it.longitude)], { icon: getIcon(statusColor(it.statut)) });
    const imageHtml = it.image_url ? `<img src="${it.image_url}" alt="photo" style="max-width:220px; border-radius:8px; margin-top:6px;">` : '<p><em>Pas de photo</em></p>';

    marker.bindPopup(`
      <div style="max-width:230px;">
        <h4 style="margin:0 0 6px;">${escapeHtml(it.titre)}</h4>
        <p style="margin:0 0 5px;"><strong>Catégorie:</strong> ${escapeHtml(it.categorie)}</p>
        <p style="margin:0 0 5px;"><strong>Statut:</strong> ${escapeHtml(it.statut)}</p>
        <p style="margin:0 0 5px;">${escapeHtml(it.description)}</p>
        ${imageHtml}
      </div>
    `);

    marker.addTo(markerLayer);
  });

  drawCriticalZones(items);
}

document.getElementById('btnFiltrer')?.addEventListener('click', loadMarkers);
loadMarkers();
