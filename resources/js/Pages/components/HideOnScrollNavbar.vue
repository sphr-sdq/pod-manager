<template>
    <nav class=" fixed z-[999] bg-white w-full duration-150  translate-x-1/2 border border-b-black/20"
         :class="{ 'nav-hidden': !showNavbar, 'nav-visible': showNavbar }">
        <div class="container ">
            <div class="grid grid-cols-12 p-2">


                <div class="col-span-4 ">Logo</div>

                <div class="col-span-4">
                    <NavigationMenu >
                        <NavigationMenuList >
                            <NavigationMenuItem>
                                <NavigationMenuTrigger>Components</NavigationMenuTrigger>
                                <NavigationMenuContent>
                                    <ul class="grid w-[400px] gap-3 p-4 md:w-[500px] md:grid-cols-2 lg:w-[600px] ">
                                        <li v-for="component in components" :key="component.title">
                                            <NavigationMenuLink as-child>
                                                <a
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
                                                </a>
                                            </NavigationMenuLink>
                                        </li>
                                    </ul>
                                </NavigationMenuContent>
                            </NavigationMenuItem>
                        </NavigationMenuList>
                    </NavigationMenu>
                </div>

                <div class="col-span-4  flex justify-end items-center gap-2">
                    <Button @click="router.visit('/login')">
                        ورود
                    </Button>
                    <Button variant="outline" @click="router.visit('/register')">
                        ثبت نام
                    </Button>
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
} from '@/components/ui/navigation-menu'
import { Button } from '@/components/ui/button'
import { router } from '@inertiajs/vue3'
const components = [
    {
        title: 'Alert Dialog',
        href: '/docs/components/alert-dialog',
        description:
            'A modal dialog that interrupts the user with important content and expects a response.',
    },
    {
        title: 'Hover Card',
        href: '/docs/components/hover-card',
        description:
            'For sighted users to preview content available behind a link.',
    },
    {
        title: 'Progress',
        href: '/docs/components/progress',
        description:
            'Displays an indicator showing the completion progress of a task, typically displayed as a progress bar.',
    },
    {
        title: 'Scroll-area',
        href: '/docs/components/scroll-area',
        description: 'Visually or semantically separates content.',
    },
    {
        title: 'Tabs',
        href: '/docs/components/tabs',
        description:
            'A set of layered sections of content—known as tab panels—that are displayed one at a time.',
    },
    {
        title: 'Tooltip',
        href: '/docs/components/tooltip',
        description:
            'A popup that displays information related to an element when the element receives keyboard focus or the mouse hovers over it.',
    },
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
