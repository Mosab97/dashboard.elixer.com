@isset($policyOffer)
    <script>
        var datatableAtt;

        var initAtts = (function() {


            return function() {


                executed = true;
                const columnDefs = [{
                        data: 'id',
                        name: 'id',
                    },
                    {
                        // className: 'd-flex align-items-center',
                        data: 'title',
                        name: 'title',
                    },

                    {
                        data: function(row, type, set) {
                            if (type === 'display') {
                                return row.attachment_type.name;
                            }
                            return row.attachment_type_id;
                        },
                        name: 'attachment_type_id',
                    },
                    {
                        data: 'source',
                        name: 'source',
                    },
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
                datatableAtt = createDataTable('#kt_table_policyOffers_attachments', columnDefs,
                    "{{ route('policyOffers.attachments', ['policyOffer' => $policyOffer->id]) }}",
                    [
                        [0, "ASC"]
                    ]);


            };
        })();
    </script>

    <script>
        var elementAtt = document.getElementById('kt_modal_add_attachment');
        var modalAtt = new bootstrap.Modal(elementAtt);


        $(document).on('click', '.btnUpdateAttachment', function(e) {
            e.preventDefault();
            $(this).attr("data-kt-indicator", "on");
            var editURl = $(this).attr('href');
            globalRenderModal(editURl,
                $(this), '#kt_modal_add_attachment', modalAtt, [], '#kt_modal_add_attachment_form',
                datatableAtt, '[data-kt-attachments-modal-action="submit"]');
        });

        $(document).on('click', '#AddAttachmentModal', function(e) {
            e.preventDefault();
            $(this).attr("data-kt-indicator", "on");

            // Get the values of module_type_data and constant_name_data
            var moduleType = $(this).attr('module_type_data');
            var constantName = $(this).attr('constant_name_data');
            var attachemnt_type = $(this).attr('attachemnt_type');

            // Construct the URL with query parameters
            var routeUrl = "{{ route('policyOffers.attachments.create', ['policyOffer' => $policyOffer->id]) }}";
            routeUrl +=
                `?module_type=${encodeURIComponent(moduleType)}&constant_name=${encodeURIComponent(constantName)}&attachemnt_type=${encodeURIComponent(attachemnt_type)}`;
            console.log(`routeUrl:  ${routeUrl}`, moduleType, constantName);

            // Call globalRenderModal with the new routeUrl
            globalRenderModal(routeUrl, $(this), '#kt_modal_add_attachment', modalAtt, [],
                '#kt_modal_add_attachment_form', datatableAtt, '[data-kt-attachments-modal-action="submit"]');
        });
    </script>
    <script>
        $(document).on('click', '.btnDeletePolicyOfferAttachment', function(e) {
            e.preventDefault();
            var URL = $(this).attr('href');
            var attachmentName = $(this).attr('data-attachment-name');
            Swal.fire({
                text: "Are you sure you want to delete " + attachmentName + "?",
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
                            datatableAtt.ajax.reload(null, false);
                            Swal.fire({
                                text: response.message,
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        },
                        complete: function() {},
                        error: function(xhr, status, error) {
                            // Step 1: Check if the user is unauthenticated (401 status) or if there's a CSRF token mismatch (419 status)
                            if (xhr.status === 401 || xhr.status === 419) {
                                let currentUrl = window.location.href;

                                if (xhr.status === 401) {
                                    toastr.error('You are not authenticated. Please log in.');
                                    console.error(
                                        'User is unauthenticated, redirecting to login.');
                                } else if (xhr.status === 419) {
                                    toastr.error('Session expired. Please log in again.');
                                    console.error('CSRF token mismatch, redirecting to login.');
                                }

                                // Redirect the user to the login page and pass the current URL as a query parameter
                                window.location.href = "{{ route('login') }}?redirect=" +
                                    encodeURIComponent(currentUrl);
                            } else {
                                // Handle other types of errors
                                toastr.error(xhr.responseJSON ? xhr.responseJSON.message :
                                    'An error occurred.');
                                console.error('An error occurred:', status, error);
                            }
                        }


                        // error: function(response, textStatus,
                        //     errorThrown) {

                        // },
                    });

                } else if (result.dismiss === 'cancel') {}

            });
        });
    </script>
    <script>
        $(function() {
            initAtts();
        });
    </script>
@endisset
