import { defineStore } from 'pinia'
import { computed, ref } from 'vue'

export const useCartStore = defineStore('cart', () => {
  const items = ref(JSON.parse(localStorage.getItem('cart')) || [])

  const count = computed(() => 
    items.value.reduce((total, item) => total + (item.quantity || 1), 0)
  )

  const total = computed(() => 
    items.value.reduce((sum, item) => sum + (item.price * (item.quantity || 1)), 0)
  )

  function addItem(product) {
    const existingItem = items.value.find(item => item.id === product.id)
    if (existingItem) {
      existingItem.quantity = (existingItem.quantity || 1) + 1
    } else {
      items.value.push({ ...product, quantity: 1 })
    }
    saveCart()
  }

  function removeItem(index) {
    items.value.splice(index, 1)
    saveCart()
  }

  function updateQuantity(index, quantity) {
    if (quantity >= 1) {
      items.value[index].quantity = quantity
      saveCart()
    }
  }

  function clearCart() {
    items.value = []
    saveCart()
  }

  function saveCart() {
    localStorage.setItem('cart', JSON.stringify(items.value))
  }

  return { 
    items,
    count,
    total,
    addItem,
    removeItem,
    updateQuantity,
    clearCart
  }
})