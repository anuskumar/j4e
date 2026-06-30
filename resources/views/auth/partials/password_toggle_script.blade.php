<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-password-toggle]').forEach(function (toggleBtn) {
            toggleBtn.addEventListener('click', function () {
                var wrap = toggleBtn.closest('.password-toggle-wrap');
                if (!wrap) {
                    return;
                }

                var passwordInput = wrap.querySelector('input');
                var toggleIcon = toggleBtn.querySelector('i');

                if (!passwordInput || !toggleIcon) {
                    return;
                }

                var isHidden = passwordInput.type === 'password';
                passwordInput.type = isHidden ? 'text' : 'password';
                toggleIcon.classList.toggle('fa-eye', !isHidden);
                toggleIcon.classList.toggle('fa-eye-slash', isHidden);
                toggleBtn.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
            });
        });
    });
</script>
