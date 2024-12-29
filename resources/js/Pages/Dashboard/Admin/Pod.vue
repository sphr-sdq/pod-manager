<script>
import Index from './Index.vue'

export default {
    layout: Index
}
</script>

<script setup >
import { Input } from '@/Components/ui/input'
import { Label } from '@/Components/ui/label'
import { Textarea } from '@/Components/ui/textarea'
import { Button } from '@/Components/ui/button'
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import MultiSelect from '@/Pages/components/MultiSelect.vue'
import { ref , watch } from 'vue'
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    title: null,
    image: null,
    description: null,
    template : null,
    parameters : null
})

var props =  defineProps({
    tags : Array
})

const options = ref(props.tags.map(t => ({
    value: t["slug"],
    label: t["name"]
})));
const selectedValues = ref([]);


function submit() {
    console.log(selectedValues.value)
    form.transform((data) => ({
        ...data,
        tags : selectedValues.value
    })).post('/dashboard/pod', {
        forceFormData: true,
    })
}
</script>

<template>


    <form class="flex flex-col gap-5"  @submit.prevent="submit" enctype="multipart/form-data">


    <div class="flex gap-4">


    <div class="grid w-full max-w-sm items-center gap-1.5">
        <Label for="title">عنوان</Label>
        <Input id="title"  placeholder="عنوان"  v-model="form.title" />
    </div>

    <div class="grid w-full max-w-sm items-center gap-1.5">
        <Label for="picture">تصویر</Label>
        <Input id="picture" type="file" @input="form.image = $event.target.files[0]"  />
    </div>
    </div>
    <div class="grid w-full gap-1.5">
        <Label for="description">توضیحات</Label>
        <Textarea id="description" placeholder="توضیحات را وارد کنید" v-model="form.description" />
<!--        <p class="text-sm text-muted-foreground">-->
<!--            Your message will be copied to the support team.-->
<!--        </p>-->
    </div>
    <div class="grid w-full gap-1.5">
        <Label for="template">قالب برنامه به فرمت yml</Label>
        <Textarea id="template" placeholder="قالب برنامه را وارد کنید" dir="ltr" v-model="form.template" />
        <!--        <p class="text-sm text-muted-foreground">-->
        <!--            Your message will be copied to the support team.-->
        <!--        </p>-->
    </div>
    <div class="grid w-full gap-1.5">
        <Label for="parameters">پارامتر‌ها‌ی مورد نیاز را وارد کنید فرمت json</Label>
        <Textarea id="parameters" placeholder="پارامتر‌ها مورد نیاز" dir="ltr" v-model="form.parameters" />
        <!--        <p class="text-sm text-muted-foreground">-->
        <!--            Your message will be copied to the support team.-->
        <!--        </p>-->
    </div>
        <MultiSelect
            :options="options"
            placeholder="تگ"
            v-model="selectedValues"
            :maxCount="2"
        />
    <Button variant="outline" type="submit">
        ثبت پروژه
    </Button>
    </form>
</template>

<style scoped>

</style>
