import axios from 'axios'
import { useAuthStore } from '@/stores/authStore'
import { handleApiError } from '@/utils/errorHandler'

// Define baseURL and default headers for axios
const api = axios.create({
  baseURL: '/api',
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json'
  }
})

// Add request interceptor for auth tokens
api.interceptors.request.use(config => {
    const authStore = useAuthStore()
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
        localStorage.removeItem('token');
    }
    handleApiError(error)
    return Promise.reject(error)
  }
)

export default api