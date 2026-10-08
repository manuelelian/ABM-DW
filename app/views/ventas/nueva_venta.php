<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agregar Venta</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body {
      background-color: #f8fafc;
      color: #1e293b;
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
    }
  </style>
  <?=$head?>
  <?=$js?>

</head>
<body>

  <!-- Header -->
  <nav class="navbar navbar-expand-lg bg-white border-bottom py-3 mb-4">
    <div class="container-fluid px-4">
      <div class="d-flex align-items-center gap-3">
        <a href="<?=$ruta?>ventas" class="btn btn-outline-secondary fw-semibold px-3 py-2 rounded-3">
          <i class="fa-solid fa-arrow-left me-1"></i> Volver al listado
        </a>
      </div>
    </div>
  </nav>

  <!-- Formulario -->
  <div class="container py-2" style="max-width: 850px;">
    <div class="card shadow-sm border-0 rounded-4 mb-4">
      
      <!-- Encabezado de la Card -->
      <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 text-dark">
          Agregar Venta
        </h5>
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill">
          Alta de Venta
        </span>
      </div>

      <!-- Cuerpo del Formulario -->
      <div class="card-body p-4">
        <form action="" method="POST">
          
          <div class="row g-3">
            <!-- Cliente -->
            <div class="col-md-6">
              <label for="cliente" class="form-label small fw-bold text-secondary">Cliente</label>
              <select class="form-select bg-light" name="cliente" id="cliente">
                <option value="1" <?= (isset($datos['cliente']) && $datos['cliente'] == '1') ? 'selected' : '' ?>>Consumidor Final</option>
                <option value="2" <?= (isset($datos['cliente']) && $datos['cliente'] == '2') ? 'selected' : '' ?>>Juan Perez</option>
              </select>
            </div>

            <!-- Forma Pago -->
            <div class="col-md-6">
              <label for="fp" class="form-label small fw-bold text-secondary">Forma Pago</label>
              <select class="form-select bg-light" name="fp" id="fp">
                <option value="1" <?= (isset($datos['fp']) && $datos['fp'] == '1') ? 'selected' : '' ?>>Efectivo</option>
                <option value="2" <?= (isset($datos['fp']) && $datos['fp'] == '2') ? 'selected' : '' ?>>Transferencia</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="producto" class="form-label small fw-bold text-secondary">Productos</label>
              <select class="form-select bg-light" name="producto" id="producto">
                <?php      
                    for ($i = 0; $i < count($productos); $i++) {
                      $seleccionado = (isset($datos['producto']) && (int)$datos['producto'] === $productos[$i]->id) ? 'selected' : '';
                      echo '<option value="' . $productos[$i]->id . '" ' . $seleccionado . '>' . $productos[$i]->nombre . ' - '.$productos[$i]->codigo_barras.' - $'.$productos[$i]->precio_venta.'</option>';
                    }
                ?>
              </select>
              <?php if (!empty($error_msg['productos'])): ?>
                  <div class="invalid-feedback d-block mt-1">
                      <i class="fa-solid fa-circle-exclamation me-1"></i><?= $error_msg['productos'] ?>
                  </div>
                <?php endif; ?>
            </div>

            <!-- Cantidad -->
            <div class="col-md-4">
              <label for="cantidad" class="form-label small fw-bold text-secondary">Cantidad</label>
              <div class="input-group">
                <input type="number" step="1" min="1" class="form-control bg-light" id="cantidad" name="cantidad" placeholder="1" value="<?= $datos['cantidad'] ?>">
              </div>
            </div>
            <div class="col-md-2">
              <label for="agregar" class="form-label small fw-bold text-secondary">Agregar</label>
              <div class="input-group">
                <button type="button" class="btn btn-primary px-4 fw-semibold rounded-3" id="agregar">
                  +
                </button>
              </div>
            </div>
          </div>

          <!-- Alertas de Mensaje -->
          <div class="col-12 d-flex justify-content-center mt-3">
            <?php if (($error ?? false) === false): ?>
                <?php if (!empty($mensajeOk)): ?>
                    <div class="alert alert-success d-flex align-items-center rounded-3 px-3 py-2 border-0 shadow-sm w-100 mb-0" role="alert">
                        <i class="fa-solid fa-circle-check me-2 fs-5"></i>
                        <div><?= htmlspecialchars($mensajeOk) ?></div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($mensajeNoOk)): ?>
                    <div class="alert alert-danger d-flex align-items-center rounded-3 px-3 py-2 border-0 shadow-sm w-100 mb-0" role="alert">
                        <i class="fa-solid fa-circle-xmark me-2 fs-5"></i>
                        <div><?= htmlspecialchars($mensajeNoOk) ?></div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
          </div>

          <!-- Tabla de Productos Agregados -->
          <div class="mt-4 pt-3 border-top">
            <h6 class="fw-bold text-secondary mb-3">Detalle de la Venta</h6>
            <div class="table-responsive rounded-3 border">
              <table class="table align-middle mb-0">
                <thead class="table-light border-bottom">
                  <tr>
                    <th scope="col" class="ps-3 text-secondary small fw-bold">NOMBRE</th>
                    <th scope="col" class="text-secondary small fw-bold text-center" style="width: 120px;">CANTIDAD</th>
                    <th scope="col" class="text-secondary small fw-bold text-end" style="width: 130px;">PRECIO</th>
                    <th scope="col" class="text-secondary small fw-bold text-end" style="width: 140px;">SUBTOTAL</th>
                    <th scope="col" class="pe-3 text-center" style="width: 90px;">ACCIONES</th>
                  </tr>
                </thead>
                <tbody id="tabla-productos">
                </tbody>
                <!-- Pie de tabla con Total General -->
                <tfoot class="table-light border-top">
                  <tr>
                    <td colspan="3" class="text-end fw-bold text-secondary pe-2">TOTAL:</td>
                    <td class="text-end fw-bold fs-6 font-monospace text-primary" id="total">$0,00</td>
                    <td></td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>

          <!-- Botones de Acción -->
          <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
            <a href="<?=$ruta?>productos" class="btn btn-light border px-4 fw-medium rounded-3">Cancelar</a>
            <button type="submit" class="btn btn-primary px-4 fw-semibold rounded-3">
              Guardar Venta
            </button>
          </div>

        </form>
      </div>

    </div>
  </div>

  <!-- Bootstrap 5 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>