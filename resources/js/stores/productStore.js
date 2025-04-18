import { defineStore } from 'pinia'
import api from '@/api' // Import our Axios instance

export const useProductStore = defineStore('products', {
  state: () => ({
    products: [],
    cart: JSON.parse(localStorage.getItem('cart')) || []
  }),
  actions: {
    async fetchProducts() {
      try {
        const { data } = await api.get('/products') // Uses our baseURL
        this.products = data.data.products
      } catch (error) {
        console.error('Failed to fetch products:', error)
      }
    }
  }
})