<div class="card">
    <div class="card-body">
        <p><strong>Gestión: </strong> {{ $ultima_inscripcion->gestion }}</p>
        <p><strong>Paralelo: </strong> {{ $ultima_inscripcion->grado }}°
            {{ $ultima_inscripcion->paralelo->paralelo }}</p>
        <p><strong>Turno: </strong> {{ $ultima_inscripcion->turno }}</p>
        <h5>Tutor</h5>
        <div class="row pl-3">
            <div class="col-12">
                <p><strong>Nombre: </strong> {{ $estudiante->full_name_tutor }}</p>
                <p><strong>C.I.: </strong>{{ $estudiante->ci_padre_tutor }}</p>
                <p><strong>Correo: </strong>{{ $estudiante->correo_padre_tutor }}</p>
            </div>
        </div>
        <h5>Madre</h5>
        <div class="row pl-3">
            <div class="col-12">
                <p><strong>Nombre: </strong> {{ $estudiante->full_name_madre }}</p>
                <p><strong>C.I.: </strong>{{ $estudiante->ci_madre }}</p>
                <p><strong>Correo: </strong>{{ $estudiante->correo_madre }}</p>
            </div>
        </div>
    </div>
</div>
