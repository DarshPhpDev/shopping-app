import { defineStore } from 'pinia'
import api from '@/api'

export const useProductStore = defineStore('products', {
	state: () => ({
		products: [],
        isLoading: false,
        meta: null,
        links: null,
        currentPage: 1
	}),
	actions: {
        // fetch all products from the /products api to render them on ProductList page.
		async fetchProducts(page = 1) {
            this.isLoading = true
			try {
		        const { data } = await api.get(`/products?page=${page}`)
		        this.products = data.data.products.data
                this.meta = {
                    current_page: data.data.products.current_page,
                    per_page: data.data.products.per_page,
                    total: data.data.products.total
                }
                this.links = data.data.products.links
                this.currentPage = this.meta.current_page
		    } catch (error) {
		    	throw error
		    } finally {
                this.isLoading = false
            }
		}
	}
});