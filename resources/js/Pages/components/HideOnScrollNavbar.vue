<template>
    <nav class=" fixed z-[995] bg-white w-full duration-150  translate-x-1/2 border border-b-black/20"
         :class="{ 'nav-hidden': !showNavbar, 'nav-visible': showNavbar }">
        <div class="container ">
            <div class="grid grid-cols-12 py-2">


                <div class="col-span-4 flex items-center">
                    <img width="50px" height="50px" src="/Logo.svg" alt="Logo">
                    <span class="text-2xl">
                       <Link href="/">
                           پاد پلکس
                       </Link>

                    </span>
                </div>


                <div class="col-span-4 flex content-center justify-center" >
                    <NavigationMenu >
                        <NavigationMenuList  >
                            <NavigationMenuItem  >
                                <NavigationMenuTrigger class="gap-2">پاد‌ها</NavigationMenuTrigger>
                                <NavigationMenuContent>
                                    <ul class=" grid w-[400px] gap-3 p-4 md:w-[500px] lg:w-[300px]" >
                                        <li v-for="component in components" :key="component.title" >
                                            <NavigationMenuLink as-child >
                                                <Link
                                                    :href="component.href"
                                                    class="block select-none space-y-1 rounded-md p-3 leading-none no-underline outline-none transition-colors hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground"
                                                >
                                                    <div class="text-sm font-medium leading-none">{{
                                                            component.title
                                                        }}
                                                    </div>
                                                    <p class="line-clamp-2 text-sm leading-snug text-muted-foreground">
                                                        {{ component.description }}
                                                    </p>
                                                </Link>
                                            </NavigationMenuLink>
                                        </li>
                                    </ul>
                                </NavigationMenuContent>
                            </NavigationMenuItem>

                            <NavigationMenuItem>
                                <NavigationMenuLink as-child :class="navigationMenuTriggerStyle()">
                                    <Link href="/docs/introduction" >
                                        آموزش
                                    </Link>

                                </NavigationMenuLink>
                            </NavigationMenuItem>
                        </NavigationMenuList>
                    </NavigationMenu>
                </div>

                <div class="col-span-4">
                    <div v-if="!$page.props.auth.user" class=" flex justify-end items-center gap-2">
                        <Button @click="router.visit('/login')">
                            ورود
                        </Button>
                        <Button variant="outline" @click="router.visit('/register')">
                            ثبت نام
                        </Button>
                    </div>
                    <div v-else  class=" flex justify-end items-center gap-2">
<!--                        <Button variant="outline" @click.prevent="router.post('/logout')">-->
<!--                            خروج-->
<!--                        </Button>-->
                        <UserNav/>
                    </div>

                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import {ref, onMounted, onBeforeUnmount} from 'vue'
import { Slash } from 'lucide-vue-next';

import {Link} from "@inertiajs/vue3"
import {
    NavigationMenu,
    NavigationMenuContent,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    NavigationMenuTrigger,
    navigationMenuTriggerStyle,
} from '@/Components/ui/navigation-menu'
import { Button } from '@/Components/ui/button'
import { router } from '@inertiajs/vue3'

import UserNav from '../components/UserNav.vue';
const components = [
    {
        title: 'همه‌ی پاد‌ها',
        href: '/pods',
        description:
            'پاد مورد نظر خود را انتخاب کنید',
    }

]

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


.nav-hidden {
    transform: translateY(-100%);
}

.nav-visible {
    transform: translateY(0);
}


</style>
