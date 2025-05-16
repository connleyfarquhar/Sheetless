// This script serves as a validation check for my form inputs, based on my Functional Testing i had numerous fails in this section, such content has been fixed with this script.

document.addEventListener('DOMContentLoaded', function() {
    // Select all text inputs in the form
    const formInput = document.querySelectorAll('input[type="text"]');
    
    // For each input, add an event listener for the input event that was created, 
    // within this input event remove any special characters that may be attempted to be added into the input field.
    formInput.forEach(input => {
      input.addEventListener('input', function() {
        // Remove any special characters from the form input.
        this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '');
      });
    });
  });