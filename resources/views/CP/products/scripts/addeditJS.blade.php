<script>
    document.addEventListener('DOMContentLoaded', function() {
        @foreach (config('app.locales') as $locale)
            $('[name="name[{{ $locale }}]"]').on('input', function() {
                const slugInput = $('[name="slug[{{ $locale }}]"]');
                let nameValue = $(this).val();
                if (nameValue) {
                    const slug = nameValue
                        .toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-')
                        .trim('-');

                    slugInput.val(slug);
                }
            });
        @endforeach
    });
</script>
