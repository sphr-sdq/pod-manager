<script>
import Index from './Index.vue'
export default {
    layout: Index
}
</script>

<script setup >
import { Button } from '@/components/ui/button'
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog'
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
defineProps({
    projects : Array
})


const new_project = reactive({
    name : null
})
function submit() {
    router.post('/dashboard/projects', new_project)
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

                    <Button type="button" size="sm" class="px-3" @click="submit">
                        ثبت
                    </Button>
                <DialogClose as-child>
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
            <CardDescription>{{new Date(project.updated_at).toLocaleString('en-US', {
                year: 'numeric',
                month: 'long', // e.g., "November"
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            }) }}</CardDescription>
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
