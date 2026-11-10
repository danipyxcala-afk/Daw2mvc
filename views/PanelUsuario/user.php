<?php ?>

<div class="container">
    <h1>Bienvenido, <?= htmlspecialchars($_SESSION['usuario']->getNombre()) ?></h1>
    <p>Esta es tu página de usuario.</p>
</div>