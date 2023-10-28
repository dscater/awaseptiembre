@foreach ($notificaciones as $notificacion)
    @if ($notificacion->notificacion->modulo == 'comunicado')
        <a href="{{ route('comunicados.show', $notificacion->notificacion->registro_id) }}"
            class="dropdown-item {{ $notificacion->visto == 0 ? 'font-weight-bold text-green' : '' }}">
            <i class="fas fa-bullhorn mr-2"></i> {{ $notificacion->notificacion->descripcion }}
            <span
                class="float-right text-muted text-sm">{{ $notificacion->notificacion->created_at->diffForHumans() }}</span>
        </a>
    @endif
    @if ($notificacion->notificacion->modulo == 'entrega')
        <a href="{{ route('entregas.show', $notificacion->notificacion->registro_id) }}"
            class="dropdown-item {{ $notificacion->visto == 0 ? 'font-weight-bold text-green' : '' }}">
            <i class="fas fa-clipboard-list mr-2"></i> {{ $notificacion->notificacion->descripcion }}
            <span
                class="float-right text-muted text-sm">{{ $notificacion->notificacion->created_at->diffForHumans() }}</span>
        </a>
    @endif
    @if ($notificacion->notificacion->modulo == 'calificacion')
        <a href="{{ route('calificacions.show', $notificacion->notificacion->registro_id) }}"
            class="dropdown-item {{ $notificacion->visto == 0 ? 'font-weight-bold text-green' : '' }}">
            <i class="fas fa-clipboard-check mr-2"></i> {{ $notificacion->notificacion->descripcion }}
            <span
                class="float-right text-muted text-sm">{{ $notificacion->notificacion->created_at->diffForHumans() }}</span>
        </a>
    @endif
    @if ($notificacion->notificacion->modulo == 'tarea')
        <a href="{{ route('tareas.show', $notificacion->notificacion->registro_id) }}"
            class="dropdown-item {{ $notificacion->visto == 0 ? 'font-weight-bold text-green' : '' }}">
            <i class="fas fa-list-alt mr-2"></i> {{ $notificacion->notificacion->descripcion }}
            <span
                class="float-right text-muted text-sm">{{ $notificacion->notificacion->created_at->diffForHumans() }}</span>
        </a>
    @endif
    <div class="dropdown-divider"></div>
@endforeach
