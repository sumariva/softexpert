<script setup>
import { inject, onMounted } from 'vue'
import { useRouter } from 'vue-router'
/**
 * @type {Array}
 */
const itens = inject('menuItens'); // main menu itens
const oApp = inject('app'); // app variables

// TODO logout
onMounted(() => {
    const router = useRouter()
    if (oApp.user.perfil === undefined){
        router.push('/')
    }
    switch (oApp.user.perfil) {
        case 0:
            itens.forEach(
                (item, index) => {
                    if (
                        item.label == 'Nossos produtos'
                        || item.label == 'Carrinho'
                        || item.label == 'Sair'
                    ) {
                        itens.splice(index, 1);
                    }
                }
            )
            break;
        case 1:
            const aToRemove = itens.filter((item) => {
                return item.label == 'Listar tipos'
                    || item.label == 'Listar produtos'
                    || item.label == 'Carrinho'
                    || item.label == 'Sair';
            });
            while (aToRemove.length) {
                let oItem = aToRemove.shift();
                itens.splice(itens.indexOf(oItem), 1);
            }
            break;
    }
    oApp.user = {};
    router.push('/')
})

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
            state.client = oResponse;
            switch (state.client.perfil) {
                case 0:
                    itens.splice(1, 0, {label: 'Nossos produtos', to: '/categorias'});
                    itens.push({label: 'Sair', to: '/sair'})
                    break;
                case 1:
                    itens.splice(1, 0, {label: 'Listar tipos', to: '/tipo-produto'});
                    itens.splice(2, 0, {label: 'Listar produtos', to: '/produto'});
                    break;
            }
            state.error = '';
            state.success = true;
            state.email = '';
            state.token = '';
        } catch (e) {
            state.error = 'Erro no servidor.';
        }
    });
    oAjax.send(new FormData(e.target));
}
</script>

<template>

</template>

<style scoped>

</style>
