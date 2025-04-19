import { defineStore } from 'pinia'
import api from '@/api'

export const useProductStore = defineStore('products', {
	state: () => ({
		products: [],
        isLoading: false
	}),
	actions: {
        // fetch all products from the /products api to render them on ProductList page.
		async fetchProducts() {
            this.isLoading = true
			try {
		        const { data } = await api.get('/products')
		        this.products = data.data.products
		    } catch (error) {
		    	throw error
		    } finally {
                this.isLoading = false
            }
		}
	}
});