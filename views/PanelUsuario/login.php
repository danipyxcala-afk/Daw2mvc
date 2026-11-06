<div class="container m-5 ">
    <h1>Iniciar sesión</h1>
    <form action="<?= url ?>PanelUsuario/login" method="POST">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Iniciar sesión</button>
    </form>
    <a href="<?= url ?>index.php?controller=login&action=registro">¿No tienes cuenta? ¡Haz click aqui!</a>
</div>