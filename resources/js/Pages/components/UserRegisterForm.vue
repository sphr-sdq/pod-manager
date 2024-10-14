<script setup lang="js">
import {
    PinInput,
    PinInputGroup,
    PinInputInput,
    PinInputSeparator,
} from '@/components/ui/pin-input'
import { Button } from '@/components/ui/button'
import { Stepper, StepperDescription, StepperItem, StepperSeparator, StepperTitle, StepperTrigger } from '@/components/ui/stepper'
import { Check, Circle, Dot } from 'lucide-vue-next'
import { ref } from 'vue'


const steps = [
    {
        step: 1,
    },
    {
        step: 2,
    },
    {
        step: 3,
    },
]
const value = ref([])
const stepIndex = ref(1)
</script>

<template>

        <Stepper class="flex w-full items-start"
            v-model="stepIndex"
        >
        <StepperItem
            v-for="step in steps"
            :key="step.step"
            v-slot="{ state }"
            class="relative max-w-1/3  flex w-full flex-col items-center justify-center"
            :step="step.step"

        >
            <StepperSeparator
                v-if="step.step !== steps[steps.length - 1].step"
                class="absolute right-[calc(50%+20px)] left-[calc(-50%+10px)] mt-2 top-5 block h-0.5 shrink-0 rounded-full bg-muted group-data-[state=completed]:bg-primary"
            />

            <StepperTrigger as-child >
                <Button
                    :variant="state === 'completed' || state === 'active' ? 'default' : 'outline'"
                    size="icon"
                    class="z-10 rounded-full shrink-0 mt-2"
                    :class="[state === 'active' && 'ring-2 ring-ring ring-offset-2 ring-offset-background']"
                >
                    <Check v-if="state === 'completed'" class="size-5" />
                    <Circle v-if="state === 'active'" />
                    <Dot v-if="state === 'inactive'" />
                </Button>
            </StepperTrigger>

            <div class="mt-5 flex flex-col items-center text-center">
                <StepperTitle
                    :class="[state === 'active' && 'text-primary']"
                    class="text-sm font-semibold transition lg:text-base"
                >
                    {{ step.title }}
                </StepperTitle>
                <StepperDescription
                    :class="[state === 'active' && 'text-primary']"
                    class="sr-only text-xs text-muted-foreground transition md:not-sr-only lg:text-sm"
                >
                    {{ step.description }}
                </StepperDescription>
            </div>


        </StepperItem>
        </Stepper>

    <div v-if="stepIndex === 2" >
        <p class="mb-2 font-semibold transition">
            شماره همراه خود را وارد کنید
        </p>
        <p class="mb-8  text-xs text-muted-foreground transition  lg:text-sm">
            ابتدا شماره موبایل خود را وارد کنید و روی گزینه بعدی را نتخاب کنید تا به مرحله‌ی بعد بروید
        </p>

        <PinInput
            id="pin-input"
            v-model="value"
            placeholder="○">
            <PinInputGroup class="gap-1 justify-between">
                <template v-for="(id, index) in 5" :key="id">
                    <PinInputInput
                        class="rounded-md border"
                        :index="index"
                    />
                    <template v-if="index !== 4">
                        <PinInputSeparator />
                    </template>
                </template>
            </PinInputGroup>
        </PinInput>
    </div>
    <p>{{stepIndex}}</p>
</template>
