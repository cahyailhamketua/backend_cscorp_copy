<div class="filament-widget">
    <form
        id="visitor-month-form"
        action="{{ route('filament.visitor_month.set') }}"
        method="POST"
        class="flex items-center gap-2"
    >
        @csrf
        <label for="visitor-month" class="text-sm text-gray-500">Bulan:</label>
        <input
            id="visitor-month"
            name="visitor_month"
            type="month"
            value="{{ $selected }}"
            class="filament-input px-2 py-1 rounded border"
            aria-label="Pilih bulan pengunjung"
        />
        <button type="submit" class="filament-button inline-flex items-center px-3 py-1 rounded">Terapkan</button>
        <button
            type="submit"
            name="visitor_month"
            value=""
            class="filament-button text-sm inline-flex items-center px-3 py-1 rounded bg-gray-100"
        >Hapus</button>
    </form>

    <script>
        (function () {
            const form = document.getElementById('visitor-month-form');
            if (! form) return;

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const url = form.action;
                const data = new FormData(form);

                // Get CSRF token from hidden input
                const token = data.get('_token');

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: data,
                    credentials: 'same-origin',
                }).then(function (res) {
                    // Try to parse JSON response (server returns JSON for AJAX)
                    const ct = res.headers.get('content-type') || '';
                    if (ct.indexOf('application/json') !== -1) {
                        return res.json().then(function (json) {
                            console.log('visitor_month response', json);
                            // reload so widgets pick up session change
                            window.location.reload();
                        });
                    }

                    // If server redirected, follow; otherwise reload to pick up session change
                    if (res.redirected) {
                        window.location.href = res.url;
                    } else {
                        window.location.reload();
                    }
                }).catch(function (err) {
                    console.error('visitor_month post failed', err);
                    // best-effort fallback
                    window.location.reload();
                });
            });
        })();
    </script>
</div>
