<?= $this->extend('layouts/docente_layout'); ?>

<?= $this->section('title') ?>
Mis Capacitaciones
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Mis Capacitaciones
<?= $this->endSection() ?>

<?= $this->section('page_description') ?>
Gestiona tus capacitaciones y formación continua
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Mensajes de alerta -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="admin-alert admin-alert-success mb-4">
        <ion-icon name="checkmark-circle-outline" class="w-5 h-5"></ion-icon>
        <span><?= session()->getFlashdata('success') ?></span>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="admin-alert admin-alert-error mb-4">
        <ion-icon name="close-circle-outline" class="w-5 h-5"></ion-icon>
        <span><?= session()->getFlashdata('error') ?></span>
    </div>
<?php endif; ?>

<!-- Cards de estadísticas -->
<div class="admin-dashboard-grid mb-6">
    <!-- Total de Capacitaciones -->
    <div class="admin-dashboard-card">
        <div class="flex items-center justify-between">
            <div>
                <div class="admin-dashboard-stat"><?= $estadisticas['total'] ?? 0 ?></div>
                <div class="admin-dashboard-label">Total Capacitaciones</div>
            </div>
            <div class="admin-avatar admin-avatar-lg bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400">
                <ion-icon name="library-outline" class="w-6 h-6"></ion-icon>
            </div>
        </div>
    </div>

    <!-- Capacitaciones Aprobadas -->
    <div class="admin-dashboard-card">
        <div class="flex items-center justify-between">
            <div>
                <div class="admin-dashboard-stat"><?= $estadisticas['aprobadas'] ?? 0 ?></div>
                <div class="admin-dashboard-label">Aprobadas</div>
            </div>
            <div class="admin-avatar admin-avatar-lg bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400">
                <ion-icon name="checkmark-circle-outline" class="w-6 h-6"></ion-icon>
            </div>
        </div>
    </div>

    <!-- Capacitaciones Pendientes -->
    <div class="admin-dashboard-card">
        <div class="flex items-center justify-between">
            <div>
                <div class="admin-dashboard-stat"><?= $estadisticas['pendientes'] ?? 0 ?></div>
                <div class="admin-dashboard-label">Pendientes</div>
            </div>
            <div
                class="admin-avatar admin-avatar-lg bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-400">
                <ion-icon name="time-outline" class="w-6 h-6"></ion-icon>
            </div>
        </div>
    </div>

    <!-- Puntaje Total -->
    <div class="admin-dashboard-card">
        <div class="flex items-center justify-between">
            <div>
                <div class="admin-dashboard-stat">
                    <?php
                    $puntajeTotal = 0;
                    if (!empty($capacitaciones)) {
                        foreach ($capacitaciones as $cap) {
                            $puntajeTotal += $cap['puntaje_asignado'] ?? 0;
                        }
                    }
                    echo number_format($puntajeTotal, 2);
                    ?>
                </div>
                <div class="admin-dashboard-label">Puntaje Total</div>
            </div>
            <div
                class="admin-avatar admin-avatar-lg bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-400">
                <ion-icon name="star-outline" class="w-6 h-6"></ion-icon>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de capacitaciones -->
