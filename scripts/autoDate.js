// the autoDate.js Script adds the functionality initially documented in the planning document where it automatically fills out the exact date the traveller is being edited on which decreases the amount of time needed to fill out travellers on a day to day basis.
// The Script starts by retrieving all date inputs on pages that have the script linked to it, then creates the date to be outputed into the field automatically.

document.addEventListener("DOMContentLoaded", function() {
    const dateFields = document.querySelectorAll('input[type="date"]');
    const today = new Date().toISOString().split('T')[0]; 
    dateFields.forEach(field => field.value = today);
  });