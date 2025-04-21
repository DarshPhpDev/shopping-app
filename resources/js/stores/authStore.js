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
        /*
        * Store Login action, recieves credentials email/password and post them to login api 
        * if user authentication was successful stores the response token into the state and local storage as permenant storage
        * then shows success message and return true
        * otherwise throw the error and it will be handled by the api file then return false
        */
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

        /*
        * Store Register action, recieves credentials name/email/password and post them to register api 
        * if user registeration was successful stores the response token into the state and local storage as permenant storage
        * then shows success message and return true
        * otherwise throw the error and it will be handled by the api file then return false
        */
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

        /*
        * Store Logout action, Hits the logout api and clear the token from state and localStorage 
        * then shows success message
        * otherwise the error will be handled by the api file
        */
		async logout() {
            const response = await api.post('/logout')
			this.token = null
			localStorage.removeItem('token')
            showAlert(response.data.status.message, '', 'success')
		}
	},
})
