<script setup lang="js">
import {ref} from 'vue'
import LucideSpinner from '~icons/lucide/loader-2'

import {cn} from '@/lib/utils'
import {Button} from '@/Components/ui/button'
import {Input} from '@/Components/ui/input'
import {Label} from '@/Components/ui/label'
import {Link, useForm} from '@inertiajs/vue3'


const isLoading = ref(false)

const loginForm = useForm({
    phoneNumber : '',
    password : ''
})

async function onSubmit() {

    loginForm.post('/login' , {
        onStart : () => isLoading.value = true,
        onFinish : () => isLoading.value = false
    })
}
</script>

<template>
    <div :class="cn('grid gap-6', $attrs.class ?? '')">

        <div class="">
            <div class="flex flex-row items-baseline gap-2 mb-2">
                    <div class="w-3 h-3 border-2 border-black p-0.5">
                        <div class="w-full h-full bg-black"></div>
                    </div>
                <h1 class="text-3xl font-bold">ورود</h1>
            </div>

            <h3 class="text-sm text-muted-foreground">
                برای ورود به حساب کاربری شماره موبایل و رمز عبور خود را وارد کنید.
            </h3>
        </div>

        <form @submit.prevent="onSubmit">
            <div class="grid gap-2">
                <div class="grid gap-1">
                    <Label class="" for="phoneNumber">
                        شماه موبایل
                    </Label>
                    <Input
                        v-model="loginForm.phoneNumber"
                        id="phoneNumber"
                        placeholder="09*********"
                        type="tel"
                        auto-capitalize="none"
                        auto-correct="off"
                        :disabled="isLoading"
                        dir="ltr"
                    />
                    <span class="text-red-600 text-xs font-bold" v-if="loginForm.errors.phoneNumber">{{loginForm.errors.phoneNumber}}</span>
                </div>

                <div class="grid gap-1">
                    <Label class="" for="password">
                        رمز عبور
                    </Label>
                    <Input
                        v-model="loginForm.password"
                        id="password"
                        placeholder=""
                        type="password"
                        auto-capitalize="none"
                        auto-correct="off"
                        :disabled="isLoading"
                        dir="ltr"
                    />
                    <span class="text-red-600 text-xs font-bold" v-if="loginForm.errors.password">{{loginForm.errors.password}}</span>
                </div>
                <Button @click="onSubmit" :disabled="isLoading">
                    <LucideSpinner v-if="isLoading" class="mr-2 h-4 w-4 animate-spin"/>
                    <span v-else>
                        ورود
                    </span>
                </Button>
            </div>
        </form>

        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <span class="w-full border-t"/>
            </div>
            <div class="relative flex justify-center text-xs uppercase">
        <span class="bg-background px-2 text-muted-foreground">
          و یا
        </span>
            </div>
        </div>

<!--        <p class=" text-sm text-muted-foreground">-->
<!--            در صورتی که رمز عبور خود را فراموش کرده‌اید برای ورود با رمز یکبار مصرف-->
<!--            <a-->
<!--                href="/terms"-->
<!--                class="underline underline-offset-4 hover:text-primary"-->
<!--            >-->
<!--                اینجا کلیک کنید.-->
<!--            </a>-->

<!--        </p>-->
        <p class="text-sm text-muted-foreground">
            هنوز اکانت ندارید ؟ برای ساخت اکانت
            <Link
                href="/register"
                class="underline underline-offset-4 hover:text-primary"
            >
                کلیک
            </Link>
            کنید.
        </p>

    </div>


</template>
