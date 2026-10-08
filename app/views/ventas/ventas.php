<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listado de Ventas</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome 6 Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
  <style>
    body { background-color: #f4f6f8; font-family: system-ui, -apple-system, sans-serif; color: #334155; }
    .card-stat { border-radius: 12px; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .stat-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
    .bg-icon-blue { background-color: #e0f2fe; color: #0284c7; }
    .bg-icon-red { background-color: #ffe4e6; color: #e11d48; }
    .bg-icon-yellow { background-color: #fef9c3; color: #ca8a04; }
    .bg-icon-green { background-color: #dcfce7; color: #16a34a; }
    .table-container { border-radius: 12px; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.05); background: white; }
    .table thead th { background-color: #f8fafc; color: #475569; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700; padding: 1rem; border-bottom: 1px solid #e2e8f0; }
    .table tbody td { padding: 0.85rem 1rem; vertical-align: middle; border-bottom: 1px solid #f1f5f9; font-size: 0.875rem; }
    .badge-stock { padding: 0.25rem 0.65rem; border-radius: 20px; font-weight: 600; font-size: 0.75rem; }
    .badge-ok { background-color: #dcfce7; color: #15803d; }
    .badge-out { background-color: #ffe4e6; color: #be123c; }
    .badge-critical { background-color: yellow; color: #be123c; }
    .badge-critical {
        background-color: #fef9c3; /* Amarillo suave/pastel */
        color: #854d0e;            /* Texto e icono en tono café/miel */
        border: 1px solid #fef08a; /* Borde delicado */
    }
    .btn-action { color: #64748b; padding: 0.2rem 0.4rem; font-size: 0.9rem; }
    .btn-action:hover { color: #0f172a; }
  </style>
</head>
<body class="p-3 p-md-4">
  <?=$topbar?>
  <div class="container-fluid max-w-7xl mx-auto" style="max-width: 1400px;">
    
    <header class="d-flex justify-content-between align-items-center mb-4">
      <div class="d-flex align-items-center gap-3">
        <div>
          <small class="text-secondary fw-semibold">Listado de Ventas</small>
        </div>
      </div>
      <a href="<?=$ruta?>ventas/nueva_venta" class="btn btn-primary fw-semibold px-3 py-2 rounded-3 shadow-sm">
        <i class="fa-solid fa-plus me-1"></i> Nueva Venta
      </a>
    </header>

    <div class="row g-3 mb-4">
      <div class="col-12 col-sm-6 col-lg-4">
        <div class="card card-stat p-3 bg-white">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <span class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">TOTAL VENTAS</span>
              <h2 class="fw-bold mb-0 mt-1 text-dark"><?=count($ventas)?></h2>
            </div>
            <div class="stat-icon bg-icon-blue"><i class="fa-solid fa-box-archive"></i></div>
          </div>
        </div>
      </div>
    </div>


    <div class="table-container table-responsive">
      <table class="table mb-0 align-middle">
        <thead>
          <tr>
            <th>VENDEDOR</th>
            <th>CLIENTE</th>
            <th>FECHA VENTA</th>
            <th>PRECIO VENTA</th>
            <th>ESTADO</th>
            <th class="text-center">ACCIONES</th>
          </tr>
        </thead>
        <tbody class="fw-semibold text-secondary">
            <?php
                foreach ($ventas as $v) {
                    $id = $v->id_venta;
                    $cliente = $v->cliente;
                    $vendedor = $v->vendedor;
                    $fecha = $v->fecha_venta;
                    $precio = number_format($v->precio_venta,2,',','.');
                    $estado = $v->estado;

                    if ($estado == 0) {
                        $estado_final = '<span class="badge-stock badge-out">&bull; Inactivo</span>';
                    }else{
                        $estado = '<span class="badge-stock badge-ok">Activo</span>';
                    }

                    echo '<tr>
                        <td>'.$vendedor.'</td>
                        <td class="text-dark fw-bold">'.strtoupper($cliente).'</td>
                        <td>'.$fecha.'</td>
                        <td>$'.$precio.'</td>
                        <td class="text-dark fw-bold">'.$estado.'</td>
                        <td class="text-center">
                          <a href="'.$ruta.'ventas/ver_venta/'.$id.'" class="btn btn-action"><i class="fa-regular fa-eye"></i></a>
                          <a href="'.$ruta.'ventas/eliminar_venta/'.$id.'" class="btn btn-action"><i class="fa-regular fa-trash-can"></i></a>
                        </td>
                    </tr>';
                }
            ?>
        </tbody>
      </table>
    </div>

  </div>
</body>
</html>