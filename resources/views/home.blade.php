@extends('layouts.app')

@section('background-image')
{{-- style="background-image:url({{asset('imgs/fondo.jpg')}})" --}}
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/home.css')}}">
@endsection

@section('content')

 <!-- Content Header (Page header) -->
 <div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Inicio</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-white">
                    <li class="breadcrumb-item active">Inicio</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        @if(Auth::user()->tipo == 'ADMINISTRADOR')
        @include('includes.home.home_admin')
        @endif
        @if(Auth::user()->tipo == 'PROFESOR')
        @include('includes.home.home_profesor')
        @endif
        @if(Auth::user()->tipo == 'ESTUDIANTE')
        @include('includes.home.home_estudiante')
        @endif
        @if(Auth::user()->tipo == 'SECRETARIA ACADÉMICA')
        @include('includes.home.home_secretaria')
        @endif
        @if(Auth::user()->tipo == 'TUTOR')
        @include('includes.home.home_tutor')
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h2 class="font-weight-bold">{{ App\RazonSocial::first()->nombre}} <br> <span class="font-weight-normal">Bienvenid@ {{Auth::user()->name}}</span></h2>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/. container-fluid -->
</section>
<!-- /.content -->

@endsection

@section('scripts')
<script>
    @if(session('bien'))
    mensajeNotificacion('{{session('bien')}}','success');
    @endif

    @if(session('info'))
    mensajeNotificacion('{{session('info')}}','info');
    @endif

    @if(session('error'))
    mensajeNotificacion('{{session('error')}}','error');
    @endif


    $('table.data-table1').DataTable({
        order:[0,'desc'],
        columns : [
            {width:"5%"},
            null,
            null,
            null,
            null,
            null,
            null,
            {width:"15%"},
        ],
        scrollCollapse: true,
        language: lenguaje,
        pageLength:10
    });

    // ELIMINAR
    $(document).on('click','table.data-table1 tbody tr td.btns-opciones a.eliminar',function(e){
        e.preventDefault();
        let solicitud = $(this).parents('tr').children('td').eq(2).text();
        $('#mensajeEliminar').html(`¿Está seguro(a) de eliminar la solicitud del lector <b>${solicitud}</b>?<h4>Estación no se podra deshacer después</h4>`);
        let url = $(this).attr('data-url');
        console.log($(this).attr('data-url'));
        $('#formEliminar').prop('action',url);
    });

    $('table.data-table2').DataTable({
        order:[0,'desc'],
        columns : [
            {width:"5%"},
            null,
            null,
            null,
            null,
            {width:"16%"},
        ],
        scrollCollapse: true,
        language: lenguaje,
        pageLength:10
    });
    // ELIMINAR
    $(document).on('click','table.data-table2 tbody tr td.btns-opciones a.eliminar',function(e){
        e.preventDefault();
        let prestamo = $(this).parents('tr').children('td').eq(1).text();
        $('#mensajeEliminar').html(`¿Está seguro(a) de eliminar el prestamo <b>${prestamo}</b>?`);
        let url = $(this).attr('data-url');
        console.log($(this).attr('data-url'));
        $('#formEliminar').prop('action',url);
    });
</script>
{{-- <script src="{{asset('js/home.js')}}"></script> --}}
<script src="{{asset('js/reloj.js')}}"></script>
@endsection


