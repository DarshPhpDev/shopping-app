import { defineStore } from 'pinia'
import api from '@/api'

export const useProductStore = defineStore('products', {
	state: () => ({
		products: []
	}),
	actions: {
		async fetchProducts() {
			try {
		        const { data } = await api.get('/products')
		        this.products = data.data.products
		    } catch (error) {
		    	console.error('Failed to fetch products:', error)
		    }
		}
	}
});