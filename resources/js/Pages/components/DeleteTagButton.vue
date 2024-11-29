<template>
    <Button
        variant="outline"
        size="sm"
        class="h-7 border-dashed hover:border-red-500 hover:bg-red-50 hover:text-red-600 transition-colors"
    >
            <span class="ml-1" @click="openEditDialog">{{ content.name }}</span>

        <X class="h-4 w-4" @click="open = true" />
        <span class="sr-only">Delete {{ content.name }}</span>
    </Button>

    <AlertDialog v-model:open="open" >
        <AlertDialogContent >
            <AlertDialogHeader >
                <AlertDialogTitle class="flex self-start" >از حذف تگ اطمینان دارید؟</AlertDialogTitle>
                <AlertDialogDescription  class="flex self-start">
                    آیا از حذف تگ {{content.name}} اطمینان دارید؟
                </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel :disabled="isLoading" >انصراف</AlertDialogCancel>
                <AlertDialogAction :disabled="isLoading" @click="deleteHandler" >حذف</AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>

    <Dialog v-model:open="openEdit" >
        <DialogContent class="sm:max-w-md [&>button]:left-4 [&>button]:right-auto" >
            <DialogHeader >
                <DialogTitle class="flex self-start">تغییر عنوان تگ</DialogTitle>
                <DialogDescription class="flex self-start">
                    از طریق این فرم می‌توانید عنوان تگ را تغببر دهید.
                </DialogDescription>
            </DialogHeader>
            <div class="flex items-center space-x-2 gap-2">
                <div class="grid flex-1 gap-2">
                    <Label for="link" class="sr-only">
                        Link
                    </Label>
                    <Input
                        :disabled="isLoading_newValue"
                        id="link"
                        :default-value="content.name"
                        v-model="newValue"
                        dir="ltr"
                    />

                </div>
                <Button :disabled="isLoading_newValue" type="submit" size="sm" class="px-3" @click="handleUpdate">
                    <span>ثبت</span>
                </Button>
            </div>
            <span v-if="newValueError.newValue" class="text-sm text-red-600 font-bold">{{newValueError.newValue}}</span>
            <DialogFooter class="sm:justify-start">
                <DialogClose as-child>
                    <Button type="button" variant="secondary" >
                        انصراف
                    </Button>
                </DialogClose>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>

<script setup>
import {Button} from '@/Components/ui/button'
import  {X} from 'lucide-vue-next'
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
} from '@/components/ui/alert-dialog'
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
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import {useToast} from '@/composables/useToast.js'


const emitToast = useToast()
const props = defineProps({
    content : Object
})

const open = ref(false);
const isLoading = ref(false);
const openEdit = ref(false);
const isLoading_newValue = ref(false);

const newValue = ref(props.content.name ?? '');
const newValueError = ref({});

const deleteHandler = () => {
    router.delete('/dashboard/tag/' + props.content.id.toString() ,  {
        onStart  : () => {isLoading.value = true},
        onFinish : () => {isLoading.value = false; open.value = false},
        onSuccess : () => {
            open.value = false;
            emitToast({message: "تگ با موفقیت حذف شد"})
        }
    });
}

const handleUpdate = () => {
    router.patch('/dashboard/tag/' + props.content.id.toString() , { newValue : newValue.value} ,{
        onStart  : () => {isLoading_newValue.value = true},

        onSuccess : () => {
            openEdit.value = false;
            emitToast({message: "تگ با موفقیت اپدیت شد"})
            isLoading_newValue.value = false
        },
        onError : (err) => {
                isLoading_newValue.value = false;
                newValueError.value = err
            isLoading_newValue.value = false
        }
    });
}

const openEditDialog = () =>{
    newValueError.value = {};
    newValue.value  = props.content.name ?? '';
    openEdit.value= true;
}

</script>

