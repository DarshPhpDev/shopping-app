import { defineStore } from 'pinia'

export const useCartStore = defineStore('cart', {
    
    state: () => ({
        // Retrieve the cartItems from localStorage and parse it from json string to array 
        items: JSON.parse(localStorage.getItem('cart')) || []
    }),

    getters: {
        // Calculates the count of cart items using reduce function to accumulate the count after each call.
        count: (state) => {
            return state.items.reduce((total, item) => total + (item.quantity || 1), 0)
        },
        // Calculates the total price of cart items using reduce function to accumulate the total price after each call.
        total: (state) => {
            const total = state.items.reduce((sum, item) => {
              return sum + (Number(item.price) * (item.quantity || 1))
            }, 0)
            // Round to 2 decimal places then convert back to number
            return Number(total.toFixed(2))
        }

    },

    actions: {
        // Adds product item to the cart.
        addItem(product) {
            const existingItem = this.items.find(item => item.id === product.id)
            if (existingItem) {
                // if item already exists increase quantity by 1.
                existingItem.quantity = (existingItem.quantity || 1) + 1
            } else {
                // destructure the product and inject quantity and push it to items array.
                this.items.push({ ...product, quantity: 1 })    
            }
            this.saveCart()
        },

        // Remove cart item by index.
        removeItem(index) {
            this.items.splice(index, 1)
            this.saveCart()
        },

        // Update cart item quantity.
        updateQuantity(index, quantity) {
            if (quantity >= 1) {
                this.items[index].quantity = quantity
                this.saveCart()
            }
        },

        // Remove all items from cart.
        clearCart() {
            this.items = []
            this.saveCart()
        },

        // Always save cart items to localStorage as permenant storage (maintained if page reloads).
        saveCart() {
            localStorage.setItem('cart', JSON.stringify(this.items))
        }
  }
})