<script setup>
import { inject } from 'vue'
import { useRouter } from 'vue-router'

const app = inject('app');
const oRouter = useRouter()
const oCarrinho = app.carrinho;

const confirm = (e) => {
    e.preventDefault();
    if (!window.confirm('Deseja finalizar a compra?')) {
        return;
    }
    console.log('teste ui');
    let $oForm = new FormData();
    app.carrinho.itens.forEach(oItem => {
        $oForm.append('id[]', oItem.id);
        $oForm.append('quantidade[]', oItem.quantidade);
    });

    fetch(
        app.sServerUrl + "/produto/finalizar",
        { method: 'post', cache: 'no-store', body: $oForm, credentials: "include" }
    ).then((oResponse) => {
        oResponse.json().then((sMessage) => {
            if (sMessage) {
                alert(sMessage);
                return;
            }
            app.carrinho = {}
            oRouter.push('/obrigado')
        })
    });
}
</script>

<template>
<div class="row">
    <div v-if="oCarrinho.itens == undefined || ! app.carrinho.itens.length">
        Seu carrinho está vazio!
    </div>
    <form v-else name="carrinho">
        <div class="col">Carrinho</div>
        <div class="col">
            Valor da compra em impostos R$
            {{
                app.carrinho && app.carrinho.imposto ? app.numberFormat(app.carrinho.imposto, 2, ',', '.') : app.numberFormat(0, 2, ',', '.')
            }}
        </div>
        <div class="col">Valor total da compra R$
            {{
                app.carrinho && app.carrinho.total ? app.numberFormat(app.carrinho.total, 2, ',', '.') : app.numberFormat(0, 2, ',', '.')
            }}
        </div>
        <div class="col"><button @click="confirm">Finalizar</button></div>
    </form>
</div>
</template>

<style scoped>
</style>