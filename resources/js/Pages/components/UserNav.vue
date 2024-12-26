<script setup lang="js">
import {
    Avatar,
    AvatarFallback,
    AvatarImage,
} from '@/Components/ui/avatar'
import { Button } from '@/Components/ui/button'
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuShortcut,
    DropdownMenuTrigger,
} from '@/Components/ui/dropdown-menu'

import {Link} from '@inertiajs/vue3';

defineProps({
    isDashboard : {
        type : Boolean,
        default: false
    }
})
</script>

<template>
    <DropdownMenu >
        <DropdownMenuTrigger as-child>
            <Button variant="ghost" class="relative h-8 w-8 rounded-full">
                <Avatar class="h-8 w-8">
                    <AvatarImage src="/avatars/01.png" alt="@shadcn" />
                    <AvatarFallback>SC</AvatarFallback>
                </Avatar>
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent class="w-56" align="end">
            <DropdownMenuLabel class="font-normal flex">
                <div class="flex flex-col space-y-1">
                    <p class="text-sm font-medium leading-none">
                       {{$page.props.auth.user.name}} {{$page.props.auth.user.family}}
                    </p>
                    <p class="text-xs leading-none text-muted-foreground">
                        {{$page.props.auth.user.phoneNumber}}
                    </p>
                </div>
            </DropdownMenuLabel>
            <DropdownMenuSeparator />
            <DropdownMenuGroup>
                <DropdownMenuItem class="flex flex-row-reverse  w-full">
                    <div  class="w-full text-end">
                        <Link  v-if="!isDashboard" href="/dashboard" class="w-full block">
                            داشبورد
                        </Link>
                        <Link  v-else href="/" class="w-full block">
                            صفحه‌ی اصلی
                        </Link>
                    </div>

                </DropdownMenuItem>
            </DropdownMenuGroup>
            <DropdownMenuSeparator />
            <DropdownMenuItem class="flex flex-row-reverse  w-full">
                <div class="w-full text-end">
                    <Link href="/logout" method="POST" class="w-full block">
                        خروچ
                    </Link>

                </div>

            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
