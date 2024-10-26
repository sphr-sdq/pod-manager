<script>
import Index from './Index.vue'

export default {

    layout: Index,
}
</script>

<script setup>
import {ref} from "vue";
import {useToast} from '@/composables/useToast.js'
import {useForm} from "@inertiajs/vue3";
import {Separator} from "@/Components/ui/separator/index.js";
import {Input} from "@/Components/ui/input/index.js";
import {Button} from "@/Components/ui/button/index.js";
import {Label} from "@/Components/ui/label/index.js";
import {LoaderCircle} from 'lucide-vue-next';

const form = useForm({
    tag: ''
})
const emitToast = useToast()

const isLoading = ref(false)


const handleRequest = () => {
    form.post('/dashboard/tag', {
        onStart: () => {
            isLoading.value = true
        },
        onFinish: () => {
            isLoading.value = false
        },
        onSuccess: () => {
            emitToast({message: "تگ جدید اضافه شد"})
            form.reset()
        }
    })
}

</script>

<template>
    <div>
        <h3 class="text-lg font-medium">
            مدیریت تگ ها
        </h3>
        <p class="text-sm text-muted-foreground">
            از این طریق می‌توانید برای حذف و یا اضافه کردن تگ ها اقدام کنید.
        </p>
    </div>
    <Separator/>
    <form @submit.prevent="handleRequest" method="POST">
        <div class="grid grid-cols-12 gap-10">
            <div class="col-span-8">
                <Label class="sr-only" for="">اضافه کردن تگ</Label>
                <Input
                    name="tag"
                    id="tag"
                    placeholder="Database"
                    dir="ltr"
                    :disabled="isLoading"
                    v-model="form.tag"
                />
                <span v-if="form.errors.tag" class="text-red-600 font-bold text-sm">{{form.errors.tag}}</span>
            </div>
            <div class="col-span-4">
                <Button :disabled="isLoading" class="w-full" @click.prevent="handleRequest">
                    <span v-if="!isLoading">ثبت</span>
                    <LoaderCircle v-else class="animate-spin"/>
                </Button>
            </div>
        </div>
    </form>
</template>

<style scoped>

</style>
