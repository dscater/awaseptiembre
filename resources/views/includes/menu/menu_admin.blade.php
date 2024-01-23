<li class="nav-item">
    <a href="{{ route('administrativos.index') }}"
        class="nav-link {{ request()->is('administrativos*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>Administrativos</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('estudiantes.index') }}" class="nav-link {{ request()->is('estudiantes*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>Estudiantes</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('profesors.index') }}" class="nav-link {{ request()->is('profesors*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>Profesores</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('actividad_profesors.lista') }}"
        class="nav-link {{ request()->is('actividad_profesors*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-list-alt"></i>
        <p>Actividades profesores</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('tareas.index') }}" class="nav-link {{ request()->is('tareas*') ? 'active' : '' }}">
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
    <a href="{{ route('calificacions.index') }}"
        class="nav-link {{ request()->is('calificacions*') ? 'active' : '' }}">
        <i class="nav-icon fa fa-clipboard-check"></i>
        <p>Calificaciones</p>
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

<li class="nav-item @if (request()->is('materias*') ||
        request()->is('areas*') ||
        request()->is('campos*') ||
        request()->is('nivels*') ||
        request()->is('grados*')) menu-is-opening menu-open active @endif">
    <a href="#" class="nav-link">
        <i class="nav-icon far fa-list-alt"></i>
        <p>Materias <i class="fas fa-angle-left right"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('materias.index') }}" class="nav-link @if (request()->is('materias*')) active @endif">
                <i class="nav-icon far fa-circle"></i>
                <p>Materias</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('areas.index') }}" class="nav-link @if (request()->is('areas*')) active @endif">
                <i class="nav-icon far fa-circle"></i>
                <p>Áreas</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('campos.index') }}" class="nav-link @if (request()->is('campos*')) active @endif">
                <i class="nav-icon far fa-circle"></i>
                <p>Campos</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item @if (request()->is('inscripcions*') || request()->is('paralelos*')) menu-is-opening menu-open active @endif">
    <a href="#" class="nav-link">
        <i class="nav-icon far fa-list-alt"></i>
        <p>Materias de Estudiantes <i class="fas fa-angle-left right"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('inscripcions.index') }}"
                class="nav-link @if (request()->is('inscripcions*')) active @endif">
                <i class="nav-icon far fa-circle"></i>
                <p>Materias de Estudiantes</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('paralelos.index') }}" class="nav-link @if (request()->is('paralelos*')) active @endif">
                <i class="nav-icon far fa-circle"></i>
                <p>Paralelos</p>
            </a>
        </li>
    </ul>
</li>

{{-- <li class="nav-item @if (request()->is('pago_estudiantes*') || request()->is('plan_pagos*'))menu-is-opening menu-open active @endif">
    <a href="#" class="nav-link">
        <i class="nav-icon far fa-list-alt"></i>
        <p>Pagos <i class="fas fa-angle-left right"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('pago_estudiantes.index') }}" class="nav-link @if (request()->is('pago_estudiantes*'))active @endif">
                <i class="nav-icon far fa-circle"></i>
                <p>Pagos Estudiantes</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('plan_pagos.index') }}" class="nav-link @if (request()->is('plan_pagos*'))active @endif">
                <i class="nav-icon far fa-circle"></i>
                <p>Plan de Pagos</p>
            </a>
        </li>
    </ul>
</li> --}}


<li class="nav-item">
    <a href="{{ route('reportes.index') }}" class="nav-link {{ request()->is('reportes*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-chart-pie"></i>
        <p>Reportes</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('razon_social.index') }}" class="nav-link {{ request()->is('razon_social*') ? 'active' : '' }}">
        <i class="nav-icon fa fa-hospital"></i>
        <p>Razón social</p>
    </a>
</li>
