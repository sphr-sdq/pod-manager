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
} from '@/Components/ui/card'
import {Button} from "@/Components/ui/button";
import UserAuthForm from "@/Pages/components/UserAuthForm.vue";
import {ref} from "vue";
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from '@/Components/ui/accordion'
import {Link} from "@inertiajs/vue3"




defineProps({
    pods : Array,
    tags : Array
})
</script>

<template>
    <section >
        <nav >
            <HideOnScrollNavbar/>
        </nav>
    </section>

    <div class="grid gap-4 grid-cols-2 pt-20 container">
        <Card v-for="(pod , index) in pods" :key="index">
            <CardHeader>
                <CardTitle class="flex items-center gap-3">
                    <img  :alt="pod.name" :src="'storage/' + pod.image_path" height="50px" width="50px" />
                    <Link :href="'/pods/'+pod.slug" class="underline opacity-70 hover:opacity-100">
                        {{pod.name}}
                    </Link>

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


.features-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    padding: 20px;
}

.feature-box {
    background: #f9f9f9;
    border: 1px solid #e0e0e0;
    padding: 20px;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s, background 0.3s;
    cursor: pointer;
}

.feature-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    background: #ffffff;
}

.feature-box.hovered {
    border-color: #1e1e1e;
}

.feature-icon {
    font-size: 40px;
    color: #656565;
    margin-bottom: 15px;
    transition: transform 0.3s;
}

.feature-box:hover .feature-icon {
    transform: rotate(20deg);
}

.feature-title {
    font-size: 18px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

.feature-description {
    font-size: 14px;
    color: #666;
}

.hover\:text-gray-400 {
    transition: color 0.3s ease;
}
</style>
