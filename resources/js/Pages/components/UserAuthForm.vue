<script setup lang="js">
import { ref } from 'vue'
import LucideSpinner from '~icons/lucide/loader-2'
import GitHubLogo from '~icons/radix-icons/github-logo'

import { cn } from '@/lib/utils'
import { Button } from '@/Components/ui/button'
import { Input } from '@/Components/ui/input'
import { Label } from '@/Components/ui/label'

const isLoading = ref(false)
async function onSubmit(event) {
    event.preventDefault()
    isLoading.value = true

    setTimeout(() => {
        isLoading.value = false
    }, 3000)
}
</script>

<template>
    <div :class="cn('grid gap-6', $attrs.class ?? '')">
        <form @submit="onSubmit">
            <div class="grid gap-2">
                <div class="grid gap-1">
                    <Label class="" for="email">
                        شماه همراه
                    </Label>
                    <Input
                        id="email"
                        placeholder=""
                        type="tel"
                        auto-capitalize="none"
                        auto-complete="email"
                        auto-correct="off"
                        :disabled="isLoading"
                        dir="ltr"
                    />
                </div>
                <div class="grid gap-1">
                    <Label class="" for="email">
                        رمز عبور
                    </Label>
                    <Input
                        id="email"
                        placeholder=""
                        type="password"
                        auto-capitalize="none"
                        auto-correct="off"
                        :disabled="isLoading"
                        dir="ltr"
                    />
                </div>
                <Button :disabled="isLoading">
                    <LucideSpinner v-if="isLoading" class="mr-2 h-4 w-4 animate-spin" />
                    ورود
                </Button>
            </div>
        </form>
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <span class="w-full border-t" />
            </div>
            <div class="relative flex justify-center text-xs uppercase">
        <span class="bg-background px-2 text-muted-foreground">
          و یا
        </span>
            </div>
        </div>
        <p class="px-8 text-center text-sm text-muted-foreground">
            در صورتی که رمز عبور خود را فراموش کرده‌اید برای ورود با رمز یکبار مصرف
            <a
                href="/terms"
                class="underline underline-offset-4 hover:text-primary"
            >
                اینجا کلیک کنید.
            </a>

        </p>
        <p class="px-8 text-center text-sm text-muted-foreground">
             هنوز اکانت ندارید ؟ برای ساخت اکانت
            <a
                href="/terms"
                class="underline underline-offset-4 hover:text-primary"
            >
               کلیک
            </a>
            کنید.
        </p>
    </div>
</template>
