<script setup>
import { reactive } from 'vue'
import '../../node_modules/jquery/dist/jquery.min.js'
const props = defineProps({
  path: {type: String, required: true}
})
const state = reactive({
    name: '',
    email: '',
    token: '',
    disabled: true // ui state
});

const allowSubmit = () => {
    state.disabled = ! new Boolean(state.name.length && state.email.length && state.token.length).valueOf();
}
const postForm = (e) => {
    // console.log(jQuery(e.target).serialize());
    const oAjax = new XMLHttpRequest();
    oAjax.open("POST", props.path + "/usuario/salvar");
    oAjax.setRequestHeader('Access-Control-Allow-Origin', window.location.origin);
    oAjax.setRequestHeader('Accept', 'application/json');
    oAjax.onload = (data => {
        try {
            let oResponse = JSON.parse(data.target.response);
            console.log(oResponse);
        } catch (e) {
            console.log('TODO error handler');
        }
    });
    oAjax.send(new FormData(e.target));
}
</script>

<template>
    <!-- Register Section-->
    <section class="page-section" id="register">
        <div class="container">
            <!-- Contact Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Cadastro</h2>
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- Contact Section Form-->
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7">
                    <form @submit.prevent="postForm" id="signinForm" method="post" :action="props.path + '/usuario/salvar'" enctype="application/x-www-form-urlencoded">
                        <!-- Name input-->
                        <div class="form-floating mb-3">
                            <input v-model.trim="state.name" @keyup="allowSubmit" name="name" class="form-control" id="name" type="text" placeholder="Enter your name..." data-sb-validations="required" />
                            <label for="name">Nome Completo</label>
                            <div class="invalid-feedback" data-sb-feedback="name:required">Informar seu nome.</div>
                        </div>
                        <!-- Email address input-->
                        <div class="form-floating mb-3">
                            <input v-model.trim="state.email" @keyup="allowSubmit" name="email" class="form-control" id="email" type="email" placeholder="name@example.com" data-sb-validations="required,email" />
                            <label for="email">Email</label>
                            <div class="invalid-feedback" data-sb-feedback="email:required">Email é necessário.</div>
                            <div class="invalid-feedback" data-sb-feedback="email:email">Email em formato incorreto.</div>
                        </div>
                        <!-- Message input-->
                        <div class="form-floating mb-3">
                            <input v-model.trim="state.token" @keyup="allowSubmit" name="token" class="form-control" id="message" type="text" placeholder="Enter your message here..." style="height: 10rem" data-sb-validations="required"/>
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
                        <button class="btn btn-primary btn-xl" :class="{disabled: state.disabled}" id="submitButton" type="submit">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>

</style>
