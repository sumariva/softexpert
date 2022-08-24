<script setup>
import { inject, onMounted, ref  } from 'vue'
import { useRoute } from 'vue-router'
import ProductList from './ProductList.vue'

const app = inject('app');

const oMyRoute = useRoute()

const fetchProductTypes = app.fetchProductType; // product type fetcher
let itens = ref([])

onMounted(() => {
    fetchProductTypes().then((oResponse) => {
        oResponse.json().then((aList) => {
            itens.value = aList
        })
    });
})

</script>

<template>
    <!-- Portfolio Section div class="col-md-6 col-lg-4 mb-5" -->
    <section class="page-section portfolio" id="portfolio">
        <div class="container">
            <div class="row">
                <div class="col container categorias">
                    <div class="row heading">
                        <!-- Portfolio Section Heading-->
                        <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Nossas categorias</h2>
                        <!-- Icon Divider-->
                        <div class="divider-custom">
                            <div class="divider-custom-line"></div>
                            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                            <div class="divider-custom-line"></div>
                        </div>
                    </div>
                    <div class="row" v-for="item in itens" :key="item.id">
                        <div class="col">
                                <div class="portfolio-item mx-auto">
                                    <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                        <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
                                    </div>
                                    <RouterLink :to="oMyRoute.path.match(/(\/[^\/]+)/)[1] + '/'  + item.tipo">{{item.tipo}}</RouterLink>
                                </div>
                        </div>
                    </div>
                </div>
                <ProductList />
            </div>
        </div>
    </section>
</template>

<style scoped>
.page-section.portfolio {
    padding: 0;
}

.container { margin-left: 0; }
.categorias {
    margin-left: 0;
    padding-left: 0;
    max-width: fit-content;
}

.row.heading .page-section-heading {
    font-size: 14px;
}

.row.heading .divider-custom { margin: 0; }
.row.heading .divider-custom .divider-custom-icon {
    font-size: smaller;
}

.portfolio .portfolio-item .portfolio-item-caption:hover { opacity: 0; }
</style>
