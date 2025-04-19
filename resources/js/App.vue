<template>
    <div>
        <b-navbar type="dark" variant="dark" class="navbar-dark">
            <b-navbar-brand to="/">Shopping App</b-navbar-brand>
            <b-navbar-nav class="ml-auto">
                <b-nav-item to="/login" v-if="!authStore.isAuthenticated">Login</b-nav-item>
                <b-nav-item to="/register" v-if="!authStore.isAuthenticated">Register</b-nav-item>
                <b-nav-item to="/logout" v-if="authStore.isAuthenticated">Logout</b-nav-item>
                <b-nav-item to="/cart">
                    <CartLink />
                </b-nav-item>
            </b-navbar-nav>
        </b-navbar>
        <router-view></router-view>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import CartLink from '@/components/cart/CartLink.vue'
import { useAuthStore } from '@/stores/authStore'
const authStore = useAuthStore()
</script>

<style scoped>
.navbar-dark .navbar-nav .nav-link {
    color: rgba(255, 255, 255, 0.8) !important;
}

.navbar-dark .navbar-nav .nav-link:hover {
    color: white !important;
}

.navbar-dark .navbar-brand {
    color: white !important;
}
</style>