<template>
    <div class="badge badge-primary badge-pill cart-badge">
        <i class="bi-cart"></i> {{ count }} (${{ total }})
    </div>
</template>

<script setup>
import { useCartStore } from '@/stores/cartStore'
import { computed } from 'vue'

const cartStore = useCartStore()
const count = computed(() => cartStore.count)
const total = computed(() => cartStore.total.toFixed(2))
</script>

<style scoped>
.cart-badge {
    font-size: 1rem;
    padding: 0.5em 0.75em;
    background-color: #007bff;
    color: #fff;
    border-radius: 50rem;
}
</style>