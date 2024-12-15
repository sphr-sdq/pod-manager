<script>
import Index from './Index.vue'

export default {
    layout: Index
}
</script>

<script setup>
import {Separator} from '@/components/ui/separator'
import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription
} from '@/components/ui/card'
import {Button} from '@/components/ui/button'
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog'
import {Input} from '@/components/ui/input'
import {Github} from 'lucide-vue-next';
import {Label} from '@/components/ui/label'
import {ref, reactive} from 'vue'
import {router} from '@inertiajs/vue3'
import axios from "axios";

var modal = ref(false)

var data = reactive({})

var props = defineProps({
    pods: Array,
    slug: String,
    projects: Array
})
var last_selected_pod = {}

function randomLowercaseString(length = 32) {
    const pool = 'abcdefghijklmnopqrstuvwxyz';
    return Array.from({length}, () => pool[Math.floor(Math.random() * pool.length)]).join('');
}

var project_form = (pod) => {

    axios.post('/dashboard/get_projects', pod).then(res => {
        data = JSON.parse(res.data.parameters)

        data.user_parameters.forEach(param => {
            var val = ''
            if (param.default) {
                if (param.default.toString().startsWith('_')) {

                    const match = param.default.toString().match(/^_random_string(?:\((\d+)?\))?$/);
                    console.log(match)
                    if (match) {
                        const length = match[1] ? parseInt(match[1], 10) : 32;
                        val = randomLowercaseString(length);

                    }

                } else {
                    val = param.default
                }
            }
            param.value = val;
        })
        last_selected_pod = pod
        modal.value = !modal.value;
    })

}

function submit() {
    let res = {}
    res.user_namespace = props.slug;
    res.app_id = last_selected_pod.slug;
    res.user_params = data.user_parameters.reduce((acc, param) => {
        if (param.name && param.value !== undefined) {
            acc[param.name] = param.value.toString();
        }
        return acc;
    }, {});

    router.post(`/dashboard/project/${props.slug}`, res, {
        onSuccess: () => {
            modal.value = !modal.value;
        }
    });
}


</script>

<template>
        <Card>
            <CardHeader>
                <button disabled>
                    <CardTitle class="flex items-center gap-2">
                        <Github size="30px"/>
                        <span>
                  Github
                   </span>

                    </CardTitle>
                    <CardDescription class="text-right">
                        پروژه‌ ی خود را از گیت‌هاب انتخاب کنید
                    </CardDescription>
                </button>
            </CardHeader>
        </Card>
        <Separator label="و یا از پروژه‌های زیر انتخاب کنید"/>
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
                  {{ pod.name }}
                </span>

                        </CardTitle>
                    </button>
                </CardHeader>
            </Card>
        </div>


    <Dialog v-model:open="modal">
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle class="text-right">ایجاد پروژه {{ data.name }}</DialogTitle>
                <DialogDescription class="text-right">
                    در صورتی که از مقادیر اطلاع ندارید آن را به همین شکل رها کنید
                </DialogDescription>
            </DialogHeader>
            <div class="grid gap-4 py-4">
                <div class="grid grid-cols-4 items-center gap-4" v-for="(field , i) in data.user_parameters" :key="i">
                    <Label :for="field.name" class="text-right">
                        {{ field.title }}
                    </Label>
                    <Input :id="field.name" :type="field.type" class="col-span-3" v-model="field.value"
                           :disabled="field.disable"/>
                </div>
            </div>
            <DialogFooter>
                <Button type="submit" @click.prevent="() => submit()">
                    ایجاد پروژه
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<style scoped>

</style>
