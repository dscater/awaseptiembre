let materia_id = $("#materia_id");
let materia_profesor = $("#materia_profesor");
let inscripcion_id = $("#inscripcion_id");
let txt_inscripcion_id = $("#txt_inscripcion_id");
$(document).ready(function () {
    obtieneEstudiantes();
    materia_profesor.change(obtieneEstudiantes);
});

function obtieneEstudiantes() {
    if (materia_profesor.val() != '') {
        $.ajax({
            type: "GET",
            url: $('#urlEstudiantes').val(),
            data: {
                materia: materia_profesor.val(),
            },
            dataType: "json",
            success: function (response) {
                $('#inscripcion_id').html(response.lista_options);
                materia_id.val(response.materia_id);
                if (txt_inscripcion_id.val() != "") {
                    inscripcion_id.val(txt_inscripcion_id.val());
                }
            }
        });
    } else {
        $('#contenedor_materias').html("");
        materia_id.val("");
    }
}


