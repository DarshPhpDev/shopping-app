<template>
    <b-container class="mt-4" data-test="product-list">
        <div class="No products Found" v-if="!productStore.isLoading && productStore.products.length === 0">
            <h2>Sorry, No Products Found.</h2>
        </div>
        <div class="products-container" v-else>
            <h2 class="mb-4">Products</h2>
            <b-row>
                <div class="text-center mb-3 d-flex justify-content-center" v-if="productStore.isLoading">
                    <b-spinner variant="primary"></b-spinner>
                </div>
                <b-col md="3" v-for="product in productStore.products" :key="product.id" class="mb-4" data-test="product-item">
                    <b-card 
                        :title="product.title" 
                        :img-src="product.image" 
                        img-top 
                        data-test="product-card"
                        img-height="400"
                        img-alt="Product image"
                        class="product-card h-100"
                    >
                        <b-card-text>
                            <div class="badge badge-info category-badge">
                                {{ product.category }}
                            </div>
                        </b-card-text>
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
            <b-pagination
                v-if="productStore.meta"
                v-model="currentPage"
                :total-rows="productStore.meta.total"
                :per-page="productStore.meta.per_page"
                align="center"
            />
        </div>
    </b-container>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import { useProductStore } from '@/stores/productStore'
import { useCartStore } from '@/stores/cartStore'
const cartStore = useCartStore()

const productStore = useProductStore()
const currentPage = ref(1)
const loading = ref(true)
const error = ref(null)

const isInCart = (product) => {
    return cartStore.items.some(item => item.id === product.id)
}

const addToCart = (product) => {
    cartStore.addItem(product)
}

onMounted(async () => {
    await productStore.fetchProducts()
})

// As a nic work around using watch on the b-pagination v-model (currentPage) 
// since @input & @change in the b-pagination component is not working
// probably due to compatibility issue with Vue 3
watch(currentPage, (newPage) => {
  productStore.fetchProducts(newPage)
})

</script>

<style scoped>
.product-card >>> .card-img-top {
  height: 400px;
  object-fit: contain;
  object-position: center;
}
.category-badge {
    font-size: 0.7rem;
    padding: 0.5em 0.75em;
    background-color: #17a2b8;
    color: #fff;
}
</style>