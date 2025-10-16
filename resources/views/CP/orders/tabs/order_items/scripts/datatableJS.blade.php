<script>
    var selectedItemModelsData = [];
    const columnDefsOrderItems = [
        {
            data: 'id',
            name: 'id',
            orderable: true,
            searchable: true,
            render: function(data, type, row) {
                return '#' + (data || 'N/A');
            }
        },
        {
            data: 'product_name',
            name: 'product_id',
            orderable: true,
            searchable: true,
            render: function(data, type, row) {
                return data || 'N/A';
            }
        },
        {
            data: 'quantity',
            name: 'quantity',
            orderable: true,
            searchable: false,
            render: function(data, type, row) {
                return data || '0';
            }
        },
        {
            data: 'price',
            name: 'price',
            orderable: true,
            searchable: false,
            render: function(data, type, row) {
                return data || '0.00';
            }
        },
        {
            data: 'total',
            name: 'total',
            orderable: true,
            searchable: false,
            render: function(data, type, row) {
                return data || '0.00';
            }
        },
        {
            data: 'created_at',
            name: 'created_at',
            orderable: true,
            searchable: false,
            render: function(data, type, row) {
                return data?.display || 'N/A';
            }
        },
        // {
        //     data: 'action',
        //     name: 'action',
        //     className: 'text-end',
        //     orderable: false,
        //     searchable: false
        // }
    ];
    var datatableOrderItems = createDataTable('#kt_table_order_items', columnDefsOrderItems,
        "{{ route($config['full_route_name'] . '.index', ['order' => $_model->id]) }}",
        [
            [0, "ASC"]
        ]);
    datatableOrderItems.on('draw', function() {
        KTMenu.createInstances();
    });
    datatableOrderItems.on('responsive-display', function() {
        KTMenu.createInstances();
    });

    const filterSearchOrderItems = document.querySelector(
        '[data-kt-{{ $config['singular_key'] }}-table-filter="search"]');
    filterSearchOrderItems.onkeydown = debounce(keyPressCallback, 400);

    function keyPressCallback() {
        datatableOrderItems.draw();
    }
</script>
