<!-- La banda azul de fondo (bg-dark) se ve en las esquinas redondeadas de la caja gris -->
<footer class="bg-dark pt-2">
    <div class="container bg-light rounded-top-5 mt-5 pt-5 px-3 px-md-4 pb-5">

        <section class="text-center mb-5">
            <h2>¿Hambre? ¡Haz tu pedido!</h2>
            <p class="mb-4">Listo en minutos a tu manera</p>
            <button type="button" class="boton boton--primario">Pedir ya</button>
        </section>

        <div class="row g-4">
            <div class="col-12 col-md-3">
                <img src="<?= url ?>/assets/img/logo/logo-claro.svg" alt="Sigmeat" class="logo">
            </div>

            <nav class="col-6 col-md-3">
                <p class="fw-bold mb-2">Sigmeat</p>
                <ul class="list-unstyled d-flex flex-column gap-2 m-0">
                    <li><a href="#">Inicio</a></li>
                    <li><a href="#">Carta</a></li>
                </ul>
            </nav>
            <nav class="col-6 col-md-3">
                <p class="fw-bold mb-2">Legal</p>
                <ul class="list-unstyled d-flex flex-column gap-2 m-0">
                    <li><a href="#">Aviso legal</a></li>
                    <li><a href="#">Política de privacidad</a></li>
                    <li><a href="#">Cookies</a></li>
                </ul>
            </nav>
            <nav class="col-6 col-md-3">
                <p class="fw-bold mb-2">¿Hablamos?</p>
                <ul class="list-unstyled d-flex flex-column gap-2 m-0">
                    <li><a href="#">Contacta con nosotros</a></li>
                    <li><a href="#">Instagram</a></li>
                </ul>
            </nav>
        </div>
    </div>
</footer>
