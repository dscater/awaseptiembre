<li class="nav-item">
    <a href="{{ route('tareas.tareas_estudiante') }}" class="nav-link {{ request()->is('tareas*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-list-alt"></i>
        <p>Administrar Tareas</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('entregas.index') }}" class="nav-link {{ request()->is('entregas*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-clipboard-list"></i>
        <p>Administrar Entregas</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('calificacions.index') }}" class="nav-link {{ request()->is('calificacions*') ? 'active' : '' }}">
        <i class="nav-icon fa fa-clipboard-check"></i>
        <p>Administrar Calificaciones</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('comunicados.index') }}" class="nav-link {{ request()->is('comunicados*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-bullhorn"></i>
        <p>Comunicados</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('reportes.index') }}" class="nav-link {{ request()->is('reportes*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-chart-pie"></i>
        <p>Reportes</p>
    </a>
</li>
