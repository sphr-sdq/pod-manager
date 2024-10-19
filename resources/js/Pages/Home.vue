<script setup>
import HideOnScrollNavbar from './components/HideOnScrollNavbar.vue'
import Hero from "./components/Hero.vue"

</script>

<template>
    <section >
        <nav >
            <HideOnScrollNavbar/>
        </nav>

    </section>
    <section>
        <main class="container ">
            <div class="h-20"></div>
            <div class="max-w-6xl mx-auto">
                <Hero height="600px">
                    <div class="mx-auto p-8">
                        <h1 class="text-4xl font-bold text-white">مثل ابر</h1>
                        <p class="text-white"></p>
                    </div>
                </Hero>
            </div>

        </main>
    </section>
    <section>
        <footer>

        </footer>
    </section>
</template>

<style scoped>

</style>
