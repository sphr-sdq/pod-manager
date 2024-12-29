<script>
import Index from './Index.vue'

export default {
    layout: Index
}
</script>

<script setup>
import {Separator} from '@/Components/ui/separator'
import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent
} from '@/Components/ui/card'
import {Button} from '@/Components/ui/button'
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/Components/ui/dialog'
import {Input} from '@/Components/ui/input'
import {Github} from 'lucide-vue-next';
import {Label} from '@/Components/ui/label'
import {ref, reactive, onMounted} from 'vue'
import {router} from '@inertiajs/vue3'
import axios from "axios";
import {parseJSON} from "confbox";
import {Pencil} from 'lucide-vue-next';
import {Settings} from 'lucide-vue-next';
import {CircleX} from 'lucide-vue-next';
import { LoaderCircle } from 'lucide-vue-next';

import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/Components/ui/alert-dialog'

import Projects from "@/Pages/Dashboard/User/Projects.vue";
import {object} from "zod";


var modal = ref(false)
var domain_modal = ref(false)
var update_modal = ref(false)
var domain_val = ref(null)
var certificates = ref([]);
var groupedCertificates = ref([]);

var data = reactive({})

var data2 = reactive({})

var props = defineProps({
    pods: Array,
    slug: String,
    projects: Array,
    ingress: Array
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
            data2 = res.user_params;
            modal.value = !modal.value;
            fetchCertificateStatus();
        },
        onError: () => {

        }
    });
}

function deleteDomain() {
    router.delete(`/dashboard/project/${props.slug}/delete_domain/${props.ingress[props.ingress.length - 1].id}`)
}

function submit_domain() {
    router.post(`/dashboard/project/${props.slug}/store_domain`, {
        "app_id": JSON.parse(props.projects.parameters).app_id,
        "user_params": {
            "app_name": JSON.parse(props.projects.parameters).user_params.app_name,
            "tls_secret_name": "ingress-secret",
            "domain": domain_val.value
        },
        "user_namespace": JSON.parse(props.projects.parameters).user_namespace,
        "id": props.projects.id

    }, {
        onSuccess: () => {
            domain_modal.value = !domain_modal.value;
            domain_val.value = "";
            fetchCertificateStatus();
        },
        onError: (msg) => {

        }
    })
}

onMounted(() => {
    fetchCertificateStatus();

    data2 = data2 = props.projects && props.projects.parameters
        ? JSON.parse(props.projects.parameters).user_params
        : {};
})

async function fetchCertificateStatus() {
    try {
        const namespace = JSON.parse(props.projects.parameters).user_namespace;
        const response = await axios.get(
            `/dashboard/project/${namespace}/certificate`
        );
        certificates.value = response.data;

        const grouped = {};
        certificates.value.forEach(cert => {
            const dnsName = cert.dnsNames[0];
            if (!grouped[dnsName]) {
                grouped[dnsName] = {dnsName, status: false};
            }
            if (cert.status === "True") {
                grouped[dnsName].status = true;
            }
        });

        groupedCertificates.value = Object.values(grouped).map(cert => ({
            dnsNames: cert.dnsName,
            status: cert.status ? "True" : "False",
        }));

        const allReady = groupedCertificates.value.every(cert => cert.status === "True");
        if (!allReady ) {
            setTimeout(fetchCertificateStatus, 5000);
        } else {
            // this.loading = false;
        }
    } catch (err) {
        // this.error = err.message || "Failed to fetch certificate status.";
        // this.loading = false;
    }
}

function apply() {
    router.patch(`/dashboard/project/${props.slug}`, {
        "app_id": JSON.parse(props.projects.parameters).app_id,
        "user_params": Object.fromEntries(
            Object.entries(data2).map(([key, value]) => [key, String(value)])
        ),
        "user_namespace": JSON.parse(props.projects.parameters).user_namespace,
        "project_id": props.projects.id
    }, {
        onSuccess: () => {
            update_modal.value = !update_modal.value
        }
    })
}

</script>

