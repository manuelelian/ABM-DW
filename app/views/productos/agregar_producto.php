<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agregar Producto </title>
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
</head>
<body>

  <!-- Header -->
  <nav class="navbar navbar-expand-lg bg-white border-bottom py-3 mb-4">
    <div class="container-fluid px-0">
      <div class="d-flex align-items-center gap-3">
      <a href="<?=$ruta?>productos" class="btn btn-outline-secondary fw-semibold px-3 py-2 rounded-3">
        <i class="fa-solid fa-arrow-left me-1"></i> Volver al listado
      </a>
    </div>
  </nav>

  <!-- Formulario -->
  <div class="container py-2" style="max-width: 850px;">
    <div class="card shadow-sm border-0 rounded-4">
      
      <!-- Encabezado de la Card -->
      <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 text-dark">
          Agregar Producto
        </h5>
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill">
          Alta de Inventario
        </span>
      </div>

      <!-- Cuerpo del Formulario -->
      <div class="card-body p-4">
        <form action="" method="POST">
          
          <div class="row g-3">
            
            <!-- Código de Barras -->
            <div class="col-md-4">
              <label for="cod_barras" class="form-label small fw-bold text-secondary">CÓDIGO DE BARRAS</label>
              <div class="input-group">
                <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-barcode"></i></span>
                <input type="text" class="form-control bg-light" name="cod_barras" placeholder="Ej: 7798184680042" autofocus value="<?= $datos['cod_barras'] ?>">
              </div>
            </div>

            <!-- Nombre del Producto -->
            <div class="col-md-8">
              <label for="producto" class="form-label small fw-bold text-secondary">NOMBRE DEL PRODUCTO</label>
              <input type="text" class="form-control bg-light" name="producto" placeholder="Ej: AROMATIZADOR TEXTIL BUBBLEGUM" value="<?= $datos['producto'] ?>">
              <?php if (!empty($error_msg['producto'])): ?>
                  <div class="invalid-feedback d-block mt-1">
                      <i class="fa-solid fa-circle-exclamation me-1"></i><?= $error_msg['producto'] ?>
                  </div>
                <?php endif; ?>
            </div>

            <!-- Categoría -->
            <div class="col-md-6">
              <label for="id_categoria" class="form-label small fw-bold text-secondary">CATEGORÍA</label>
              <select class="form-select bg-light" name="categoria">
                <option value="Limpieza" <?= (isset($datos['categoria']) && $datos['categoria'] == 'Limpieza') ? 'selected' : '' ?>>Limpieza</option>
                <option value="Comida" <?= (isset($datos['categoria']) && $datos['categoria'] == 'Comida') ? 'selected' : '' ?>>Comida</option>
              </select>
            </div>

            <!-- Marca -->
            <div class="col-md-6">
              <label for="id_marca" class="form-label small fw-bold text-secondary">MARCA</label>
              <select class="form-select bg-light" name="marca">
                <option value="Saphirus" <?= (isset($datos['marca']) && $datos['marca'] == 'Saphirus') ? 'selected' : '' ?>>Saphirus</option>
                <option value="Otra Marca" <?= (isset($datos['marca']) && $datos['marca'] == 'Otra Marca') ? 'selected' : '' ?>>Otra Marca</option>
              </select>
            </div>

            <!-- Precio Costo -->
            <div class="col-md-4">
              <label for="precio_costo" class="form-label small fw-bold text-secondary">PRECIO COSTO ($)</label>
              <div class="input-group">
                <span class="input-group-text bg-light text-muted">$</span>
                <input type="number" step="0.01" min="0" class="form-control bg-light" name="precio_costo" placeholder="1500.00" value="<?= $datos['precio_costo'] ?>">
                <?php if (!empty($error_msg['precio_costo'])): ?>
                  <div class="invalid-feedback d-block mt-1">
                      <i class="fa-solid fa-circle-exclamation me-1"></i><?= $error_msg['precio_costo'] ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>

            <!-- Precio Venta -->
            <div class="col-md-4">
              <label for="precio_venta" class="form-label small fw-bold text-secondary">PRECIO VENTA ($)</label>
              <div class="input-group">
                <span class="input-group-text bg-light text-muted">$</span>
                <input type="number" step="0.01" min="0" class="form-control bg-light" name="precio_venta" placeholder="2000.00" value="<?= $datos['precio_venta'] ?>">
                 <?php if (!empty($error_msg['precio_venta'])): ?>
                  <div class="invalid-feedback d-block mt-1">
                      <i class="fa-solid fa-circle-exclamation me-1"></i><?= $error_msg['precio_venta'] ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>

            <!-- Unidad de Medida -->
            <div class="col-md-4">
              <label for="unidad" class="form-label small fw-bold text-secondary">UNIDAD DE MEDIDA</label>
              <select class="form-select bg-light" name="unidad">
                <option value="UN" <?= (isset($datos['unidad']) && $datos['unidad'] == 'UN') ? 'selected' : '' ?>>UN (Unidad)</option>
                <option value="KG" <?= (isset($datos['unidad']) && $datos['unidad'] == 'KG') ? 'selected' : '' ?>>KG (Kilogramos)</option>
                <option value="LT" <?= (isset($datos['unidad']) && $datos['unidad'] == 'LT') ? 'selected' : '' ?>>LT (Litros)</option>
              </select>
            </div>

            <!-- Stock Inicial -->
            <div class="col-md-6">
              <label for="stock_actual" class="form-label small fw-bold text-secondary">STOCK INICIAL</label>
              <input type="number" min="0" class="form-control bg-light" name="stock_actual" value="<?= $datos['stock_actual'] ?>">
               <?php if (!empty($error_msg['stock_actual'])): ?>
                  <div class="invalid-feedback d-block mt-1">
                      <i class="fa-solid fa-circle-exclamation me-1"></i><?= $error_msg['stock_actual'] ?>
                  </div>
                <?php endif; ?>
            </div>

            <!-- Stock Mínimo (Límite para Stock Crítico) -->
            <div class="col-md-6">
              <label for="stock_minimo" class="form-label small fw-bold text-secondary">STOCK MÍNIMO (CRÍTICO)</label>
              <input type="number" min="1" class="form-control bg-light" name="stock_minimo" value="<?= $datos['stock_minimo'] ?>">
                <?php if (!empty($error_msg['stock_minimo'])): ?>
                  <div class="invalid-feedback d-block mt-1">
                      <i class="fa-solid fa-circle-exclamation me-1"></i><?= $error_msg['stock_minimo'] ?>
                  </div>
                <?php endif; ?>
              <div class="form-text small">Límite a partir del cual se marcará como stock crítico.</div>
            </div>

          </div>

          <div class="col-12 d-flex justify-content-center">
            <?php if ($error === false): ?>
                <?php if (!empty($mensajeOk)): ?>
                    <div class="alert alert-success d-flex align-items-center rounded-3 px-3 py-2 border-0 shadow-sm mb-3" role="alert">
                        <i class="fa-solid fa-circle-check me-2 fs-5"></i>
                        <div><?= $mensajeOk ?></div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($mensajeNoOk)): ?>
                    <div class="alert alert-danger d-flex align-items-center rounded-3 px-3 py-2 border-0 shadow-sm mb-3" role="alert">
                        <i class="fa-solid fa-circle-xmark me-2 fs-5"></i>
                        <div><?= $mensajeNoOk ?></div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
          <!-- Botones de Acción -->
          <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
            <a href="<?=$ruta?>productos" class="btn btn-light border px-4 fw-medium rounded-3">Cancelar</a>
            <button type="submit" class="btn btn-primary px-4 fw-semibold rounded-3">
              Guardar Producto
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