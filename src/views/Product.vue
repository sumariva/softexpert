<script setup>
import { inject, onMounted, ref, reactive } from 'vue'

const debug = function(any) {
    console.log(any)
}

const state = reactive({
    itemChecked: 0,
    add: false,
});

let sMessage = ref('Carregando...')
let itens = ref([])
let aTypeItens = ref([])
const oAppConfig = inject('app');

const fetchProductTypes = oAppConfig.fetchProductType; // product type fetcher
fetchProductTypes().then(
    (oResponse) => {
        oResponse.json().then((aList) => {
            aTypeItens.value = aList
        })
});

const fetchProductFn = oAppConfig.fetchProduct; // product fetcher

const fetchProduct = () => {
    return fetchProductFn().then((oResponse) => {
        oResponse.json().then((aList) => {
            itens.value = aList
            sMessage.value = aList.length ? '' : 'Sem produtos no cadastro!'
        })
    });
}

onMounted(fetchProduct)

const confirm = (e) => {
    if (!window.confirm('Deseja apagar?')) {
        return;
    }

    let $oForm = new FormData();
    $oForm.append('id', e.target.value);
    fetch(
        oAppConfig.sServerUrl + "/produto/apagar",
        { method: 'post', cache: 'no-store', body: $oForm }
    ).then((oResponse) => {
        oResponse.json().then((sMessage) => {
            if (sMessage) {
                alert(sMessage);
                return;
            }
            fetchProduct();
        })
    });
}

const toogle = (e) =>{
    if (state.add == true) {
        postForm(e);
        return;
    }
    state.add = ! state.add;
}

const postForm = (e) => {
    const form = document.getElementById('form-add');
    let $oForm = new FormData(form);
    fetch(
        oAppConfig.sServerUrl + "/produto/adicionar",
        { method: 'post', cache: 'no-store', body: $oForm }
    ).then((oResponse) => {
        oResponse.json().then((sMessage) => {
            if (!sMessage) {
                fetchProduct().then(() => { form.reset(); state.add = ! state.add });
            }
        })
    });
}

</script>

<template>
    <form id="form-add">
        <table class="table table-primary table-striped table-hover table-bordered caption-top">
            <caption>Lista de produtos</caption>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tipo</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Disponível?</th>
                </tr>
            </thead>
            <tbody v-if="itens.length == 0">
                <tr class="ms-auto"><td colspan="5">{{sMessage}}</td></tr>
            </tbody>
            <tbody v-else v-for="oProduto in itens" :key="oProduto.id">
                <tr class="ms-auto">
                    <td class="">
                        <button @click="confirm" type="button" name="item" :value="oProduto.id">Remover</button>
                    </td>
                    <td class="">{{
                        aTypeItens.reduce((sSaida, oItem) => {
                                return oItem.id == oProduto.tipo ? sSaida + oItem.tipo : sSaida
                            },
                            ''
                        )
                    }}</td>
                    <td class="">{{oProduto.nome}}</td>
                    <td class="">{{oProduto.preco}}</td>
                    <td class="">{{oProduto.esta_disponivel ? 'Sim' : 'Não'}}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr :class="{hidden: ! state.add}">
                    <td></td>
                    <td>
                        <select name="tipo">
                            <template v-for="oItem in aTypeItens">
                                <option :value="oItem.id">{{oItem.tipo}}</option>
                            </template>
                        </select>
                    </td>
                    <td><input type="text" name="nome" /></td>
                    <td><input type="number" name="preco" min="0" step=0.01/></td>
                    <td>
                        <label><input type="radio" checked name="esta_disponivel" value="1"/>Sim</label>
                        <label><input type="radio" name="esta_disponivel" value="0"/>Não</label>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <a @click="toogle" v-if="! state.add" href="#add">Adicionar</a>
                        <a @click="toogle" v-else href="#save">Salvar</a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
</template>

<style scoped>
.hidden { display: none; }
.disabled { opacity: 0.2; }
</style>
