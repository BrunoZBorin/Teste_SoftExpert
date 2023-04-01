import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/produto',
      name: 'produto',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/Produto.vue')
    },
    {
      path: '/produto/tipo',
      name: 'tipo_produto',
      component: () => import('../views/TipoProduto.vue')
    },
    {
      path: '/venda',
      name: 'venda',
      component: () => import('../views/Venda.vue')
    }
  ]
})

export default router
