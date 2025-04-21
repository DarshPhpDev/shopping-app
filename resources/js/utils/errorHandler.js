import { showApiError } from './alert'

export const handleApiError = (error) => {
    showApiError(error)

    // Return error data for component handling
    return {
        title: 'Error',
        message: error.response?.data?.message || error.message || 'An error occurred'
    }
}