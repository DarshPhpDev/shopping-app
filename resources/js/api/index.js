import axios from 'axios'
import { useAuthStore } from '@/stores/authStore'

const api = axios.create({
  baseURL: '/api', // Uses same domain as Laravel
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json'
  }
})

// Add request interceptor for auth tokens
api.interceptors.request.use(config => {
    const authStore = useAuthStore()  // Get fresh store instance
    if (authStore.getToken) {
      config.headers.Authorization = `Bearer ${authStore.getToken}`
    }
  return config
})

// Add response interceptor for error handling
api.interceptors.response.use(
  response => response,
  error => {
    if (error.response?.status === 401) {
      // Handle unauthorized
      console.error('Authentication required')
    }
    return Promise.reject(error)
  }
)

export default api