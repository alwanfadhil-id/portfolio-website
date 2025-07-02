import './bootstrap';
import $ from 'jquery';
import 'select2';

$('.tech-stack-select').select2({
    tags: true,
    tokenSeparators: [',', ' ']
});

// Add loading state to buttons
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', e => {
        const submitButton = form.querySelector('[type="submit"]');
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
        }
    });
});