<div class="admin-card">
    <div class="admin-card-header">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold admin-text-primary">Lista de Capacitaciones</h3>
                <p class="admin-text-secondary text-sm">Todas tus capacitaciones registradas</p>
            </div>
            <a href="<?= base_url('docente/capacitaciones/create') ?>" class="admin-btn-primary">
                <ion-icon name="add-outline" class="w-5 h-5 mr-2"></ion-icon>
                Nueva Capacitación
            </a>
        </div>
    </div>
    <div class="admin-card-body">
        <table id="export-table">
            <thead>
                <tr>
                    <th>Nombre de la Capacitación</th>
                    <th>Institución</th>
                    <th data-type="date" data-format="YYYY/DD/MM">Fecha Inicio</th>
                    <th data-type="date" data-format="YYYY/DD/MM">Fecha Fin</th>
                    <th>Duración (horas)</th>
                    <th>Puntaje</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($capacitaciones)): ?>
                    <?php foreach ($capacitaciones as $capacitacion): ?>
                        <tr>
                            <td>
                                <div class="flex items-center">
                                    <div>
                                        <div class="admin-text-primary font-medium">
                                            <?= esc($capacitacion['nombre_capacitacion']) ?>
                                        </div>
                                        <div class="admin-text-secondary text-sm">
                                            <?= ucfirst($capacitacion['tipo_participacion']) ?> -
                                            <?= ucfirst($capacitacion['modalidad']) ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><?= esc($capacitacion['institucion_organizadora']) ?></td>
                            <td><?= date('Y/m/d', strtotime($capacitacion['fecha_inicio'])) ?></td>
                            <td><?= date('Y/m/d', strtotime($capacitacion['fecha_fin'])) ?></td>
                            <td><?= $capacitacion['duracion_horas'] ?></td>
                            <td><?= number_format($capacitacion['puntaje_asignado'], 2) ?></td>
                            <td>
                                <?php
                                $estadoClass = '';
                                $estadoText = '';
                                switch ($capacitacion['estado']) {
                                    case 'aprobado':
                                        $estadoClass = 'admin-badge-success';
                                        $estadoText = 'Aprobado';
                                        break;
                                    case 'pendiente':
                                        $estadoClass = 'admin-badge-warning';
                                        $estadoText = 'Pendiente';
                                        break;
                                    case 'rechazado':
                                        $estadoClass = 'admin-badge-danger ';
                                        $estadoText = 'Rechazado';
                                        break;
                                }
                                ?>
                                <span class="admin-badge <?= $estadoClass ?>"><?= $estadoText ?></span>
                            </td>
                            <td>
                                <div class="flex items-center space-x-2">
                                    <?php if ($capacitacion['estado'] === 'pendiente'): ?>
                                        <a href="<?= base_url('docente/capacitaciones/edit/' . $capacitacion['id']) ?>"
                                            class="admin-btn-icon" title="Editar">
                                            <ion-icon name="create-outline" class="w-4 h-4"></ion-icon>
                                        </a>
                                        <button type="button" class="admin-btn-icon text-red-600 hover:text-red-700"
                                            onclick="confirmarEliminar(<?= $capacitacion['id'] ?>)" title="Eliminar">
                                            <ion-icon name="trash-outline" class="w-4 h-4"></ion-icon>
                                        </button>
                                    <?php else: ?>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            <?php if ($capacitacion['estado'] === 'aprobado'): ?>
                                                <ion-icon name="checkmark-circle-outline" class="w-4 h-4 text-green-500"
                                                    title="Aprobado"></ion-icon>
                                            <?php elseif ($capacitacion['estado'] === 'rechazado'): ?>
                                                <ion-icon name="close-circle-outline" class="w-4 h-4 text-red-500"
                                                    title="Rechazado"></ion-icon>
                                            <?php endif; ?>
                                        </span>
                                    <?php endif; ?>

                                    <!-- Botón para ver certificado -->
                                    <?php if (!empty($capacitacion['certificado'])): ?>
                                        <a href="<?= getCapacitacionFile($capacitacion['certificado']) ?>" target="_blank"
                                            class="admin-btn-icon text-blue-600 hover:text-blue-700" title="Ver Certificado">
                                            <ion-icon name="eye-outline" class="w-4 h-4"></ion-icon>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Formulario oculto para eliminar -->
<form id="delete-form" method="POST" style="display: none;">
    <?= csrf_field() ?>
