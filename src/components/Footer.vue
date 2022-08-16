<script setup>
import Copyright from './Copyright.vue'
</script>

<template>
    <!-- Footer-->
    <footer class="footer text-center">
        <div class="container">
            <div class="row">
                <!-- Footer Location-->
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <h4 class="text-uppercase mb-4">Depósito</h4>
                    <p class="lead mb-0">
                        Avenida dos Mercados, 24.
                        <br />
                        Brasília, Brasil
                    </p>
                </div>
                <!-- Footer Social Icons-->
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <h4 class="text-uppercase mb-4">Redes sociais</h4>
                    <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-twitter"></i></a>
                    <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-linkedin-in"></i></a>
                    <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-dribbble"></i></a>
                </div>
                <!-- Footer About Text-->
                <div class="col-lg-4">
                    <h4 class="text-uppercase mb-4">Desenvolvimento</h4>
                    <p class="lead mb-0">
                        Cristiano Sumariva
                        <a href="https://github.com/sumariva" target="_blank">Github</a>
                        .
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <Copyright />
</template>

<style scoped>
.footer {
  padding-top: 2rem;
  padding-bottom: 2rem;
  background-color: #2c3e50;
  color: #fff;
}
</style>
