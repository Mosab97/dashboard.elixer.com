
@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Find all textarea elements in the settings form
            const form = document.getElementById('{{ $config['singular_key'] }}_form');
            if (!form) return;

            const textareas = form.querySelectorAll('textarea');
            const editors = []; // Store editor instances for form submission

            // Initialize CKEditor for each textarea
            textareas.forEach((textarea, index) => {
                ClassicEditor.create(textarea, {
                        placeholder: 'Enter content...',
                        toolbar: {
                            items: [
                                'heading', '|',
                                'bold', 'italic', 'underline', 'link', '|',
                                'bulletedList', 'numberedList', 'outdent', 'indent', '|',
                                'blockQuote', 'insertTable', 'undo', 'redo'
                            ]
                        },
                        table: {
                            contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                        }
                        // language: 'ar' // uncomment if you want full UI in Arabic
                    })
                    .then(editor => {
                        // Store editor instance
                        editors.push({
                            editor: editor,
                            textarea: textarea
                        });

                        console.log(`CKEditor initialized for textarea: ${textarea.name || 'unnamed'}`);
                    })
                    .catch(error => {
                        console.error(
                            `Failed to initialize CKEditor for textarea ${textarea.name || 'unnamed'}:`,
                            error);
                    });
            });

            // Handle form submission - sync all editor data
            form.addEventListener('submit', function(e) {
                editors.forEach(({
                    editor,
                    textarea
                }) => {
                    try {
                        textarea.value = editor.getData();
                    } catch (error) {
                        console.error(`Failed to sync data for textarea ${textarea.name}:`, error);
                    }
                });
            });
        });
    </script>
@endpush
