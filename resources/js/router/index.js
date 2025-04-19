import { createRouter, createWebHistory } from 'vue-router'
import ProductList from '@/components/products/ProductList.vue'
import Login from '@/components/auth/Login.vue'
import Register from '@/components/auth/Register.vue'
import Logout from '@/components/auth/Logout.vue'
import CartPage from '@/components/cart/CartPage.vue'

const routes = [
    { path: '/', component: ProductList },
    { path: '/login', component: Login },
    { path: '/register', component: Register },
    { path: '/logout', component: Logout },
    { path: '/cart', component: CartPage }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router