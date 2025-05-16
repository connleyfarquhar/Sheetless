function applyInitials() {
    const initials = document.getElementById('worker_initials_select').value;
    if (initials) {
        const inputs = document.querySelectorAll('.traveller-step input[type="text"]');
        inputs.forEach(input => {
            input.value = initials;
        });
    } else {
        alert('Select Initials');
    }
}