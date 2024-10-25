// useToast.js
import { provide, inject, readonly } from 'vue'

const TOAST_KEY = Symbol('toast')

let cachedHandler = null

export function provideToast(handler) {
    if (!cachedHandler) {
        cachedHandler = readonly((data) => {
            handler(data)
        })
    }
    provide(TOAST_KEY, cachedHandler)
}

export function useToast() {
    const toast = inject(TOAST_KEY)
    if (!toast) {
        throw new Error('Toast handler not provided')
    }
    return toast
}
