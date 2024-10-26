<script setup lang="js">
import {Button} from '@/Components/ui/button'
import {Link} from '@inertiajs/vue3'
import {cn} from '@/lib/utils'



const sidebarNavItems = [
    {
        title: 'پروفایل',
        href: '/dashboard/profile',
    },
    {
        title: 'تگ ها',
        href: '/dashboard/tag',
    },
    {
        title: 'پاد‌ها',
        href: '/dashboard/pod',
    },
    {
        title: 'پست ها',
        href: '/dashboard/pots',
    },
    {
        title: 'سرور ها',
        href: '/dashboard/servers',
    },
    {
        title: 'کاربران',
        href: '/dashboard/users',
    },
]
</script>

<template>
    <nav class="flex space-x-2 lg:flex-col lg:space-x-0 lg:space-y-1">
        <Link
            v-for="item in sidebarNavItems"
            :key="item.title"
            :href="item.href"
            preserve-scroll
        >
            <Button
                as="a"
                variant="ghost"
                class="w-full text-left justify-start"
                :class="{ 'bg-muted hover:bg-muted' :  $page.url === item.href}"
            >
                {{ item.title }}
            </Button>
        </Link>
    </nav>
</template>
