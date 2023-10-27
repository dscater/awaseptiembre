 <!-- Info boxes -->
 <div class="row">
     <div class="col-12 col-sm-6 col-md-3">
         <div class="info-box">
             <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
             <div class="info-box-content">
                 <span class="info-box-text">Administrativos</span>
                 <span class="info-box-number">{{ $administrativos }}</span>
             </div>
             <!-- /.info-box-content -->
         </div>
         <!-- /.info-box -->
     </div>
     <!-- /.col -->
     <div class="col-12 col-sm-6 col-md-3">
         <div class="info-box mb-3">
             <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>

             <div class="info-box-content">
                 <span class="info-box-text">Profesores</span>
                 <span class="info-box-number">{{ $profesors }}</span>
             </div>
             <!-- /.info-box-content -->
         </div>
         <!-- /.info-box -->
     </div>
     <!-- /.col -->

     <div class="col-12 col-sm-6 col-md-3">
         <div class="info-box mb-3">
             <span class="info-box-icon bg-orange elevation-1"><i class="fas fa-users"></i></span>

             <div class="info-box-content">
                 <span class="info-box-text">Estudiantes</span>
                 <span class="info-box-number">{{ $estudiantes }}</span>
             </div>
             <!-- /.info-box-content -->
         </div>
         <!-- /.info-box -->
     </div>
     <!-- /.col -->

     <div class="col-12 col-sm-12 col-md-12">
         <div class="card">
             <div class="card-body text-center">
                 <div id="contenedorFecha" style="flex-direction: column;">
                     <span id="txtFecha"></span>
                     <span id="txtHora"></span>
                 </div>
             </div>
         </div>
     </div>

 </div>

 <input type="hidden" id="urlInfoIngresosEconomicos" value="{{ route('pago_estudiantes.ingresos_economicos') }}">
 <input type="hidden" id="urlInfoCantidadEstudiantes" value="{{ route('inscripcions.cantidad_estudiantes') }}">
