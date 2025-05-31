<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Evaluación docente</title>
    <!-- Bootstrap 5.3.6 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link href="<?= BASE_URL ?>css/style.css" type="text/css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<!-- Header con menú -->
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <span class="logo-placeholder">
                <img src="<?= BASE_URL ?>images/itvo.jpg" class="img-fluid" alt="logo">
            </span>
            <div class="text-center">
                <h2>Instituto Tecnológico del Valle de Oaxaca</h2>
            </div>

        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav"
                aria-controls="menuNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menuNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/home/index">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/survey/add" >Encuesta</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/survey/graph" >Gráfico</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
