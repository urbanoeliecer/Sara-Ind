document.addEventListener("DOMContentLoaded", function () {
    const RUTA_CONTROLADOR = "../back/vstInter.php";
    const form = document.getElementById("formFiltros");
    const selDepartamento = document.getElementById("departamento");
    const selMunicipio = document.getElementById("municipio");
    const selJunta = document.getElementById("junta");
    const fechaInicioInput = document.getElementById("fecha_inicio");
    const fechaFinInput = document.getElementById("fecha_fin");
    // CARGAR DEPARTAMENTOS
    function cargarDepartamentos() {
        fetch(`${RUTA_CONTROLADOR}?accion=departamentos`)
            .then(r => r.json())
            .then(data => {
                selDepartamento.innerHTML =
                    `<option value="">Seleccione...</option>`;
                data.forEach(d => {
                    selDepartamento.innerHTML +=
                        `<option value="${d.iddepartamento}">${d.nombre}</option>`;
                });
            })
            .catch(err => console.error("Error cargando departamentos", err));
    }
    //   CARGAR MUNICIPIOS
    function cargarMunicipios() {
        const idDepartamento = selDepartamento.value;
        if (!idDepartamento) return;
        fetch(`${RUTA_CONTROLADOR}?accion=municipios&iddepartamento=${idDepartamento}`)
            .then(r => r.json())
            .then(data => {
                selMunicipio.innerHTML =
                    `<option value="">Seleccione...</option>`;
                selJunta.innerHTML =
                    `<option value="">Seleccione...</option>`;

                data.forEach(m => {
                    selMunicipio.innerHTML +=
                        `<option value="${m.idmunicipio}">${m.nombre}</option>`;
                });
            })
            .catch(err => console.error("Error cargando municipios", err));
    }
    // CARGAR JUNTAS 
    function cargarJuntas() {
        const idMunicipio = selMunicipio.value;
        if (!idMunicipio) return;

        fetch(`${RUTA_CONTROLADOR}?accion=juntas&idmunicipio=${idMunicipio}`)
            .then(r => r.json())
            .then(data => {
                selJunta.innerHTML =
                    `<option value="">Seleccione junta</option>`;
                data.forEach(j => {
                    selJunta.innerHTML +=
                        `<option value="${j.idjunta}">${j.nombre}</option>`;
                });
            })
            .catch(err => console.error("Error cargando juntas", err));
    }
    /* CONSULTAR PROYECTOS */
    function consultarProyectos(e) {
        e.preventDefault();
        let fechaInicio = fechaInicioInput.value;
        let fechaFin = fechaFinInput.value;
        if (!fechaInicio || !fechaFin) 
        {  fechaInicio = "0000-00-00";
           fechaFin = "9999-12-31"; 
        }
        const data = new FormData();
        data.append("fecha_inicio", fechaInicio);
        data.append("fecha_fin", fechaFin);
        //data.append("iddepartamento", selDepartamento.value);
        //data.append("idmunicipio", selMunicipio.value);
        //data.append("idjunta", selJunta.value);
        fetch(`${RUTA_CONTROLADOR}?accion=consultar`, {
            method: "POST",
            body: data
        })
        .then(r => r.json())
        .then(resp => {
            if (resp.error) {
                console.error(resp.error);
                alert("Error en el servidor");
                return;
            }
            if (!resp.resumen) { alert("No hay información"); return; }
            const r = resp.resumen;
            document.getElementById("resumen").innerHTML = `
                <br><b>Total proyectos:</b> ${r.total_proyectos}
                <br><b>Total monto:</b> ${r.total_monto ?? 0}
                <br><b>Total beneficiarios:</b> ${r.total_beneficiarios ?? 0}`;
            if (!resp.detalle || resp.detalle.length === 0) {
                document.getElementById("detalle").innerHTML = "<p>No hay detalle de proyectos</p>"; return;
            }
            let fila = 1;
            let maxMonto = 5000;
            let maxBeneficiarios = 20;

            let html = `<table border="1" width="100%">
            <tr>
            <th>#</th>
            <th>Proyecto</th>
            <th>Dinero</th>
            <th>-</th>
            <th>Benef.</th>
            <th>-</th>
            <th>Junta</th>
            <th>Municipio</th>
            <th>Departamento</th>
            </tr>`;

            resp.detalle.forEach(d => {

                let ancho1 = maxMonto ? (d.monto * 100) / maxMonto : 0;
                let ancho2 = maxBeneficiarios ? (d.beneficiarios * 100) / maxBeneficiarios : 0;

                // limitar a 100%
                ancho1 = Math.min(ancho1, 100);
                ancho2 = Math.min(ancho2, 100);
                // redondear
                let porc1 = Math.round(ancho1);
                let porc2 = Math.round(ancho2);
                html += `<tr>
                    <td>${fila}</td>
                    <td>${d.proyecto}</td>
                    <td>${d.monto}</td>
                    <td>
                        <img src="../img/barra.png" height="16" width="${ancho1}">
                        ${porc1}%
                    </td>
                    <td>${d.beneficiarios}</td>
                    <td>
                        <img src="../img/barra.png" height="16" width="${ancho2}">
                        ${porc2}%
                    </td>
                    <td>${d.junta}</td>
                    <td>${d.municipio}</td>
                    <td>${d.departamento}</td>
                </tr>`;

                fila++;
            });

            html += "</table>";
            document.getElementById("detalle").innerHTML = html;
        })
        .catch(err => console.error("Error en consulta", err));
    }
    /* EVENTOS */
    //cargarDepartamentos();
    //selDepartamento.addEventListener("change", cargarMunicipios);
    //selMunicipio.addEventListener("change", cargarJuntas);
    form.addEventListener("submit", consultarProyectos);
});