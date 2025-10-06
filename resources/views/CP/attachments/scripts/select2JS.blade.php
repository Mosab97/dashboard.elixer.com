@php
    use App\Models\Apartment;
@endphp

<script>
    const apartmentSelector = 'select[name="{{ Apartment::ui['_id'] }}"]'; // More specific selector
    class ApartmentHandler extends Select2BaseModelHandler {
        constructor() {
            super({
                model: "App\\Models\\Apartment",
                selector: apartmentSelector,
                prefix: '',
                placeholder: "Select an Apartment",
                fields: [
                    'building_id', 'name', 'floor_number', 'apartment_type_id', 'apartment_size_id',
                    'price', 'rooms_number', 'bedrooms_number', 'balcoines_number',
                    'parking_type_id', 'description'
                ],
                relatedFields: {}
            });
        }


    }

    // Initialize handlers where needed
    $(document).ready(function() {
        const apartmentSelect = $(apartmentSelector);
        console.log('Select element found:', apartmentSelect.length);

        if (apartmentSelect.length) {
            // Remove any existing select2 initialization
            if (apartmentSelect.hasClass('select2-hidden-accessible')) {
                apartmentSelect.select2('destroy');
            }

            const apartmentHandler = new ApartmentHandler();
            apartmentHandler.initialize();
        }
    });
</script>