</form>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>

    if (document.getElementById("export-table") && typeof simpleDatatables.DataTable !== 'undefined') {

        const exportCustomCSV = function (dataTable, userOptions = {}) {
            // A modified CSV export that includes a row of minuses at the start and end.
            const clonedUserOptions = {
                ...userOptions
            }
            clonedUserOptions.download = false
            const csv = simpleDatatables.exportCSV(dataTable, clonedUserOptions)
            // If CSV didn't work, exit.
            if (!csv) {
                return false
            }
            const defaults = {
                download: true,
                lineDelimiter: "\n",
                columnDelimiter: ";"
            }
            const options = {
                ...defaults,
                ...clonedUserOptions
            }
            const separatorRow = Array(dataTable.data.headings.filter((_heading, index) => !dataTable.columns.settings[index]?.hidden).length)
                .fill("+")
                .join("+"); // Use "+" as the delimiter

            const str = separatorRow + options.lineDelimiter + csv + options.lineDelimiter + separatorRow;

            if (userOptions.download) {
                // Create a link to trigger the download
                const link = document.createElement("a");
                link.href = encodeURI("data:text/csv;charset=utf-8," + str);
                link.download = (options.filename || "datatable_export") + ".txt";
                // Append the link
                document.body.appendChild(link);
                // Trigger the download
                link.click();
                // Remove the link
                document.body.removeChild(link);
            }

            return str
        }
        const table = new simpleDatatables.DataTable("#export-table", {
            classes: {
                table: "admin-table datatable-table w-full text-sm text-left",
                top: "admin-table-topbar datatable-top",
                container: "datatable-container",
                bottom: "admin-table-bottombar datatable-bottom",
                pagination: "admin-pagination datatable-pagination",
                info: "datatable-info",
                input: "datatable-search-input",
                search: "datatable-search",
                dropdown: "datatable-dropdown",
                selector: "datatable-select",
                empty: "datatable-empty",
                export: "datatable-export"
            },
            labels: {
                placeholder: "Buscar capacitaciones...",
                perPage: "Mostrar resultados",
                noRows: "No hay capacitaciones para mostrar",
                info: "Mostrando {start} a {end} de {rows} resultados",
                noResults: "No se encontraron capacitaciones",
                loading: "Cargando...",
                pagination: {
                    previous: "Anterior",
                    next: "Siguiente",
                    first: "Primero",
                    last: "Último"
                }
            },
            template: (options, dom) =>
                // TOP BAR
                "<div class='" + options.classes.top + "'>" +
                // IZQUIERDA: SELECTOR ENTRIES
                (options.paging && options.perPageSelect ?
                    "<div class='" + options.classes.dropdown + " flex-shrink-0'>" +
                    "<label class='flex items-center space-x-2'>" +
                    "<span class='text-sm ml-2'>" + options.labels.perPage + "</span>" +
                    "<select class='" + options.classes.selector + " ml-2 cursor-pointer'></select>" +
                    "</label>" +
                    "</div>"
                    : "") +
                // DERECHA: BUSCADOR + EXPORTAR (siempre en fila)
                "<div class='flex flex-row items-center gap-3 sm:ml-auto'>" +
                (options.searchable ?
                    "<div class='" + options.classes.search + "'>" +
                    "<input class='" + options.classes.input + "' placeholder='" + options.labels.placeholder + "' type='search' title='" + options.labels.searchTitle + "'" + (dom.id ? " aria-controls='" + dom.id + "'" : "") + ">" +
                    "</div>"
                    : "") +
                // Botón exportar
                "<button id='exportDropdownButton' type='button' class='flex items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 datatable-export cursor-pointer'>" +
                "Exportar" +
                "<svg class='-me-0.5 ms-1.5 h-4 w-4' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' viewBox='0 0 24 24'>" +
                "<path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m19 9-7 7-7-7' />" +
                "</svg>" +
                "</button>" +
                // Dropdown exportar
                "<div id='exportDropdown' class='z-10 hidden w-52 divide-y divide-gray-100 rounded-lg bg-white shadow-sm dark:bg-gray-700' data-popper-placement='bottom'>" +
                "<ul class='p-2 text-left text-sm font-medium text-gray-500 dark:text-gray-400' aria-labelledby='exportDropdownButton'>" +
                "<li>" +
                "<button id='export-csv' class='group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer'>" +
                "<svg class='me-1.5 h-4 w-4 text-gray-400 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' viewBox='0 0 24 24'>" +
                "<path fill-rule='evenodd' d='M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2 2 2 0 0 0 2 2h12a2 2 0 0 0 2-2 2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2h-7Zm1.018 8.828a2.34 2.34 0 0 0-2.373 2.13v.008a2.32 2.32 0 0 0 2.06 2.497l.535.059a.993.993 0 0 0 .136.006.272.272 0 0 1 .263.367l-.008.02a.377.377 0 0 1-.018.044.49.49 0 0 1-.078.02 1.689 1.689 0 0 1-.297.021h-1.13a1 1 0 1 0 0 2h1.13c.417 0 .892-.05 1.324-.279.47-.248.78-.648.953-1.134a2.272 2.272 0 0 0-2.115-3.06l-.478-.052a.32.32 0 0 1-.285-.341.34.34 0 0 1 .344-.306l.94.02a1 1 0 1 0 .043-2l-.943-.02h-.003Zm7.933 1.482a1 1 0 1 0-1.902-.62l-.57 1.747-.522-1.726a1 1 0 0 0-1.914.578l1.443 4.773a1 1 0 0 0 1.908.021l1.557-4.773Zm-13.762.88a.647.647 0 0 1 .458-.19h1.018a1 1 0 1 0 0-2H6.647A2.647 2.647 0 0 0 4 13.647v1.706A2.647 2.647 0 0 0 6.647 18h1.018a1 1 0 1 0 0-2H6.647A.647.647 0 0 1 6 15.353v-1.706c0-.172.068-.336.19-.457Z' clip-rule='evenodd'/>" +
                "</svg>" +
                "<span>Exportar CSV</span>" +
                "</button>" +
                "</li>" +
                "<li>" +
                "<button id='export-json' class='group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer'>" +
                "<svg class='me-1.5 h-4 w-4 text-gray-400 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' viewBox='0 0 24 24'>" +
                "<path fill-rule='evenodd' d='M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7Zm-.293 9.293a1 1 0 0 1 0 1.414L9.414 14l1.293 1.293a1 1 0 0 1-1.414 1.414l-2-2a1 1 0 0 1 0-1.414l2-2a1 1 0 0 1 1.414 0Zm2.586 1.414a1 1 0 0 1 1.414-1.414l2 2a1 1 0 0 1 0 1.414l-2 2a1 1 0 0 1-1.414-1.414L14.586 14l-1.293-1.293Z' clip-rule='evenodd'/>" +
                "</svg>" +
                "<span>Exportar JSON</span>" +
                "</button>" +
                "</li>" +
                "<li>" +
                "<button id='export-txt' class='group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer'>" +
                "<svg class='me-1.5 h-4 w-4 text-gray-400 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' viewBox='0 0 24 24'>" +
                "<path fill-rule='evenodd' d='M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7ZM8 16a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1-5a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z' clip-rule='evenodd'/>" +
                "</svg>" +
                "<span>Exportar TXT</span>" +
                "</button>" +
                "</li>" +
                "<li>" +
                "<button id='export-sql' class='group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer'>" +
                "<svg class='me-1.5 h-4 w-4 text-gray-400 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' viewBox='0 0 24 24'>" +
                "<path d='M12 7.205c4.418 0 8-1.165 8-2.602C20 3.165 16.418 2 12 2S4 3.165 4 4.603c0 1.437 3.582 2.602 8 2.602ZM12 22c4.963 0 8-1.686 8-2.603v-4.404c-.052.032-.112.06-.165.09a7.75 7.75 0 0 1-.745.387c-.193.088-.394.173-.6.253-.063.024-.124.05-.189.073a18.934 18.934 0 0 1-6.3.998c-2.135.027-4.26-.31-6.3-.998-.065-.024-.126-.05-.189-.073a10.143 10.143 0 0 1-.852-.373 7.75 7.75 0 0 1-.493-.267c-.053-.03-.113-.058-.165-.09v4.404C4 20.315 7.037 22 12 22Zm7.09-13.928a9.91 9.91 0 0 1-.6.253c-.063.025-.124.05-.189.074a18.935 18.935 0 0 1-6.3.998c-2.135.027-4.26-.31-6.3-.998-.065-.024-.126-.05-.189-.074a10.163 10.163 0 0 1-.852-.372 7.816 7.816 0 0 1-.493-.268c-.055-.03-.115-.058-.167-.09V12c0 .917 3.037 2.603 8 2.603s8-1.686 8-2.603V7.596c-.052.031-.112.059-.165.09a7.816 7.816 0 0 1-.745.386Z'/>" +
                "</svg>" +
                "<span>Exportar SQL</span>" +
                "</button>" +
                "</li>" +
                "</ul>" +
                "</div>" +
                "</div>" +
                "</div>" +
                // TABLE CONTAINER
                "<div class='" + options.classes.container + "'" + (options.scrollY.length ? " style='height: " + options.scrollY + "; overflow-Y: auto;'" : "") + "></div>" +
                // BOTTOM BAR
                "<div class='" + options.classes.bottom + " flex flex-row items-center w-full'>" +
                // IZQUIERDA: INFO
                (options.paging ?
                    "<div class='flex-shrink-0 " + options.classes.info + " text-sm text-gray-600 dark:text-gray-300'></div>"
                    : "") +
                // DERECHA: PAGINADOR
                "<nav class='ml-auto " + options.classes.pagination + "'></nav>" +
                "</div>"
        })
        const $exportButton = document.getElementById("exportDropdownButton");
        const $exportDropdownEl = document.getElementById("exportDropdown");
        const dropdown = new Dropdown($exportDropdownEl, $exportButton);
        console.log(dropdown)

        document.getElementById("export-csv").addEventListener("click", () => {
            simpleDatatables.exportCSV(table, {
                download: true,
                lineDelimiter: "\n",
                columnDelimiter: ";"
            })
        })
        document.getElementById("export-sql").addEventListener("click", () => {
            simpleDatatables.exportSQL(table, {
                download: true,
                tableName: "export_table"
            })
        })
        document.getElementById("export-txt").addEventListener("click", () => {
            simpleDatatables.exportTXT(table, {
                download: true
            })
        })
        document.getElementById("export-json").addEventListener("click", () => {
            simpleDatatables.exportJSON(table, {
                download: true,
                space: 3
            })
        })
    }

    // Función para confirmar eliminación
    function confirmarEliminar(id) {
        if (confirm('¿Estás seguro de que deseas eliminar esta capacitación? Esta acción no se puede deshacer.')) {
            const form = document.getElementById('delete-form');
            form.action = `<?= base_url('docente/capacitaciones/delete/') ?>/${id}`;
            form.submit();
        }
    }

</script>
<?= $this->endSection() ?>