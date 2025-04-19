import { defineStore } from 'pinia'
import api from '@/api'
import { showAlert } from '@/utils/alert.js'
export const useAuthStore = defineStore('auth', {
	state: () => ({
		token: localStorage.getItem('token') || null,
        isLoading: false,
        error: null
	}),
    getters: {
      isAuthenticated: (state) => !!state.token,
      getToken: (state) => state.token
    },
	actions: {
		async login(credentials) {
            this.isLoading = true
            this.error = null
            try {
                const { data } = await api.post('/login', credentials)
                this.token = data.data.access_token
                localStorage.setItem('token', data.data.access_token)
                showAlert(data.status.message, '', 'success')
                return true;
            } catch (error) {
                throw error
                return false;
            } finally {
                this.isLoading = false
            }
		},
		async register(credentials) {
            this.isLoading = true
            this.error = null
            try {
                const { data } = await api.post('/register', credentials)
                this.token = data.data.access_token
                localStorage.setItem('token', data.data.access_token)
                showAlert(data.status.message, '', 'success')
                return true
            } catch (error) {
                throw error
                return false
            } finally {
                this.isLoading = false
            }
		},
		async logout() {
            const response = await api.post('/logout')
			this.token = null
			localStorage.removeItem('token')
            showAlert(response.data.status.message, '', 'success')
		}
	},
})
