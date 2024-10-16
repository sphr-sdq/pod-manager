<template>
    <nav :class="{ 'nav-hidden': !showNavbar, 'nav-visible': showNavbar }">
        <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </nav>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'

const showNavbar = ref(true)
const lastScrollPosition = ref(0)
const scrollThreshold = 60

const handleScroll = () => {
    const currentScrollPosition = window.pageYOffset || document.documentElement.scrollTop

    if (Math.abs(currentScrollPosition - lastScrollPosition.value) < scrollThreshold) {
        return
    }

    showNavbar.value = currentScrollPosition < lastScrollPosition.value
    lastScrollPosition.value = currentScrollPosition
}

onMounted(() => {
    window.addEventListener('scroll', handleScroll)
})

onBeforeUnmount(() => {
    window.removeEventListener('scroll', handleScroll)
})
</script>

<style scoped>
nav {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    background-color: #42b883;
    transition: transform 0.3s ease-in-out;
}

.nav-hidden {
    transform: translateY(-100%);
}

.nav-visible {
    transform: translateY(0);
}

ul {
    display: flex;
    justify-content: space-around;
    list-style-type: none;
    padding: 1rem 0;
    margin: 0;
}

a {
    color: white;
    text-decoration: none;
}
</style>
