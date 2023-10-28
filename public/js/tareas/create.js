let link = `<div class="input-group col-12 link mb-1">
<input type="text" name="links[]" placeholder="Ingresar Link" class="form-control" required>
<span class="input-group-append"><button class="btn btn-danger" type="button"><i
            class="fa fa-times"></i></button></span>
</div>`;
let vacio = `<div class="vacio col-12">
<h4 class="w-100 text-center text-gray text-md">NO SE CARGARÓN LINKS</h4>
</div>`;
let input_eliminado = `<input type="hidden" value="0" name="eliminados[]"/>`;

let btnAgregarLink = $("#btnAgregarLink");
let contenedor_links = $("#contenedor_links");
let contenedor_eliminados = $("#contenedor_eliminados");
let select_gestion = $("#select_gestion");
let select_materia = $("#select_materia");

$(document).ready(function () {
    obtieneMaterias();
    verificaLinks();
    btnAgregarLink.click(agregarLink);

    contenedor_links.on("click", ".link button", function (e) {
        e.preventDefault();
        let link = $(this).parents(".link");
        if (link.hasClass("existe")) {
            let id = link.attr("data-id");
            let eliminado = $(input_eliminado).clone();
            eliminado.val(id);
            contenedor_eliminados.append(eliminado);
        }
        link.remove();
        verificaLinks();
    });
});

function verificaLinks() {
    let links = contenedor_links.children(".link");
    if (links.length > 0) {
        contenedor_links.children(".vacio").remove();
    } else {
        contenedor_links.html(vacio);
    }
}

function agregarLink() {
    let nuevo_link = $(link).clone();
    contenedor_links.append(nuevo_link);
    verificaLinks();
}

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
