<script setup>
import {Separator} from "@/Components/ui/separator/index.js";
import {Label} from "@/Components/ui/label/index.js";
import {Input} from "@/Components/ui/input/index.js";
import {Button} from '@/Components/ui/button';
import {useForm} from '@inertiajs/vue3';
import {ref} from "vue";
import {LoaderCircle} from 'lucide-vue-next';

import { useToast } from "@/composables/useToast.js";
const emitToast = useToast()

const props = defineProps({
    name: String,
    family: String,
    phoneNumber: String
})

const form = useForm({
    name: props.name ?? null,
    family: props.family ?? null
})


function sendMessageToParent(data) {

    emitToast(data)
}




function isFormEqualToProps() {
    return (
        form.name === props.name &&
        form.family === props.family
    );
}

function isFormsEmpty(){
    return (form.name.trim() === '' || form.family.trim() === '')
}

const isLoading = ref(false);

const handleRequest = () => {
    if(isFormsEmpty()){
        sendMessageToParent({
            message : 'نام و نام خانوادگی اجباری است'
        })
    }
    else if(isFormEqualToProps()){
        sendMessageToParent({
            message : 'مقادیر جدیدی وارد کنید'
        })
    }
    else {
        form.post('/dashboard/profile', {
            onStart: () => isLoading.value = true,
            onFinish:
                () => {

                    isLoading.value = false
                },
            onSuccess: () => {
                sendMessageToParent({
                    message : 'تغییرات با موفقیت ذخیره شد'
                })
            }
        })
    }
}
</script>

<template>

    <div>
        <h3 class="text-lg font-medium">
            تغییر مشخصات کاربری
        </h3>
        <p class="text-sm text-muted-foreground">
            می‌توانید برای تغییر مشخصات خود از این فرم اقدام نمایید.
        </p>
    </div>
    <Separator/>
    <form class="grid  gap-6" @submit.prevent="handleRequest">
        <div class="grid grid-cols-12  gap-12">
            <div class="col-span-6">
                <Label class="" for="Name">
                    نام
                </Label>
                <Input
                    v-model="form.name"
                    id="Name"
                    name="Name"
                    placeholder="نام"
                    type="text"
                    auto-correct="off"
                    dir="rtl"
                    :name
                    :disabled="isLoading"
                />
                <span v-if="form.errors.name" class="text-red-600 text-xs font-bold">{{ form.errors.name }}</span>
            </div>
            <div class="col-span-6">
                <Label class="" for="Family">
                    نام خانوادگی
                </Label>
                <Input
                    v-model="form.family"
                    id="Family"
                    name="Family"
                    placeholder="نام خانوادگی"
                    type="text"
                    auto-correct="off"
                    dir="rtl"
                    :default-value="family"
                    :disabled="isLoading"
                />
                <span v-if="form.errors.family" class="text-red-600 text-xs font-bold">{{ form.errors.family }}</span>
            </div>
        </div>
        <div class="grid grid-cols-12 gap-12">
            <div class="col-span-6">
                <Label class="" for="phoneNumber">
                    شماره موبایل
                </Label>
                <Input
                    id="phoneNumber"
                    name="phoneNumber"
                    disabled
                    placeholder="شماره موبایل"
                    type="text"
                    auto-correct="off"
                    dir="rtl"
                    :default-value="phoneNumber"
                />
            </div>
        </div>

        <div class="flex gap-2 justify-start">
            <Button type="submit" class="w-28" @click.prevent="handleRequest" :disabled="isLoading">
                <span v-if="!isLoading" class="">
                    ثبت تغییرات
                </span>
                <LoaderCircle v-else class="animate-spin "/>
            </Button>

        </div>
    </form>
</template>

<style scoped>

</style>
