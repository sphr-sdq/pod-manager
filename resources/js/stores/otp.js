/**
 * js
 */

import {defineStore} from 'pinia'

export const useOTPStore = defineStore('otp', {
    state: () => ({
        remainingSeconds: null,
        errorTime: null,
        hasError: false,
        currentTime: Date.now(), // Add this
        phoneNumber : null
    }),

    getters: {
        getRemainingTime(state) {
            return Math.ceil(state.remainingSeconds - ((state.currentTime - state.errorTime) / 1000))
        }
    },

    actions: {
        setErrorTime(rs , phoneNumber) {
            this.remainingSeconds = rs;
            this.errorTime = Date.now();
            this.hasError = true;
            this.phoneNumber = phoneNumber;

            // Start timer to update currentTime
            const timer = setInterval(() => {
                this.currentTime = Date.now();

                // Stop timer when time is up
                if (this.getRemainingTime <= 0) {
                    clearInterval(timer);
                    this.hasError = false;
                }
            }, 1000);
        }
    }
})
