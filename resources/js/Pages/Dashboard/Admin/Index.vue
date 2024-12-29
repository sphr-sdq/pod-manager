<script setup>
import AdminSidebarNav from "@/Pages/Dashboard/Admin/Layout/AdminSidebarNav.vue";
import {Separator} from "@/Components/ui/separator"
import {useToast} from '@/Components/ui/toast/use-toast.js'
import Toaster from "../../../Components/ui/toast/Toaster.vue";
const { toast } = useToast()

import { provide , readonly, markRaw } from 'vue'

import { provideToast } from "@/composables/useToast.js";

defineProps({
    bannerTitle : String,
    bannerBody : String
})



provideToast ((data) => {
    toast({
        description: data.message,
    });
})



</script>

<template>
    <Toaster/>
        <div class="hidden space-y-6 p-10 pb-16 md:block">
            <div class="space-y-0.5">
                <h2 class="text-2xl font-bold tracking-tight">
                    {{bannerTitle}}
                </h2>
                <p class="text-muted-foreground">
                    {{bannerBody }}
                </p>
            </div>
            <Separator class="my-6" />
            <div class="flex flex-col space-y-8 lg:flex-row lg:space-x-12 lg:space-y-0">
                <aside class="mx-4 lg:w-1/5">
                    <AdminSidebarNav/>
                </aside>
                <div class="flex-1 lg:max-w-2xl">
                    <div class="space-y-6">
                        <slot />
                    </div>
                </div>
            </div>
        </div>

</template>
