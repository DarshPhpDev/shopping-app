import { mount } from '@vue/test-utils'
import CartLink from '@/components/cart/CartLink.vue'
import { createPinia, setActivePinia } from 'pinia'
import { useCartStore } from '@/stores/cartStore'
import { describe, beforeEach, it, expect } from 'vitest'

describe('CartLink', () => {
    let store
  
    beforeEach(() => {
        setActivePinia(createPinia())
        store = useCartStore()
        store.items = [
            { id: 1, price: 10, quantity: 2 },
            { id: 2, price: 20, quantity: 1 }
        ]
    })
    
    // Test cart count and total showing in navbar when cart has items
    it('displays cart count and total', () => {
        const wrapper = mount(CartLink)
        expect(wrapper.text()).toContain('3') // 2 + 1 quantities
        expect(wrapper.text()).toContain('40') // (10*2 + 20*1)
    })

    // Test cart count and total showing in navbar when cart is empty
    it('shows 0 when cart is empty', () => {
        store.items = []
        const wrapper = mount(CartLink)
        expect(wrapper.text()).toContain('0 ($0.00')
    })
})