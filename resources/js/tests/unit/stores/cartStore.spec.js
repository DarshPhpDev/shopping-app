import { setActivePinia, createPinia } from 'pinia'
import { useCartStore } from '@/stores/cartStore'
import { describe, beforeEach, it, expect } from 'vitest'

describe('Cart Store', () => {
  beforeEach(() => {
    setActivePinia(createPinia())
    localStorage.clear()
  })

  const mockProduct = { id: 1, title: 'Test', price: 10 }

  it('adds items to cart', () => {
    const store = useCartStore()
    store.addItem(mockProduct)
    
    expect(store.items).toHaveLength(1)
    expect(localStorage.getItem('cart')).toBeTruthy()
  })

  it('updates quantity', () => {
    const store = useCartStore()
    store.addItem(mockProduct)
    store.updateQuantity(0, 5)
    
    expect(store.items[0].quantity).toBe(5)
  })

  it('calculates total correctly', () => {
    const store = useCartStore()
    store.addItem({ ...mockProduct, price: 10 })
    store.addItem({ ...mockProduct, id: 2, price: 20 })
    
    expect(store.total).toBe(30)
  })
})