export const showAlert = (title, message, variant = 'danger') => {
    // Create alert element
    const alert = document.createElement('div')
    alert.className = `alert alert-${variant} alert-dismissible fade show`
    alert.style.position = 'fixed'
    alert.style.top = '20px'
    alert.style.right = '20px'
    alert.style.zIndex = '9999'
    alert.style.minWidth = '300px'
    alert.role = 'alert'

    // Add content
    alert.innerHTML = `
        <strong>${title}</strong> ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `

    // Add to DOM
    document.body.appendChild(alert)

    // Auto-remove after 5 seconds
    setTimeout(() => {
    alert.remove()
    }, 5000)
}

export const showApiError = (error) => {
    let title = 'Error'
    let message = 'An unknown error occurred'

    if (error.response) {
        // Handle HTTP error responses
        title = `Error (${error.response.status})`
        message = error.response.data?.status?.message || 
                  error.response.data?.error ||
                  error.message
    } else if (error.request) {
        // Handle no response errors
        title = 'Network Error'
        message = 'Could not connect to the server'
    } else {
        // Handle other errors
        message = error.message
    }

    showAlert(title, message)
}