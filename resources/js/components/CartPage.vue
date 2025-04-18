<template>
  <b-container class="mt-4" data-test="cart-page">
    <h2>Your Shopping Cart</h2>
    <div v-if="cartItems.length === 0" role="alert" aria-live="polite" aria-atomic="true" class="alert alert-info" data-test="empty-cart-message">
        Your cart is empty. <router-link to="/">Continue shopping</router-link>
    </div>
    <b-list-group v-else>
      <b-list-group-item v-for="(item, index) in cartItems" :key="index" class="d-flex align-items-center" data-test="cart-item">
        <b-img :src="item.image" width="80" height="80" class="mr-4" data-test="product-image"></b-img>
        <div class="flex-grow-1 mx-2">
          <h5 data-test="product-title">{{ item.title }}</h5>
          <div data-test="product-price">${{ item.price }}</div>
        </div>
        <div class="cart-actions">
          <input 
            id="type-number"
            v-model="item.quantity"
            type="number"
            class="form-control mx-2"
            min="1" 
            style="width: 80px;"
            @change="updateQuantity(index, item.quantity)"
            data-test="quantity-input"
            >
          <b-button 
            variant="danger" 
            @click="removeItem(index)"
            class="ml-2"
            data-test="remove-btn"
          >
            Remove
          </b-button>
        </div>
      </b-list-group-item>
    </b-list-group>

    <div class="cart-summary mt-4">
      <h4>Total: ${{ cartTotal }}</h4>
    </div>
  </b-container>
</template>

<script setup>
import { computed } from 'vue'
import { useCartStore } from '@/stores/cartStore'
import { useRouter } from 'vue-router'

const router = useRouter()
const cartStore = useCartStore()

const cartItems = computed(() => cartStore.items.map(item => ({
  ...item,
  quantity: item.quantity || 1
})))

const cartTotal = computed(() => {
  return cartStore.items.reduce((total, item) => {
    return total + (item.price * (item.quantity || 1))
  }, 0)
})

const removeItem = (index) => {
  cartStore.removeItem(index)
}

const updateQuantity = (index, quantity) => {
    console.log('index', index);
    console.log('quantity', quantity);
  cartStore.updateQuantity(index, parseInt(quantity) || 1)
}

const checkout = () => {
  router.push('/checkout') // You'll implement this later
}
</script>

<style scoped>
.cart-actions {
  min-width: 180px;
  display: flex;
  align-items: center;
}

.cart-summary {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px;
  background-color: #f8f9fa;
  border-radius: 5px;
}
</style>