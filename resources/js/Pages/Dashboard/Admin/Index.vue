<script setup>
import AdminSidebarNav from "@/Pages/Dashboard/Admin/Layout/AdminSidebarNav.vue";
import {Separator} from "@/Components/ui/separator"
defineProps({
    bannerTitle : String,
    bannerBody : String
})
</script>

<template>
        <div class="hidden space-y-6 p-10 pb-16 md:block">
            <div class="space-y-0.5">
                <h2 class="text-2xl font-bold tracking-tight">
                    {{bannerTitle}}
                </h2>
                <p class="text-muted-foreground">
                    {{bannerBody}}
                </p>
            </div>
            <Separator class="my-6" />
            <div class="flex flex-col space-y-8 lg:flex-row lg:space-x-12 lg:space-y-0">
                <aside class="-mx-4 lg:w-1/5">
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
