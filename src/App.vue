<script setup>
import { RouterView } from 'vue-router'
import { onMounted, provide, reactive } from 'vue'
import Header from './components/Header.vue'
import Footer from './components/Footer.vue'

provide('menuItens', reactive([ // app initial menu itens
    {label: 'Início', to: '/'},
    {label: 'Acesso', to: '/entrar'},
    {label: 'Cadastro', to: '/cadastro'},
    {label: 'Sobre', to: '/sobre'}
]))

const sServer = window.location.origin.replace(window.location.port, '') + '8080';
const sPath = sServer + '/index.php';
let sServerFront = window.location.origin.replace(window.location.port, '')
sServerFront = sServerFront.substring(0, sServerFront.length - 1) + ':5173'

provide('app', reactive({
    sFrontUrl: sServerFront,
    sServerUrl: sPath,
    user: {}, // app initial logged user
    productTypes: [], // categories
    products: [], // products
    // TODO if list grows need to paginate
    fetchProductType: () => {
        return fetch(
            sPath + "/produto/tipos",
            { method: 'post', cache: 'no-store'}
        )
    },
    fetchProduct: () => {
        return fetch(
            sPath + "/produto/listar",
            { method: 'post', cache: 'no-store'}
        )
    },
    fetchProductInCategory: (nCategory) => {
        let $oForm = new FormData();
        $oForm.append('tipo', nCategory);
        return fetch(
            sPath + "/produto/listar-categoria",
            { method: 'post', cache: 'no-store', body: $oForm}
        )
    },
    /**
     * NOTA ainda não funciona com negativos e numeros gigantes
     */
    numberFormat: (nValue, nDecimals, sDecimalSeparator, sThousandSeparator) => {
        let sIntegral = Number(Math.floor(nValue)).toFixed(0);
        let sFracional = (nDecimals > 0 ? sDecimalSeparator : '') + Number(nValue - sIntegral).toFixed(nDecimals).substring(2)
        sIntegral = sIntegral.split('').reverse().reduce(
            (sPrevious, sChar, nIndex) => {
                return nIndex > 0 && nIndex % 3 == 0 ? sPrevious + sThousandSeparator + sChar : sPrevious + sChar
            },
            ''
        ).split('').reverse().join('')
        return sIntegral + sFracional
    },
    carrinho: {}
}))

onMounted(() => {
  let el = document.createElement('script');
  el.setAttribute('src', sServerFront + '/assets/js/scripts.js');
  // Core theme JS
  document.getElementsByTagName('head')[0].appendChild(el);
})
</script>

<template>
  <Header />
  <RouterView />
  <Footer />
</template>

<style scoped>
header {
  line-height: 1.5;
  max-height: 100vh;
}

.logo {
  display: block;
  margin: 0 auto 2rem;
}

nav {
  width: 100%;
  font-size: 12px;
  text-align: center;
  margin-top: 2rem;
}

nav a.router-link-exact-active {
  color: var(--color-text);
}

nav a.router-link-exact-active:hover {
  background-color: transparent;
}

nav a {
  display: inline-block;
  padding: 0 1rem;
  border-left: 1px solid var(--color-border);
}

nav a:first-of-type {
  border: 0;
}

@media (min-width: 1024px) {
  header {
    display: flex;
    place-items: center;
    padding-right: calc(var(--section-gap) / 2);
  }

  .logo {
    margin: 0 2rem 0 0;
  }

  header .wrapper {
    display: flex;
    place-items: flex-start;
    flex-wrap: wrap;
  }

  nav {
    text-align: left;
    margin-left: -1rem;
    font-size: 1rem;

    padding: 1rem 0;
    margin-top: 1rem;
  }
}
</style>
