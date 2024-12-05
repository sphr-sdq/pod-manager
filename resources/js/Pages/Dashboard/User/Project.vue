<script>
import Index from './Index.vue'
export default {
    layout: Index
}
</script>

<script setup>
import { Separator } from '@/components/ui/separator'
import {
    Card,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import {ref , reactive} from 'vue'
import { router } from '@inertiajs/vue3'
import axios from "axios";
var modal = ref(false )

var data = reactive({} )

var project_form = ( pod) =>{

    axios.post('/dashboard/get_projects' , pod).then(res => {
        data = JSON.parse(res.data.parameters)

        data.user_parameters.forEach(param => {
            param.value = param.default || '';
        })
        modal.value = ! modal.value;
    })

}

defineProps({
    pods: Array
})
</script>

<template>
    <Separator label="انتخاب پروژه" />
    <div class="grid grid-cols-2 gap-2">

    <Card v-for="(pod,index) in pods" :key="index">
        <CardHeader>
            <button @click.prevent="() => project_form(pod)">
            <CardTitle class="flex items-center gap-2">
                <img :src="'/storage/' + pod.image_path" :alt="pod.name"
                    width="50px"
                     height="50px"
                />
                <span>
                  {{pod.name}}
                </span>

            </CardTitle>
            </button>
        </CardHeader>
    </Card>
    </div>

    <Dialog v-model:open="modal" >
        <DialogContent class="sm:max-w-[425px]" >
            <DialogHeader>
                <DialogTitle class="text-right">ایجاد پروژه {{data.name}}</DialogTitle>
                <DialogDescription class="text-right">
                    در صورتی که از مقادیر اطلاع ندارید آن را به همین شکل رها کنید
                </DialogDescription>
            </DialogHeader>
            <div class="grid gap-4 py-4">
                <div class="grid grid-cols-4 items-center gap-4" v-for="(field , i) in data.user_parameters" :key="i">
                    <Label :for="field.name" class="text-right">
                        {{field.title}}
                    </Label>
                    <Input :id="field.name"  class="col-span-3" v-model="field.value"  />
                </div>
            </div>
            <DialogFooter>
                <Button type="submit">
                    ایجاد پروژه
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<style scoped>

</style>
