<script setup>
import { inject, onMounted, ref } from 'vue'
import { useRoute, onBeforeRouteUpdate } from 'vue-router'

const app = inject('app');
const oMyRoute = useRoute()

if (! app.carrinho.hasOwnProperty('itens')) {
    app.carrinho.itens = []
}

const fetchProductInCategory = app.fetchProductInCategory; // product type fetcher
let itens = ref([])

onMounted(() => {
    console.log(oMyRoute.params)
    if (! oMyRoute.params.nome) {
        return;
    }
    fetchProductInCategory(oMyRoute.params.nome).then((oResponse) => {
        oResponse.json().then((aList) => {
            itens.value = aList
        })
    });
})

onBeforeRouteUpdate ((to, from) => {
    //console.log(oMyRoute.path)
    //console.log(oMyRoute.params)
    fetchProductInCategory(to.params.nome).then((oResponse) => {
        oResponse.json().then((aList) => {
            itens.value = aList
        })
    });
})

const adicionarCarrinho = (e) => {
    e.preventDefault();
    const form = e.target.form
    let oInput;
    for (let iIndex = 0; iIndex < form.elements.length; iIndex++) {
        if (form.elements[iIndex].type == 'number') {
            oInput = form.elements[iIndex]
        }
    }

    app.carrinho.itens.push({
        'id': oInput.name,
        'quantidade': oInput.value,
    });
    // calcular imposto
    // calcular total

    window.alert('Adicionado no carrinho.') // TODO colocar icone do carrinho com a quantidade
}

</script>

<template>
<div v-if="oMyRoute.params.nome" class="col container produtos">
    <!-- Portfolio Section Heading-->
    <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Nossos produtos</h2>
    <!-- Icon Divider-->
    <div class="divider-custom">
        <div class="divider-custom-line"></div>
        <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
        <div class="divider-custom-line"></div>
    </div>
    <!-- Portfolio Grid Items-->
    <div class="row justify-content-center">
        <template v-for="item in itens" :key="item.id">
            <div class="col-md-6 col-lg-4 mb-5">
                <div class="card" style="width: 18rem;">
                    <img src="https://i.imgur.com/ZTkt4I5.jpg" class="card-img-top" alt="Example random image">
                    <div class="card-body">
                        <h5 class="card-title">{{item.nome}}</h5>
                        <p class="card-text">R$ {{app.numberFormat(item.preco, 2, ',')}}</p>
                        <p class="quantidade">
                            Quantidade:
                            <form>
                                <input :name="item.id" value="1" type="number" step="1" min="1" />
                                <button @click="adicionarCarrinho" class="btn"><i class="fab fa-github"></i>Adicionar</button>
                            </form>
                        </p>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
<div v-else class="col">
    Escolha uma das categorias para escolher produtos.
</div>
</template>

<style scoped>
.card {
  background: rgb(226, 202, 202);
  border: 2px solid brown;
  margin-bottom: 2rem;
}

.btn {
  border: 2px solid;
  border-image-slice: 1;
  padding: 1px 4px;
  background: var(--gradient) !important;
  -webkit-background-clip: text !important;
  border-image-source:  var(--gradient) !important;
  text-decoration: none;
}

.btn:hover, .btn:focus {
  background: var(--gradient) !important;
  box-shadow: #222 1px 0 10px;
}

.quantidade input {
    width: 3em;
    border: 0;
    border-radius: 4px;
    font-style: italic;
}
.quantidade button {
    margin-left: 8px;
}
</style>