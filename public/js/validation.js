(function () {
  const form = document.getElementById('signalementForm');
  if (!form) return;

  const errorsBox = document.getElementById('formErrors');

  function setErrors(errors) {
    if (!errors.length) {
      errorsBox.style.display = 'none';
      errorsBox.innerHTML = '';
      return;
    }
    errorsBox.style.display = 'block';
    errorsBox.innerHTML = `<ul>${errors.map(e => `<li>${e}</li>`).join('')}</ul>`;
  }

  form.addEventListener('submit', (event) => {
    const errors = [];

    const titre = document.getElementById('titre').value.trim();
    const description = document.getElementById('description').value.trim();
    const categorie = document.getElementById('categorie').value.trim();
    const latitude = document.getElementById('latitude').value.trim();
    const longitude = document.getElementById('longitude').value.trim();
    const image = document.getElementById('image').files[0];

    if (titre.length < 5) errors.push('Le titre doit contenir au moins 5 caractères.');
    if (description.length < 10) errors.push('La description doit contenir au moins 10 caractères.');

    const allowedCategories = ['route', 'eclairage', 'eau', 'transport', 'ordures', 'autre'];
    if (!allowedCategories.includes(categorie)) {
      errors.push('Veuillez sélectionner une catégorie valide.');
    }

    const lat = Number(latitude);
    const lng = Number(longitude);
    if (Number.isNaN(lat) || lat < -90 || lat > 90) {
      errors.push('Latitude invalide.');
    }
    if (Number.isNaN(lng) || lng < -180 || lng > 180) {
      errors.push('Longitude invalide.');
    }

    if (image) {
      const allowedMime = ['image/jpeg', 'image/png'];
      if (!allowedMime.includes(image.type)) {
        errors.push('Image invalide (JPG/PNG uniquement).');
      }
      if (image.size > 5 * 1024 * 1024) {
        errors.push('Image trop volumineuse (max 5 Mo).');
      }
    }

    if (errors.length) {
      event.preventDefault();
      setErrors(errors);
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
  });
})();
