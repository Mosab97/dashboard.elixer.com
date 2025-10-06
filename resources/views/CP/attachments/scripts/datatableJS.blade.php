{{-- @dd($_model::class) --}}

<script>
    var selectedItemsModelsRows = [];
    var selectedItemModelsData = [];

    const columnDefs = [{
            data: 'id',
            name: 'id',
        },
        {
            // className: 'd-flex align-items-center',
            data: 'title',
            name: 'title',
        },

        // {
        //     data: 'attachment_type.name',
        //     name: 'attachment_type.name',
        //     render: function(data, type, row) {
        //         return row.attachment_type?.name[currentLocale] || 'NA';
        //     }
        // },
        // {
        //     data: 'source',
        //     name: 'source',
        // },
        {
            data: {
                _: 'created_at.display',
                sort: 'created_at.timestamp',
            },
            name: 'created_at',
            visible: true,
            searchable: false
        },
        {
            data: 'action',
            name: 'action',
            className: 'text-end',
            orderable: false,
            searchable: false
        }
    ];

    var datatable = createDataTable("#kt_table_attachments", columnDefs,
        "{{ route($config['full_route_name'] . '.index') }}", [
            [0, "ASC"]
        ]);
    datatable.on('draw', function() {
        KTMenu.createInstances();
    });
    datatable.on('responsive-display', function() {
        KTMenu.createInstances();
    });


    $(document).on('click', '#filterBtn', function(e) {
        e.preventDefault();
        datatable.ajax.reload();
    });

    $(document).on('click', '#resetFilterBtn', function(e) {
        e.preventDefault();
        $('#filter-form').trigger('reset');
        $('.datatable-input').each(function() {
            if ($(this).hasClass('filter-selectpicker')) {
                $(this).val('');
                $(this).trigger('change');
            }
            if ($(this).hasClass('flatpickr-input')) {
                const fp = $(this)[0]._flatpickr;
                fp.clear();
            }
        });
        datatable.ajax.reload();
    });
</script>
