<script setup>
import { inject, reactive } from 'vue'
import { useRouter } from 'vue-router'
/**
 * @type {array}
 */
const itens = inject('menuItens'); // main menu itens
const oApp = inject('app'); // app variables

const state = reactive({
    email: '',
    token: '',
    disabled: true, // ui state
    error: '', // display message to client
    success: false, // will be true if action succeded
});

const allowSubmit = () => {
    state.disabled = ! new Boolean(state.email.length && state.token.length).valueOf();
}

const router = useRouter()
const postForm = (e) => {
    const oAjax = new XMLHttpRequest();
    oAjax.open("POST", oApp.sServerUrl + "/usuario/entrar");
    oAjax.setRequestHeader('Access-Control-Allow-Origin', window.location.origin);
    oAjax.setRequestHeader('Accept', 'application/json');
    oAjax.onload = (data => {
        try {
            let oResponse = JSON.parse(data.target.response);
            if (typeof oResponse == 'string') {
                state.error = oResponse;
                return;
            }
            oApp.user = oResponse;
            switch (oApp.user.perfil) {
                case 0:
                    itens.splice(1, 0, {label: 'Nossos produtos', to: '/categorias'});
                    break;
                case 1:
                    itens.splice(1, 0, {label: 'Listar tipos', to: '/tipo-produto'});
                    itens.splice(2, 0, {label: 'Listar produtos', to: '/produto'});
                    break;
            }
            itens.push({label: 'Carrinho', to: '/carrinho'})
            itens.push({label: 'Sair', to: '/sair'})
            state.error = '';
            state.success = true;
            state.email = '';
            state.token = '';
            router.push('/')
        } catch (e) {
            state.error = 'Erro no servidor.';
        }
    });
    oAjax.send(new FormData(e.target));
}
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
                    <form id="signInForm" @submit.prevent="postForm">
                        <!-- Email address input-->
                        <div class="form-floating mb-3">
                            <input v-model.trim="state.email" @keyup="allowSubmit" class="form-control" id="signInEmail" name="email" type="email" placeholder="voce@provedor.com.br" data-sb-validations="required,email" />
                            <label for="email">Email</label>
                            <div class="invalid-feedback" data-sb-feedback="email:required">Email é necessário.</div>
                            <div class="invalid-feedback" data-sb-feedback="email:email">Email em formato incorreto.</div>
                        </div>
                        <!-- Message input-->
                        <div class="form-floating mb-3">
                            <input v-model.trim="state.token" @keyup="allowSubmit" class="form-control" id="token" name="token" type="password" placeholder="Sua senha..." style="height: 10rem" data-sb-validations="required"/>
                            <label for="message">Senha</label>
                            <div class="invalid-feedback" data-sb-feedback="message:required">A senha é necessária.</div>
                        </div>
                        <!-- Submit success message-->
                        <!---->
                        <!-- This is what your users will see when the form-->
                        <!-- has successfully submitted-->
                        <div :class="{'d-none': ! state.success}" id="submitSuccessMessage">
                            <div class="text-center mb-3">
                                <div class="fw-bolder">Acesso liberado!</div>
                            </div>
                        </div>
                        <!-- Submit error message-->
                        <!---->
                        <!-- This is what your users will see when there is-->
                        <!-- an error submitting the form-->
                        <div :class="{'d-none': state.error.length == 0}" id="submitErrorMessage"><div class="text-center text-danger mb-3">{{state.error}}</div></div>
                        <!-- Submit Button-->
                        <button class="btn btn-primary btn-xl" :class="{disabled: state.disabled}" id="signInSubmitButton" type="submit">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>

</style>
