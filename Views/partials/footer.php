    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('[data-toggle-password]').forEach(function (button) {
            button.addEventListener('click', function () {
                var input = document.getElementById(button.dataset.togglePassword);

                if (!input) {
                    return;
                }

                var isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                button.querySelector('i').className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
                button.setAttribute('aria-label', isPassword ? 'پنهان کردن رمز عبور' : 'نمایش رمز عبور');
            });
        });
    </script>
</body>
</html>
