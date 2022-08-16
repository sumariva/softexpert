<script setup>
</script>

<template>
   <!-- SignIn Section-->
    <section class="page-section" id="signin">
        <div class="container">
            <!-- SignIn Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Acessar</h2>
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- SignIn Section Form-->
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7">
                    <!-- * * * * * * * * * * * * * * *-->
                    <!-- * * SB Forms Contact Form * *-->
                    <!-- * * * * * * * * * * * * * * *-->
                    <!-- This form is pre-integrated with SB Forms.-->
                    <!-- To make this form functional, sign up at-->
                    <!-- https://startbootstrap.com/solution/contact-forms-->
                    <!-- to get an API token!-->
                    <form id="signInForm" data-sb-form-api-token="API_TOKEN">
                        <!-- Email address input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="signInEmail" type="email" placeholder="voce@provedor.com.br" data-sb-validations="required,email" />
                            <label for="email">Email</label>
                            <div class="invalid-feedback" data-sb-feedback="email:required">Email é necessário.</div>
                            <div class="invalid-feedback" data-sb-feedback="email:email">Email em formato incorreto.</div>
                        </div>
                        <!-- Message input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="token" type="password" placeholder="Sua senha..." style="height: 10rem" data-sb-validations="required"/>
                            <label for="message">Senha</label>
                            <div class="invalid-feedback" data-sb-feedback="message:required">A senha é necessária.</div>
                        </div>
                        <!-- Submit success message-->
                        <!---->
                        <!-- This is what your users will see when the form-->
                        <!-- has successfully submitted-->
                        <div class="d-none" id="submitSuccessMessage">
                            <div class="text-center mb-3">
                                <div class="fw-bolder">Form submission successful!</div>
                                To activate this form, sign up at
                                <br />
                                <a href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
                            </div>
                        </div>
                        <!-- Submit error message-->
                        <!---->
                        <!-- This is what your users will see when there is-->
                        <!-- an error submitting the form-->
                        <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Error sending message!</div></div>
                        <!-- Submit Button-->
                        <button class="btn btn-primary btn-xl disabled" id="signInSubmitButton" type="submit">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>

</style>
