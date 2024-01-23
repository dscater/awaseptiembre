<li class="nav-item">
    <a href="{{ route('actividad_profesors.index', Auth::user()->profesor->id) }}"
        class="nav-link {{ request()->is('actividad_profesors*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-list-alt"></i>
        <p>Administrar actividades</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('profesor_materias.materias_asignadas', Auth::user()->profesor->id) }}"
        class="nav-link {{ request()->is('profesor_materias*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-list-alt"></i>
        <p>Asignación de Materias</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('tareas.index', Auth::user()->profesor->id) }}"
        class="nav-link {{ request()->is('tareas*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-list-alt"></i>
        <p>Tareas</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('entregas.index') }}" class="nav-link {{ request()->is('entregas*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-clipboard-list"></i>
        <p>Entregas</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('calificacions.index') }}" class="nav-link {{ request()->is('calificacions*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-clipboard-check"></i>
        <p>Administrar calificaciones</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('comunicados.index') }}" class="nav-link {{ request()->is('comunicados*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-bullhorn"></i>
        <p>Comunicados</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('envio_correos.index') }}" class="nav-link {{ request()->is('envio_correos*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-envelope"></i>
        <p>Envío de correos</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('reportes.index') }}" class="nav-link {{ request()->is('reportes*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-chart-pie"></i>
        <p>Reportes</p>
    </a>
</li>