<template>

    <template v-if="projects.length === 0">
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
            <DialogContent class="sm:max-w-[525px] grid-rows-[auto_minmax(0,1fr)_auto] max-h-[90dvh]">
                <DialogHeader>
                    <DialogTitle class="text-right">ایجاد پروژه {{ data.name }}</DialogTitle>
                    <DialogDescription class="text-right">
                        در صورتی که از مقادیر اطلاع ندارید آن را به همین شکل رها کنید
                    </DialogDescription>
                </DialogHeader>
                <div class="grid gap-4 py-4 overflow-y-auto px-6">
                    <div class="grid grid-cols-6 items-center gap-4" v-for="(field , i) in data.user_parameters"
                         :key="i">
                        <Label :for="field.name" class="text-right col-span-2">
                            {{ field.title }}
                        </Label>
                        <Input :id="field.name" :type="field.type" class="col-span-4" v-model="field.value"
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
    <template v-else>
        <Card>
            <CardHeader>

                <CardTitle class="flex items-center gap-2">
                    <img :src="'/storage/' + projects.pod.image_path" :alt="projects.pod.name"
                         width="50px"
                         height="50px"
                    />
                    <span>
                        <span class="flex items-center gap-2">
                              {{ projects.pod.name }}


                                    <Dialog v-model:open="update_modal">
         <DialogTrigger as-child>

         <Settings class="hover:cursor-pointer"/>

    </DialogTrigger>
            <DialogContent class="sm:max-w-[525px] grid-rows-[auto_minmax(0,1fr)_auto] max-h-[90dvh]">
                <DialogHeader>
                    <DialogTitle class="text-right">ویرایش پروژه </DialogTitle>
                    <DialogDescription class="text-right">
                        می‌توانید با تغییر مقادیر زیر منابع پروژه‌ی را تغییر دهید
                    </DialogDescription>
                </DialogHeader>
                <div class="grid gap-4 py-4 overflow-y-auto px-6">
                    <div class="grid grid-cols-6 items-center gap-4"
                         v-for="(field , i) in JSON.parse(projects.pod.parameters).user_parameters"
                         :key="i">
                       <Label :for="field.name" class="text-right col-span-2">

                            {{ field.title }}

                        </Label>
                        <Input :id="field.name" :type="field.type" class="col-span-4"
                               v-model="data2[field.name]"
                               :disabled="field.disable"
                        />
                    </div>
                </div>
                <DialogFooter>
                    <Button type="submit" @click.prevent="() => apply()">
                        ثبت تغییرات
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
                        </span>

                </span>

                </CardTitle>
                <CardDescription class="text-right flex items-center gap-2">
                    <a target="_blank"
                       :class="[
                                  'underline',
                                  'disabled',
                                  groupedCertificates.length > 0 && groupedCertificates.some(c =>
                                 c.dnsNames && c.dnsNames.includes(projects.namespace.slug +'.' +parseJSON(projects.parameters).user_params.app_name + '.podplex.ir') && c.status === 'True')  ? ' ' : 'cursor-wait',
                                ]"
                       :href="'https://' + projects.namespace.slug +'.' +parseJSON(projects.parameters).user_params.app_name + '.podplex.ir'"
                    >
                            <span v-if="(groupedCertificates.length > 0 && groupedCertificates.some(c =>
                                c.dnsNames && c.dnsNames.includes(projects.namespace.slug +'.' +parseJSON(projects.parameters).user_params.app_name + '.podplex.ir') && c.status === 'True'))">
                                https://
                            </span>
                        <span v-else>
                                http://
                            </span>
                        {{ projects.namespace.slug +'.' +parseJSON(projects.parameters).user_params.app_name + '.podplex.ir'}}

                    </a>
                    <span v-if="!(groupedCertificates.length > 0 && groupedCertificates.some(c =>
        c.dnsNames && c.dnsNames.includes(projects.namespace.slug +'.' +parseJSON(projects.parameters).user_params.app_name + '.podplex.ir') && c.status === 'True'))"> <LoaderCircle size="12" class="animate-spin" />
                    </span>

                    <Dialog v-model:open="domain_modal">
                        <DialogTrigger as-child>

                            <Pencil size="16" class="hover:cursor-pointer"/>

                        </DialogTrigger>
                        <DialogContent class="sm:max-w-md">
                            <DialogHeader>
                                <DialogTitle class="text-right">دامنه‌ی جدید</DialogTitle>
                                <DialogDescription class=" text-justify leading-8">
                                    برای ایجاد دامنه‌ی شخصی خود ابتدا وارد سایت ارائه دهنده‌ی دامنه‌ی خود شوید و از بخش
                                    <span class="bg-black/10 px-2 rounded-xl font-bold">مدیریت DNS</span>

                                    یک رکورد
                                    <span class="bg-black/10 px-2 rounded-xl font-bold">CNAME</span>
                                    ایجاد کرده و آن را به آدرس
                                    <span
                                        class="bg-black/10 px-2 rounded-xl font-bold">{{
                                            "www." + projects.namespace.slug + "." + parseJSON(projects.parameters).user_params.app_name + ".podplex.ir"
                                        }}</span>
                                    اشاره دهید. سپس دامنه‌ی مد نظر خود را وارد کرده و گزینه‌ی ثبت را انتخاب کنید.
                                </DialogDescription>
                            </DialogHeader>
                            <div class="flex items-center space-x-2">
                                <div class="grid flex-1 gap-2">
                                    <Label for="link" class="sr-only">
                                        Link
                                    </Label>
                                    <Input
                                        dir="ltr"
                                        id="link"
                                        placeholder="awesome.com"
                                        v-model="domain_val"
                                    />
                                </div>
                            </div>
                            <DialogFooter class="sm:justify-start">
                                <DialogClose as-child>
                                    <Button type="button" variant="secondary" @click.prevent="submit_domain">
                                        ثبت
                                    </Button>
                                </DialogClose>
                            </DialogFooter>
                        </DialogContent>
                    </Dialog>
                    <div v-if="ingress.length > 0" class="flex items-center gap-1">
                        (


                        <a target="_blank"
                           :class="[
                                  'underline',
                                  'disabled',
                                  groupedCertificates.length > 0 && groupedCertificates.some(c =>
                                 c.dnsNames && c.dnsNames.includes(JSON.parse(ingress[ingress.length - 1]?.resource)?.user_params?.domain) && c.status === 'True')  ? ' ' : 'cursor-wait',
                                ]"
                           :href="'https://' + JSON.parse(ingress[ingress.length - 1].resource).user_params.domain"
                        >
                            <span v-if="(groupedCertificates.length > 0 && groupedCertificates.some(c =>
                                c.dnsNames && c.dnsNames.includes(JSON.parse(ingress[ingress.length - 1]?.resource)?.user_params?.domain) && c.status === 'True'))">
                                https://
                            </span>
                            <span v-else>
                                http://
                            </span>
                            {{ JSON.parse(ingress[ingress.length - 1].resource).user_params.domain }}

                        </a>
                        <span v-if="!(groupedCertificates.length > 0 && groupedCertificates.some(c =>
        c.dnsNames && c.dnsNames.includes(JSON.parse(ingress[ingress.length - 1]?.resource)?.user_params?.domain) && c.status === 'True'))"> <LoaderCircle size="12" class="animate-spin" /> </span>
                        <span>
                              <AlertDialog>
                                <AlertDialogTrigger as-child>
                                 <CircleX size="12" class="hover:text-red-800 hover:cursor-pointer"/>
                                </AlertDialogTrigger>
                                <AlertDialogContent>
                                  <AlertDialogHeader>
                                    <AlertDialogTitle
                                        class="text-right">آیا از حذف دامنه اطمینان دارید ؟</AlertDialogTitle>
                                    <AlertDialogDescription class="text-right">
                                        آیا از حذف دامنه
                                        <span class="font-bold text-sm bg-black/10 px-1 rounded-xl">{{
                                                "https://" + JSON.parse(ingress[ingress.length - 1].resource).user_params.domain
                                            }}
                                        </span>
                                        اطمینان دارید؟
                                    </AlertDialogDescription>
                                  </AlertDialogHeader>
                                  <AlertDialogFooter>
                                    <AlertDialogCancel>انصراف</AlertDialogCancel>
                                    <AlertDialogAction @click="deleteDomain">تایید</AlertDialogAction>
                                  </AlertDialogFooter>
                                </AlertDialogContent>
                              </AlertDialog>
                        </span>
                        )
                    </div>

                </CardDescription>
            </CardHeader>
            <CardContent class="">

                  <span
                      v-for="(value, key, index) in JSON.parse(projects.parameters).user_params"
                      :key="index"
                      class="text-xs border border-dashed mx-1 px-1 whitespace-nowrap overflow-hidden text-ellipsis max-w-full inline-block hover:bg-black/10"
                  >
    {{ key + " : " + value }}
  </span>

            </CardContent>

        </Card>

    </template>
</template>

<style scoped>

</style>
