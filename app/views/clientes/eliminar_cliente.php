<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cliente Eliminado</title>
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
    .success-icon-box {
      width: 64px;
      height: 64px;
      border-radius: 50%;
      background-color: #dcfce7;
      color: #16a34a;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.75rem;
      margin: 0 auto 1.25rem auto;
    }
  </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 p-3">

  <div class="card shadow-sm border-0 rounded-4 text-center p-4" style="max-width: 480px; width: 100%;">
    
    <!-- Ícono de Éxito -->
    <div class="success-icon-box">
      <i class="fa-solid fa-circle-check"></i>
    </div>

    <!-- Mensaje Principal -->
    <h4 class="fw-bold text-dark mb-3">Cliente eliminado correctamente</h4>

    <!-- Resumen del Cliente Eliminado -->
    <div class="bg-light p-3 rounded-3 text-start mb-4 border">
      <div class="mb-2">
        <span class="badge bg-secondary-subtle text-secondary font-monospace">#<?= $cliente[0]->id ?></span>
      </div>
      <div class="fw-bold text-dark fs-5">
        <i class="fa-regular fa-user me-2 text-muted"></i><?= strtoupper($cliente[0]->nombre) ?>
      </div>
      <div class="mt-3 pt-2 border-top small text-secondary">
        <i class="fa-solid fa-location-dot me-2"></i><strong>Domicilio:</strong> <?= $cliente[0]->domicilio ?>
      </div>
    </div>

    <!-- Botón Volver -->
    <a href="<?=$ruta?>clientes?mensaje=cliente_eliminado" class="btn btn-primary fw-semibold rounded-3 w-100 py-2">
      <i class="fa-solid fa-arrow-left me-1"></i> Volver al listado
    </a>

  </div>

</body>
</html>