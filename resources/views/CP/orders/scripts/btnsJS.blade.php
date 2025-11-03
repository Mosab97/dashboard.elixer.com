
{{-- btn_delete_ --}}
<script>
    $(document).on('click', '.btn_delete_' + "{{ $config['singular_key'] }}", function(e) {
        e.preventDefault();
        const URL = $(this).attr('href');
        const itemModelName = $(this).attr('data-' + "{{ $config['singular_key'] }}" + '-name');
        Swal.fire({
            html: "Are you sure you want to delete " + itemModelName + "?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, delete!",
            cancelButtonText: "No, cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-danger",
                cancelButton: "btn fw-bold btn-active-light-primary"
            }
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "DELETE",
                    url: URL,
                    dataType: "json",
                    success: function(response) {
                        datatable.ajax.reload(null, false);
                        Swal.fire({
                            text: response.message,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },
                    complete: function() {},
                    error: function(response, textStatus,
                        errorThrown) {
                        toastr.error(response
                            .responseJSON
                            .message);
                    },
                });

            } else if (result.dismiss === 'cancel') {}

        });
    });
</script>
{{-- btn_show_ --}}
<script>
    $(document).on('click', '.btn_show_' + "{{ $config['singular_key'] }}", function(e) {
        e.preventDefault();
        const URL = $(this).attr('href');
        const button = $(this);
        
        // Extract order ID from URL
        const orderIdMatch = URL.match(/\/(\d+)\/(details|print)/);
        const orderId = orderIdMatch ? orderIdMatch[1] : null;

        // Set button loading state
        button.attr('data-kt-indicator', 'on');
        button.prop('disabled', true);

        $.ajax({
            url: URL,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status && response.createView) {
                    // Create or get modal
                    let $modal = $('#kt_modal_order_details');
                    if ($modal.length === 0) {
                        $modal = $('<div class="modal fade" id="kt_modal_order_details" tabindex="-1" aria-hidden="true">' +
                            '<div class="modal-dialog modal-dialog-centered modal-xl">' +
                            '<div class="modal-content"></div>' +
                            '</div>' +
                            '</div>');
                        $('body').append($modal);
                    }

                    // Set modal content
                    $modal.find('.modal-content').html(response.createView);

                    // Show modal
                    const modal = new bootstrap.Modal($modal[0]);
                    modal.show();

                    // Initialize print functionality - use backend PDF generation
                    $modal.find('.btn_print_order').off('click').on('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        // Get order ID from button data attribute or from extracted orderId
                        const btnOrderId = $(this).data('order-id');
                        const finalOrderId = btnOrderId || orderId;
                        
                        if (finalOrderId) {
                            // Build the print URL using Laravel route
                            const printUrl = "{{ route($config['full_route_name'] . '.print', ['_model' => 'ORDER_ID_PLACEHOLDER']) }}".replace('ORDER_ID_PLACEHOLDER', finalOrderId);
                            // Open PDF in new window (backend will generate and return PDF)
                            window.open(printUrl, '_blank');
                        } else {
                            toastr.error('Order ID not found');
                        }
                    });

                    // Cleanup on modal close
                    $modal.on('hidden.bs.modal', function() {
                        $modal.find('.modal-content').html('');
                        $modal.off('hidden.bs.modal');
                    });
                } else {
                    toastr.error(response.message || 'Failed to load order details');
                }
            },
            error: function(xhr, status, error) {
                handleAjaxErrors(xhr, status, error, {
                    submitButton: button
                });
            },
            complete: function() {
                button.removeAttr('data-kt-indicator');
                button.prop('disabled', false);
            }
        });
    });
</script>


 {{-- btn_get_status_form_ --}}
<script>
    // Status change click handler
    $(document).on('click', '.btn_get_status_form_order', function(e) {
        e.preventDefault();
        const button = $(this);
        button.attr("data-kt-indicator", "on");
        const url = button.attr('href');

        ModalRender.render({
            url: url,
            button: button,
            modalId: '#kt_modal_general_sm',
            modalBootstrap: new bootstrap.Modal(document.querySelector('#kt_modal_general_sm')),
            formId: '#kt_modal_change_status_form',
            dataTableId: datatable,
            submitButtonName: '[data-kt-change-status-modal-action="submit"]',
        });


    });
</script>
