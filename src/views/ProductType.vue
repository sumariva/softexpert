<script setup>
import { inject, onMounted, provide, ref, reactive } from 'vue'

const state = reactive({
    itemChecked: 0,
    add: false,
});

let itens = ref([])
provide('type-list', itens); // product type list

const oAppConfig = inject('app');

const fetchData = oAppConfig.fetchProductType;

const fetchUpdate = () => {
    fetchData().then((oResponse) => {
        oResponse.json().then((aList) => {
            itens.value = aList
        })
    });
}

onMounted(fetchUpdate)

const confirm = (e) => {
    if (!window.confirm('Deseja apagar?')) {
        return;
    }

    let $oForm = new FormData();
    $oForm.append('id', e.target.value);
    fetch(
        oAppConfig.sServerUrl + "/produto/apagar-tipo",
        { method: 'post', cache: 'no-store', body: $oForm }
    ).then((oResponse) => {
        oResponse.json().then((sMessage) => {
            if (sMessage) {
                alert(sMessage);
                return;
            }
            fetchUpdate();
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
        oAppConfig.sServerUrl + "/produto/adicionar-tipo",
        { method: 'post', cache: 'no-store', body: $oForm }
    ).then((oResponse) => {
        oResponse.json().then((sMessage) => {
            if (!sMessage) {
                fetchUpdate().then(() => { form.reset(); state.add = ! state.add });
            }
        })
    });
}
</script>

<template>
    <form id="form-add">
        <table class="table table-primary table-striped table-hover table-bordered caption-top">
            <caption>Lista de tipos(categorias)</caption>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Imposto</th>
                </tr>
            </thead>
            <tbody v-if="itens.length == 0">
                <tr class="ms-auto"><td colspan="3">Carregando...</td></tr>
            </tbody>
            <tbody v-else v-for="item in itens" :key="item.id">
                <tr class="ms-auto">
                    <td class="">
                        <button @click="confirm" type="button" name="item" :value="item.id">Remover</button>
                    </td>
                    <td class="">{{item.tipo}}</td>
                    <td class="">{{item.imposto}}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr :class="{hidden: ! state.add}">
                    <td></td>
                    <td><input type="text" name="tipo" /></td>
                    <td><input type="number" name="imposto" min="0" max="100" step=0.01/></td>
                </tr>
                <tr>
                    <td colspan="3">
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
