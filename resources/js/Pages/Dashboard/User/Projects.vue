<script>
import Index from './Index.vue'
export default {
    layout: Index
}
</script>

<script setup >
import { Button } from '@/Components/ui/button'
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/Components/ui/dialog'
import {
    Card,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/Components/ui/card'
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
import { Trash2 } from 'lucide-vue-next';
import { Input } from '@/Components/ui/input'
import { Label } from '@/Components/ui/label'
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
var props =  defineProps({
    projects : Array,
})


const new_project = reactive({
    name : null
})

function submit() {
    router.post('/dashboard/projects', new_project , {
        onSuccess : () => {new_project.name = null}
    })
}

function destroy(id) {
    router.delete(`/dashboard/projects/${id}`)
}

</script>

<template>
    <Dialog>
        <DialogTrigger as-child>
            <Button variant="outline">
                پروژه جدید
            </Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-md"  >
            <DialogHeader >
                <DialogTitle class="text-right" >ثبت پروژه جدید</DialogTitle>
                <DialogDescription class="text-right" >
                    برای محیط پروژه یک نام انتخاب کنید.
                </DialogDescription>
            </DialogHeader>
            <div class="flex items-center space-x-2">
                <div class="grid flex-1 gap-2">
                    <Label for="name" class="sr-only">
                        Link
                    </Label>
                    <Input
                        v-model="new_project.name"
                        id="name"
                    />
                </div>

            </div>
            <DialogFooter class="sm:justify-start">
                <DialogClose class="flex gap-2">
                    <Button type="button" size="sm" class="px-3" @click="submit">
                        ثبت
                    </Button>

                    <Button type="button" variant="secondary">
                        انصراف
                    </Button>
                </DialogClose>
            </DialogFooter>
        </DialogContent>
    </Dialog>

    <Card v-if="projects.length > 0" v-for="project in projects">
        <CardHeader>
            <CardTitle>{{project.name}}</CardTitle>
            <CardDescription class="flex justify-between items-center">
                <div>


                {{new Date(project.updated_at).toLocaleString('en-US', {
                year: 'numeric',
                month: 'long', // e.g., "November"
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'}) }}
                </div>
                <div>


                    <AlertDialog >
                        <AlertDialogTrigger>
                            <Button variant="outline" size="icon">
                                <Trash2 class="w-4 h-4" />
                            </Button>
                        </AlertDialogTrigger>
                        <AlertDialogContent >
                            <AlertDialogHeader>
                                <AlertDialogTitle class="text-right">از حذف پروژه {{project.name}} اطمینان دارید ؟</AlertDialogTitle>
                                <AlertDialogDescription class="text-right">
                                    این عمل همیشگی و غیرقابل بازگشت است. با حذف پروژه تمام منابع مربوط به آن نیز برای همیشه حذف می‌گردد.
                                </AlertDialogDescription>
                            </AlertDialogHeader>
                            <AlertDialogFooter>
                                <AlertDialogCancel >انصراف</AlertDialogCancel>
                                <AlertDialogAction @click.prevent="() => destroy(project.id)">حذف</AlertDialogAction>
                            </AlertDialogFooter>
                        </AlertDialogContent>
                    </AlertDialog>
                </div>
            </CardDescription>
        </CardHeader>

        <CardFooter>
            <Link :href="`/dashboard/project/${project.slug}`">
                <Button variant="outline">
                    ورود به پروژه
                </Button>
            </Link>

        </CardFooter>
    </Card>
</template>



<style scoped>

</style>
