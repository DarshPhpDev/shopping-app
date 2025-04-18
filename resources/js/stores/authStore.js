import { defineStore } from 'pinia'
import api from '@/api'

export const useAuthStore = defineStore('auth', {
	state: () => ({
		token: localStorage.getItem('token') || null,
	}),
    getters: {
      isAuthenticated: (state) => !!state.token,
      getToken: (state) => state.token
    },
	actions: {
		async login(credentials) {
			const { data } = await api.post('/login', credentials)
			this.token = data.data.access_token
			localStorage.setItem('token', data.data.access_token)
			// axios.defaults.headers.common['Authorization'] = `Bearer ${data.data.access_token}`
		},
		async register(credentials) {
			const { data } = await api.post('/register', credentials)
			this.token = data.data.access_token
			localStorage.setItem('token', data.data.access_token)
			// axios.defaults.headers.common['Authorization'] = `Bearer ${data.data.access_token}`
		},
		logout() {
            api.post('/logout')
			this.token = null
			localStorage.removeItem('token')
			delete axios.defaults.headers.common['Authorization']
		}
	},
})
