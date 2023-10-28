@php
    $cont = 1;
@endphp
@foreach ($entregas as $entrega)
    <tr>
        <td>{{ $entrega->id }}</td>
        <td>{{ $entrega->tarea->materia->nombre }}</td>
        <td>{{ $entrega->tarea->nombre }}</td>
        <td>{!! $entrega->tarea->descripcion !!}</td>
        <td>{{ $entrega->tarea->fecha_asignacion }}</td>
        <td>{{ $entrega->tarea->fecha_limite }}</td>
        <td><span
                class="text-xs badge {{ $entrega->tarea->estado == 'VENCIDO' ? 'badge-danger' : 'badge-success' }}">{{ $entrega->tarea->estado }}</span>
        </td>
        <td><span
                class="text-xs badge {{ $entrega->estado == 'SIN ENTREGAR' ? 'badge-danger' : 'badge-success' }}">{{ $entrega->estado }}</span>
        </td>
        <td>{{ $entrega->fecha_registro }}</td>
        <td class="btns-opciones">
            <a href="{{ route('tareas.show', $entrega->tarea->id) }}" class="ir-evaluacion"><i class="fa fa-eye"
                    data-toggle="tooltip" data-placement="left" title="Ver Tarea"></i></a>

            @if ($entrega->tarea->estado == 'VIGENTE')
                @if ($entrega->estado == 'ENTREGADO')
                    <a href="{{ route('entregas.edit', $entrega->id) }}" class="evaluar"><i class="fa fa-edit"
                            data-toggle="tooltip" data-placement="left" title="Modificar Tarea"></i></a>
                @else
                    <a href="{{ route('entregas.edit', $entrega->id) }}" class="evaluar"><i class="fa fa-paper-plane"
                            data-toggle="tooltip" data-placement="left" title="Enviar Tarea"></i></a>
                @endif
            @endif
        </td>
    </tr>
@endforeach
