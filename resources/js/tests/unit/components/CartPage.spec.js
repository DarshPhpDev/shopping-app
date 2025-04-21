import { mount } from '@vue/test-utils'
import CartPage from '@/components/cart/CartPage.vue'
import { createPinia, setActivePinia } from 'pinia'
import { useCartStore } from '@/stores/cartStore'
import { createRouter, createWebHistory } from 'vue-router'
import { describe, beforeEach, it, expect, vi } from 'vitest'

// Mock router
const router = createRouter({
    history: createWebHistory(),
    routes: []
})

describe('CartPage', () => {
    let store

    beforeEach(() => {
        setActivePinia(createPinia())
        store = useCartStore()
        store.items = []
        store.removeItem = vi.fn()
        store.updateQuantity = vi.fn()
    })

    // Mount the CartPage component and define bootstrap components as global stubs to avoid warnings
    const mountComponent = () => {
        return mount(CartPage, {
            global: {
                plugins: [router],
                stubs: {
                    'router-link': true,
                    'b-container': { template: '<div><slot /></div>' },
                    'b-list-group': { template: '<div><slot /></div>' },
                    'b-list-group-item': { template: '<div><slot /></div>' },
                    'b-img': { template: '<img />' },
                    'b-button': { 
                        template: '<button @click="$emit(\'click\')"><slot /></button>' 
                    },
                    'b-form-input': { template: '<input />' }
                }
            }
        })
    }

    // test empty message when cart is empty
    it('shows empty message if cart is empty', () => {
        store.items = []
        const wrapper = mountComponent()
        expect(wrapper.text()).toContain('Your cart is empty')
    })

    // test rendering correct cart items when cart has items.
    it('displays cart items and total when not empty', async () => {
        store.items = [
            { id: 1, title: 'Product 1', price: 10, image: 'test.jpg', quantity: 1 },
            { id: 2, title: 'Product 2', price: 20, image: 'test2.jpg', quantity: 1 }
        ]
        const wrapper = mountComponent()
        await wrapper.vm.$nextTick()
        expect(wrapper.text()).toContain('Product 1')
        expect(wrapper.text()).toContain('$10')
        expect(wrapper.text()).toContain('Total: $30')
    })

    // test remove cart item functionality.
    it('removes an item when clicking remove', async () => {
        store.items = [
            { id: 1, title: 'Product 1', price: 10, image: 'test.jpg', quantity: 1 }
        ]
        const wrapper = mountComponent()
        await wrapper.vm.$nextTick()
        
        const removeBtn = wrapper.find('[data-test="remove-btn"]')
        await removeBtn.trigger('click')
        
        expect(store.removeItem).toHaveBeenCalledWith(0)
    })

    // test update item quantity functionality.
    it('updates quantity when changed', async () => {
        store.items = [
            { id: 1, title: 'Product 1', price: 10, image: 'test.jpg', quantity: 1 }
        ]
        const wrapper = mountComponent()
        await wrapper.vm.$nextTick()
        
        const quantityInput = wrapper.find('[data-test="quantity-input"]')
        await quantityInput.setValue(3)
        
        expect(store.updateQuantity).toHaveBeenCalledWith(0, 3)
    })
})