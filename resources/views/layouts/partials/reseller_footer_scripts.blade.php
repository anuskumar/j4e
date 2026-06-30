<script>
    $(document).ready(function() {
        $(document).on('click', '.logout-link, a[href="{{ route('logout') }}"]', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var form = document.getElementById('logout-form');
            if (form) {
                form.submit();
            } else {
                var logoutForm = $('<form>', {
                    'method': 'POST',
                    'action': '{{ route('logout') }}',
                    'id': 'logout-form',
                    'class': 'd-none'
                });
                logoutForm.append($('<input>', {
                    'type': 'hidden',
                    'name': '_token',
                    'value': '{{ csrf_token() }}'
                }));
                $('body').append(logoutForm);
                logoutForm[0].submit();
            }
            return false;
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.logout-link').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                var form = document.getElementById('logout-form');
                if (form) {
                    form.submit();
                }
            });
        });
    });
</script>
