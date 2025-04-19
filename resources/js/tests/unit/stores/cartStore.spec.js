import { setActivePinia, createPinia } from 'pinia'
import { useCartStore } from '@/stores/cartStore'
import { describe, beforeEach, it, expect } from 'vitest'

describe('Cart Store', () => {
    beforeEach(() => {
        setActivePinia(createPinia())
        localStorage.clear()
    })
    
    // use a mock product to test assertions against
    const mockProduct = { id: 1, title: 'Test', price: 10 }

    // test adding item to cart store action
    it('adds items to cart', () => {
        const store = useCartStore()
        store.addItem(mockProduct)
        
        expect(store.items).toHaveLength(1)
        expect(localStorage.getItem('cart')).toBeTruthy()
    })

    // test updating cart quantity store action
    it('updates quantity', () => {
        const store = useCartStore()
        store.addItem(mockProduct)
        store.updateQuantity(0, 5)
        
        expect(store.items[0].quantity).toBe(5)
    })

    // test total calculator getter in store
    it('calculates total correctly', () => {
        const store = useCartStore()
        store.addItem({ ...mockProduct, price: 10 })
        store.addItem({ ...mockProduct, id: 2, price: 20 })
        
        expect(store.total).toBe(30)
    })
})