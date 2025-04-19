import { defineStore } from 'pinia'

export const useCartStore = defineStore('cart', {
    
    state: () => ({
        items: JSON.parse(localStorage.getItem('cart')) || []
    }),

    getters: {
        count: (state) => {
            return state.items.reduce((total, item) => total + (item.quantity || 1), 0)
        },
        total: (state) => {
            return state.items.reduce((sum, item) => sum + (item.price * (item.quantity || 1)), 0)
        }
    },

    actions: {
        addItem(product) {
            const existingItem = this.items.find(item => item.id === product.id)
            if (existingItem) {
                existingItem.quantity = (existingItem.quantity || 1) + 1
            } else {
                this.items.push({ ...product, quantity: 1 })
            }
            this.saveCart()
        },

        removeItem(index) {
            this.items.splice(index, 1)
            this.saveCart()
        },

        updateQuantity(index, quantity) {
            if (quantity >= 1) {
                this.items[index].quantity = quantity
                this.saveCart()
            }
        },

        clearCart() {
            this.items = []
            this.saveCart()
        },

        saveCart() {
            localStorage.setItem('cart', JSON.stringify(this.items))
        }
  }
})