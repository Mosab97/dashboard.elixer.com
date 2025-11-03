<div class="d-flex align-items-center gap-2">
    <!-- Show Button -->
    @if (Auth::user()->can($config['permissions']['view']))
        <a href="{{ route($config['full_route_name'] . '.details', ['_model' => $_model->id]) }}"
            class="btn btn-icon w-30px h-30px btn-sm btn_show_{{ $config['singular_key'] }} btn-hover-primary"
            style="background-color: rgba(99, 102, 241, 0.1); border-radius: 6px; transition: background-color 0.3s;"
            data-bs-toggle="tooltip" title="{{ t('Show ' . $config['singular_name']) }}">
            <i class="fas fa-eye" style="color: #6366F1; transition: color 0.3s;"></i>
        </a>
    @endif

    <!-- Edit Button -->
    @if (Auth::user()->can($config['permissions']['edit']))
        <a href="{{ route($config['full_route_name'] . '.edit', ['_model' => $_model->id]) }}"
            class="btn btn-icon w-30px h-30px btn-sm btn_update_{{ $config['singular_key'] }} btn-hover-blue"
            style="background-color: rgba(147, 197, 253, 0.1); border-radius: 6px; transition: background-color 0.3s;"
            data-bs-toggle="tooltip" title="{{ t('Edit ' . $config['singular_name']) }}">
            <i class="fas fa-edit" style="color: #93C5FD; transition: color 0.3s;"></i>
        </a>
    @endif

    <!-- Delete Button -->
    @if (Auth::user()->can($config['permissions']['delete']))
        <a href="{{ route($config['full_route_name'] . '.delete', ['_model' => $_model->id]) }}"
            class="btn btn-icon w-30px h-30px btn-sm btn_delete_{{ $config['singular_key'] }} btn-hover-red"
            style="background-color: rgba(251, 113, 133, 0.1); border-radius: 6px; transition: background-color 0.3s;"
            data-bs-toggle="tooltip"
            data-{{ $config['singular_key'] }}-name="{{ trim(($_model->first_name ?? '') . ' ' . ($_model->last_name ?? '')) ?: 'Unknown' }}"
            title="{{ t('Remove ' . $config['singular_name']) }}">
            <i class="fas fa-trash-alt" style="color: #FB7185; transition: color 0.3s;"></i>
        </a>
    @endif
</div>
