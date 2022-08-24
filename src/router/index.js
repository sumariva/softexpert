import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import('../views/Home.vue')
    },
    {
      path: '/sobre',
      name: 'about',
      component: () => import('../views/About.vue')
    },
    {
        path: '/cadastro',
        name: 'signup',
        component: () => import('../views/SignUp.vue'),
    },
    {
        path: '/entrar',
        name: 'signin',
        component: () => import('../views/SignIn.vue'),
    },
    {
        path: '/categorias/:nome?',
        name: 'categories',
        component: () => import('../views/Category.vue'),
    },
    {
        path: '/sair',
        name: 'signout',
        component: () => import('../views/SignOut.vue'),
    },
    {
        path: '/tipo-produto',
        name: 'product-type-list',
        component: () => import('../views/ProductType.vue'),
    },
    {
        path: '/produto',
        name: 'product-list',
        component: () => import('../views/Product.vue'),
    },
    {
        path: '/carrinho',
        name: 'shop-cart',
        component: () => import('../views/ShopCart.vue'),
    },
    {
        path: '/obrigado',
        name: 'thank-you',
        component: () => import('../views/ThankYou.vue'),
    },
  ]
})

export default router
