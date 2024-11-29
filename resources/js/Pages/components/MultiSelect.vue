<script setup>
import {ref, computed, watch} from 'vue';
import {Button} from '@/components/ui/button';
import {Badge} from '@/components/ui/badge';
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/components/ui/popover';
import {
    Command,
    CommandEmpty,
    CommandGroup,
    CommandInput,
    CommandItem,
    CommandList,
} from '@/components/ui/command';
import {ChevronDown, XIcon, CheckIcon} from 'lucide-vue-next';

const props = defineProps({
    options: {
        type: Array,
        required: true,
    },
    placeholder: {
        type: String,
        default: 'Select options',
    },
    maxCount: {
        type: Number,
        default: 3,
    },
    modelValue: {
        type: Array,
        default: () => [], // Default to an empty array
    },
});

const emit = defineEmits(['update:modelValue']);

const placeholder = props.placeholder;
const maxCount = props.maxCount;
const selectedValues = ref([...props.modelValue || []]);
const isPopoverOpen = ref(false);
const search = ref('');

watch(
    () => props.modelValue,
    (newModelValue) => {
        selectedValues.value = [...newModelValue]; // Sync with prop changes
    }
);


watch(selectedValues, (newValues) => {
    if (JSON.stringify(newValues) !== JSON.stringify(props.modelValue)) {
        emit('update:modelValue', newValues);
    }
});
const togglePopover = () => {
    isPopoverOpen.value = !isPopoverOpen.value;
};

const toggleOption = (value) => {
    if (selectedValues.value.includes(value)) {
        selectedValues.value = selectedValues.value.filter((val) => val !== value);
    } else {
        selectedValues.value.push(value);
    }
};
const removeOption = (value) => {
    selectedValues.value = selectedValues.value.filter((val) => val !== value);
};

const getOptionLabel = (value) => {
    const option = props.options.find((opt) => opt.value === value);
    return option ? option.label : '';
};

const filteredOptions = computed(() => {
    return props.options; // Keep all options in the list
});

const visibleSelectedValues = computed(() => {
    return selectedValues.value.slice(0, maxCount);
});

const remainingCount = computed(() => {
    return selectedValues.value.length - maxCount;
});
</script>

<template>
    <div class="relative">
        <Popover v-model="isPopoverOpen">
            <PopoverTrigger as="div" class="flex w-full">
                <Button
                    class="flex w-full p-2 rounded-lg border items-center justify-between bg-inherit hover:bg-inherit"
                    @click.prevent="togglePopover"
                    variant="multiSelect"
                >
                    <div
                        v-if="selectedValues.length > 0"
                        class="flex items-center flex-wrap gap-2"
                    >
                        <Badge
                            v-for="(value, index) in visibleSelectedValues"
                            :key="index"
                            @click.prevent.stop="removeOption(value)"
                            class="bg-primary py-[0.3rem]  text-white"
                        >
                            {{ getOptionLabel(value) }}
                            <XIcon class="ml-1 mr-1.5 h-4 w-4 cursor-pointer"/>
                        </Badge>
                        <span
                            v-if="remainingCount > 0"
                            class="text-sm text-muted-foreground"
                        >
              +{{ remainingCount }} بیشتر
            </span>
                    </div>
                    <div v-else class="text-muted-foreground">
                        {{ placeholder }}
                    </div>
                    <ChevronDown class="h-4 ml-2 text-muted-foreground opacity-50"/>
                </Button>
            </PopoverTrigger>
            <PopoverContent>
                <Command>
                    <CommandInput v-model="search" placeholder="Search..."/>
                    <CommandList>
                        <CommandEmpty>No results found.</CommandEmpty>
                        <CommandGroup>
                            <CommandItem
                                v-for="option in filteredOptions"
                                :key="option.value"
                                :value="option.value"
                                @click="toggleOption(option.value)"
                            >
                                <div class="mr-2 flex items-center">
                                    <CheckIcon
                                        v-if="selectedValues.includes(option.value)"
                                        class="h-4 w-4"
                                    />
                                </div>
                                {{ option.label }}
                            </CommandItem>
                        </CommandGroup>
                    </CommandList>
                </Command>
            </PopoverContent>
        </Popover>
    </div>
</template>
