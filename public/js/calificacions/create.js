let vacio = `<tr class="vacio">
<td colspan="30" class="text-center">No se encontrarón registros</td>
</tr>`;

let select_gestion = $("#select_gestion");
let select_materia = $("#select_materia");
let select_inscripcion = $("#select_inscripcion");
$(document).ready(function () {
    obtieneMaterias();
    obtieneEstudiantes();
    select_materia.change(obtieneEstudiantes);

    select_gestion.change(function () {
        obtieneMaterias();
        obtieneEstudiantes();
    });
});

function obtieneMaterias() {
    if (select_gestion.val() != "") {
        $.ajax({
            type: "GET",
            url: $("#urlMaterias").val(),
            data: {
                profesor: $("#prof").val(),
                gestion: select_gestion.val(),
            },
            dataType: "json",
            success: function (response) {
                select_materia.html(response);
            },
        });
    } else {
        select_materia.html("");
    }
}

function obtieneEstudiantes() {
    if (
        select_gestion.val() != "" &&
        select_materia.val() != "" &&
        select_gestion.val() != null &&
        select_materia.val() != null
    ) {
        $.ajax({
            type: "GET",
            url: $("#urlEstudiantes").val(),
            data: {
                materia: select_materia.val(),
                gestion: select_gestion.val(),
            },
            dataType: "json",
            success: function (response) {
                select_inscripcion.html(response.html);
            },
        });
    } else {
        select_inscripcion.html("");
    }
}
