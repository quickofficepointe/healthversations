// Feedback modal
const rateUsButton = document.getElementById('rateUsButton');
const rateUsModal = document.getElementById('rateUsModal');
const closeModal = document.getElementById('closeModal');

// Show modal on "Rate Us" click
rateUsButton.addEventListener('click', (e) => {
    e.preventDefault();
    rateUsModal.classList.remove('hidden');
});

// Hide modal on close button click
closeModal.addEventListener('click', () => {
    rateUsModal.classList.add('hidden');
});

// Hide modal on outside click
window.addEventListener('click', (e) => {
    if (e.target === rateUsModal) {
        rateUsModal.classList.add('hidden');
    }
});