<script setup>
import {useVModel} from "@vueuse/core";
import {cn} from "@/lib/utils";
import {Eye, EyeOff} from 'lucide-vue-next';
import { Input } from '@/Components/ui/input';
import {ref} from "vue";

const props = defineProps({
    defaultValue: {type: [String, Number], required: false},
    modelValue: {type: [String, Number], required: false},
    class: {type: null, required: false},
});

const visible = ref(false)

const emits = defineEmits(["update:modelValue"]);

const modelValue = useVModel(props, "modelValue", emits, {
    passive: true,
    defaultValue: props.defaultValue,
});
</script>

<template>

    <div class="relative" >
        <Input
            dir="ltr"
            v-model="modelValue"
            class="pr-10 "
            :type="visible ? 'text' : 'password' "
        />
        <Button
            type="button"
            variant="ghost"
            size="icon"
            class="absolute right-0 top-0 h-full px-3 py-2 "
            @click.prevent="visible = !visible"
        >

            <Eye v-if="visible" :stroke-width="0.75" />
            <EyeOff v-else :stroke-width="0.75" />
        </Button>
    </div>
</template>
