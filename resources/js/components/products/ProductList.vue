<template>
    <b-container class="mt-4" data-test="product-list">
        <h2>Products</h2>
        <b-row>
            <b-col md="4" v-for="product in productStore.products" :key="product.id" class="mb-4" data-test="product-item">
                <b-card :title="product.title" :img-src="product.image" img-top data-test="product-card">
                    <b-card-text>{{ product.category }}</b-card-text>
                    <b-card-text class="h4" data-test="product-price">${{ product.price }}</b-card-text>
                    <b-button 
                        @click="addToCart(product)" 
                        variant="primary"
                        :disabled="isInCart(product)"
                        data-test="add-to-cart-btn"
                    >
                        {{ isInCart(product) ? 'Added to Cart' : 'Add to Cart' }}
                    </b-button>
                </b-card>
            </b-col>
        </b-row>
    </b-container>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useProductStore } from '@/stores/productStore'
import { useCartStore } from '@/stores/cartStore'
const cartStore = useCartStore()

const productStore = useProductStore()
const loading = ref(true)
const error = ref(null)

const isInCart = (product) => {
    return cartStore.items.some(item => item.id === product.id)
}

onMounted(async () => {
    await productStore.fetchProducts()
})

const addToCart = (product) => {
    cartStore.addItem(product)
}
</script>