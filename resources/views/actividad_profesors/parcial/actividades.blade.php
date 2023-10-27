<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Descripción de la actividad</th>
            <th>Observación</th>
            <th>Fecha de registro</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @if (count($actividad_profesors) > 0)
            @foreach ($actividad_profesors as $value)
                <tr>
                    <td>{{ $value->fecha }}</td>
                    <td>{{ $value->descripcion }}</td>
                    <td>{{ $value->observacion }}</td>
                    <td>{{ $value->fecha_registro }}</td>
                    <td class="btns-opciones">
                        <a href="{{ route('actividad_profesors.update', $value->id) }}" data-fecha="{{ $value->fecha }}"
                            data-descripcion="{{ $value->descripcion }}" data-observacion="{{ $value->observacion }}"
                            class="modificar"><i class="fa fa-edit" data-toggle="tooltip" data-placement="left"
                                title="Modificar"></i></a>
                        <a href="#" data-url="{{ route('actividad_profesors.destroy', $value->id) }}"
                            data-toggle="modal" data-target="#modal-eliminar" class="eliminar"><i class="fa fa-trash"
                                data-toggle="tooltip" data-placement="left" title="Eliminar"></i></a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5" class="text-center">NO SE ENCONTRARÓN REGISTROS</td>
            </tr>
        @endif
    </tbody>
</table>
