<script setup lang="js">
import {
    PinInput,
    PinInputGroup,
    PinInputInput,
    PinInputSeparator,
} from '@/components/ui/pin-input'
import {Button} from '@/components/ui/button'
import {
    Stepper,
    StepperDescription,
    StepperItem,
    StepperSeparator,
    StepperTitle,
    StepperTrigger
} from '@/components/ui/stepper'
import {Check, Circle, Dot, Phone, LockKeyhole, MessageSquare} from 'lucide-vue-next'
import {onMounted, reactive, ref} from 'vue'
import {Label} from "@/Components/ui/label/index.js";
import {Input} from "@/Components/ui/input/index.js";
import {Separator} from '@/components/ui/separator'
import {Link} from "@inertiajs/vue3";
import Drawer from "../components/DemoDrawer.vue"


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
const phoneNumber = ref(null)
const stepIndex = ref(1)
const stepperFunctions = reactive({
    prev : null,
    next : null,
    is_prev_disabled : null,
    is_next_disabled : null
})

const setStepperFunction = (prev , next , is_prev_disabled , is_next_disabled) =>{
    stepperFunctions.value = {
        prev , next ,  is_prev_disabled , is_next_disabled
    }
}
const handlePrev = () => {
   stepperFunctions.value.prev()
};

const handleNext = () => {
    stepperFunctions.value.next()
}
</script>

<template>

    <div class="flex flex-col h-full ">

        <!--header-->
        <div class=" basis-4/12">
            <div class="flex flex-row items-baseline gap-2 mb-2">
                <div class="w-3 h-3 border-2 border-black p-0.5">
                    <div class="w-full h-full bg-black"></div>
                </div>
                <h1 class="text-3xl font-bold">ثبت نام</h1>
            </div>

            <h3 class="text-sm text-muted-foreground">
                برای اینجاد حساب کاریری مراحل زیر را طی نمیایید.
            </h3>

            <Stepper class="flex mt-6 w-full items-start"
                     v-model="stepIndex"
                     v-slot="{ isNextDisabled, isPrevDisabled, nextStep, prevStep }"
            >
                {{setStepperFunction(prevStep , nextStep , isPrevDisabled ,isNextDisabled)}}
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

                    <StepperTrigger as-child>
                        <Button

                            :variant="state === 'completed' || state === 'active' ? 'default' : 'outline'"
                            size="icon"
                            class="z-10 rounded-full shrink-0 mt-2"
                            :class="[state === 'active' && 'ring-2 ring-ring ring-offset-2 ring-offset-background']"
                        >
                            <Check v-if="state === 'completed'" class="size-5"/>
                            <!--                            <Circle v-if="state === 'active'"/>-->

                            <Phone v-if="state === 'active' && step.step === 1"/>
                            <MessageSquare v-if="state === 'active' && step.step === 2"/>
                            <LockKeyhole v-if="state === 'active' && step.step === 3"/>

                            <Phone v-if="state === 'inactive' && step.step === 1"/>
                            <MessageSquare v-if="state === 'inactive' && step.step === 2"/>
                            <LockKeyhole v-if="state === 'inactive' && step.step === 3"/>
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
        </div>

        <!--main-->
        <div class="basis-4/12 flex flex-col justify-between">
            <div>

                <div v-if="stepIndex === 1">
                    <p class="mb-2 font-semibold transition">
                        شماره همراه خود را وارد کنید
                    </p>
                    <p class="mb-4  text-xs text-muted-foreground transition  lg:text-sm">
                        ابتدا شماره موبایل خود را وارد کنید و روی گزینه بعدی را نتخاب کنید تا به مرحله‌ی بعد بروید
                    </p>
                    <div class="grid gap-1">
                        <Label class="" for="email">
                            شماه موبایل
                        </Label>
                        <Input
                            id="phoneNumber"
                            placeholder=""
                            type="tel"
                            auto-capitalize="none"
                            auto-complete="email"
                            auto-correct="off"
                            :disabled="isLoading"
                            dir="ltr"
                        />
                    </div>

                </div>
                <div v-if="stepIndex === 2">
                    <p class="mb-2 font-semibold transition">
                        شماره همراه خود را وارد کنید
                    </p>
                    <p class="mb-8  text-xs text-muted-foreground transition  lg:text-sm">
                        کد تایید را که برای شماره موبایل شما پیامک شد را وارد کنید
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
                                    <PinInputSeparator/>
                                </template>
                            </template>
                        </PinInputGroup>
                    </PinInput>
                </div>
                <div v-if="stepIndex === 3">
                    <p class="mb-2 font-semibold transition">
                        انتخاب رمز عبور
                    </p>
                    <p class="mb-8  text-xs text-muted-foreground transition  lg:text-sm">
                        برای حساب کاربری خود یک رمز عبور انتخاب کنید
                    </p>

                    <div class="grid gap-1">
                        <Label class="" for="email">
                            رمز عبور
                        </Label>
                        <Input
                            id="email"
                            placeholder=""
                            type="password"
                            auto-capitalize="none"
                            auto-correct="off"
                            :disabled="isLoading"
                            dir="ltr"
                        />
                    </div>
                </div>
            </div>
            <div class="flex justify-between">
                <div id="prev">
                    <Button variant="outline" :disabled="stepIndex === 1" @click="handlePrev"  >
                        مرحله قبل
                    </Button>
                </div>
                <div>
                    <Button v-if="stepIndex !== 3" @click="handleNext">مرحله بعد</Button>
                    <Button v-else>ثبت نام</Button>
                </div>
            </div>
        </div>


        <!--footer-->
        <div class="basis-4/12 ">
            <Separator class="my-6" />

            <p class=" text-sm text-muted-foreground">
                در صورتی که اکانت دارید میتوانید از طربق این
                <Link
                    href="/login"
                    class="underline underline-offset-4 hover:text-primary"
                >
                    لینک
                </Link>
                وارد حساب کاربری خود شوید.
            </p>
            <p class="text-sm text-muted-foreground">
                با ثبت نام در این وبسایت تمام

                <Drawer/>

                سابت را می‌پذیرم.
            </p>
        </div>

    </div>
</template>
