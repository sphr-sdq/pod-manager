<script setup>
import HideOnScrollNavbar from './components/HideOnScrollNavbar.vue'
import Hero from "./components/Hero.vue"
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
import {Button} from "@/Components/ui/button";
import UserAuthForm from "@/Pages/components/UserAuthForm.vue";


defineProps({
    pods : Array
})
</script>

<template>
    <section >
        <nav >
            <HideOnScrollNavbar/>
        </nav>

    </section>
    <section>
        <main class="container">
            <div class="h-20"></div>
            <div class=" mx-auto">
                <Hero height="610px">
                    <div class="mx-auto p-8">
                        <h1 class="text-4xl font-bold text-white">مثل ابر</h1>
                        <p class="text-white"></p>
                    </div>
                </Hero>
            </div>

        </main>
    </section>
    <section class="container mt-16 mb-8">
        <div class="flex flex-row items-baseline gap-2 mb-8">
            <div class="w-3 h-3 border-2 border-black p-0.5">
                <div class="w-full h-full bg-black"></div>
            </div>
            <h1 class="text-3xl font-bold"> پاد‌ها</h1>
        </div>

        <div class="grid gap-4 grid-cols-2">
        <Card v-for="(pod , index) in pods" :key="index">
            <CardHeader>
                <CardTitle class="flex items-center gap-3">
                    <img  :alt="pod.name" :src="'storage/' + pod.image_path" height="50px" width="50px" />
                    <a href="#" class="underline opacity-70 hover:opacity-100">
                        <span>{{pod.name}}</span>
                    </a>

                </CardTitle>
                <CardDescription class="text-container" v-html="pod.description">
                </CardDescription>
            </CardHeader>
            <CardContent>

                    <Button
                        v-for="(tag, iindex) in pod.tags"
                        variant="outline"
                        size="sm"
                        :key="iindex"
                        :class="[
                            iindex !== 0 ? 'mr-2' : '',
                            'h-7 border-dashed hover:border-red-500 hover:bg-red-50 hover:text-red-600 transition-colors'
                        ]"
                    >
                        <span class="ml-1" >{{ tag.name }}</span>

                    </Button>

            </CardContent>
        </Card>
        </div>
    </section>
    <section class="container">
        <footer >

        </footer>
    </section>
</template>

<style scoped>
.text-container {
    display: -webkit-box;
    -webkit-line-clamp: 3; /* Limit the text to 3 lines */
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.5em; /* Adjust line height for spacing */
    max-height: 4.5em; /* Ensures it hides after 3 lines */
    position: relative;

    /* Create the gradient fade effect at the bottom of the text */
    //background: linear-gradient(to top, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 100%);
    //-webkit-mask-image: linear-gradient(to top, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 100%);
    mask-image: linear-gradient(to top, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 100%);
}
</style>
