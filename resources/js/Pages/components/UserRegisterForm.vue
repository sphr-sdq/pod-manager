<script setup lang="js">
import {
    PinInput,
    PinInputGroup,
    PinInputInput,
    PinInputSeparator,
} from '@/Components/ui/pin-input'
import {Button} from '@/Components/ui/button'
import {
    Stepper,
    StepperDescription,
    StepperItem,
    StepperSeparator,
    StepperTitle,
    StepperTrigger
} from '@/Components/ui/stepper'
import {Check, Circle, Dot, Phone, LockKeyhole, MessageSquare, LoaderCircle} from 'lucide-vue-next'
import {onMounted, reactive, ref} from 'vue'
import {Label} from "@/Components/ui/label/index.js";
import {Input} from "@/Components/ui/input/index.js";
import {Separator} from '@/Components/ui/separator'
import {Link, router, useForm} from "@inertiajs/vue3";
import Drawer from "../components/DemoDrawer.vue"
import {useOtpState} from '@/composables/useOtpState'
import {useOTPStore} from "@/stores/otp.js";
import {PasswordInput} from "@/Components/ui/input-password/index.js";

const useStore = useOTPStore()
const {
    timeLeft,
    minutes,
    seconds,
    startTimer,
    isError

} = useOtpState()


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
const value = ref([]);
const isLoading = ref(false);


const phoneNumber = useForm({
    phoneNumber: ''
});

const otpCode = useForm({
    otpCode: [],
})

const password = useForm({
    password: '',
})

const stepIndex = ref(1)
const stepperFunctions = reactive({
    prev: null,
    next: null,
    is_prev_disabled: null,
    is_next_disabled: null
});

const setStepperFunction = (prev, next, is_prev_disabled, is_next_disabled) => {
    stepperFunctions.value = {
        prev, next, is_prev_disabled, is_next_disabled
    }
}
const handlePrev = () => {
    if (stepIndex.value !== 3) {
        stepperFunctions.value.prev()
    } else {
        stepIndex.value = 1;
    }
};

const handleNext = () => {
    if (stepIndex.value === 1) {
        handleSendOtp()
    }
    if (stepIndex.value === 2) {
        handleOTPVerification()
    }
    if (stepIndex.value === 3) {
        handleRegister()
    }
}
const handleSendOtp = () => {

    console.log(otpCode.data())
    otpCode.clearErrors()
    otpCode.otpCode = []

    console.log(otpCode.data())

    if ((useStore.phoneNumber && useStore.phoneNumber === phoneNumber.phoneNumber) && useStore.hasError) {
        startTimer(useStore.getRemainingTime)
    } else {
        phoneNumber.post("/otp", {
            onStart: () => isLoading.value = true,
            onFinish: () => isLoading.value = false,
            onSuccess: () => stepperFunctions.value.next(),
            onError:
                (errors) => {
                    if (errors.timeLeft) {
                        startTimer(errors.timeLeft)
                        useStore.setErrorTime(errors.timeLeft, phoneNumber.phoneNumber)
                    }
                }
        })
    }
}


const handleOTPVerification = () => {
    otpCode.transform((data) => ({
        otpCode: data.otpCode.join(''),
        phoneNumber: phoneNumber.phoneNumber
    })).post('/verify', {
        onStart: () => isLoading.value = true,
        onFinish: () => isLoading.value = false,
        onSuccess: () => {
            stepperFunctions.value.next();
        },
    })
}

const handleRegister = () => {
    password.transform((data) =>({
        password : data.password,
        phoneNumber : phoneNumber.phoneNumber
    })).post('/register' , {
        onStart : () => isLoading.value = true,
        onFinish : () => isLoading.value = false
    })
}

</script>

<template>

    <div class="flex flex-col h-full  justify-between">

        <!--header-->
        <div class=" basis-3/12">
            <div class="flex flex-row items-baseline gap-2 mb-2">
                <div class="w-3 h-3 border-2 border-black p-0.5">
                    <div class="w-full h-full bg-black"></div>
                </div>
                <h1 class="text-3xl font-bold">ثبت نام</h1>
            </div>

            <h3 class="text-sm text-muted-foreground">


                برای اینجاد حساب کاریری مراحل زیر را طی نمایید.

            </h3>

            <Stepper class="flex mt-6 w-full items-start"
                     v-model="stepIndex"
                     v-slot="{ isNextDisabled, isPrevDisabled, nextStep, prevStep }"
            >
                {{ setStepperFunction(prevStep, nextStep, isPrevDisabled, isNextDisabled) }}
                <StepperItem
                    v-for="step in steps"
                    :key="step.step"
                    v-slot="{ state }"
                    disabled
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
                            class="z-10 rounded-full shrink-0 mt-2 disabled:opacity-100"
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
        <div class="basis-5/12 flex flex-col ">
            <div class="flex-grow">
                <div v-if="stepIndex === 1" class="flex flex-col h-full">
                    <div>

                        <p class="mb-2 font-semibold transition">
                            شماره همراه خود را وارد کنید
                        </p>
                        <p class=" text-xs text-muted-foreground transition  lg:text-sm text-justify">
                            ابتدا شماره موبایل خود را وارد کنید و گزینه‌ی دریافت کد را نتخاب کنید تا به مرحله‌ی بعد
                            بروید
                        </p>
                    </div>
                    <div class="my-auto grid">
                        <form @submit.prevent="handleSendOtp">

                            <Label class="" for="phoneNumber">
                                شماه موبایل
                            </Label>
                            <Input
                                v-model="phoneNumber.phoneNumber"
                                id="phoneNumber"
                                name="phoneNumber"
                                placeholder="09*********"
                                type="tel"
                                auto-correct="off"
                                :disabled="isLoading || isError"
                                dir="ltr"
                            />
                            <div class="text-xs text-red-600 font-bold my-2" v-if="phoneNumber.errors.userExist">
                                {{ phoneNumber.errors.userExist }}
                            </div>
                            <div v-else-if="isError && (minutes  && seconds) " class="text-xs text-red-600 font-bold my-2">
                                برای دریافت کد جدید لطفا
                                {{ seconds }} : {{ minutes }}
                                دیگر مجدد تلاش کنید.
                            </div>
                            <div class="text-xs text-red-600 font-bold my-2" v-else-if="phoneNumber.errors.phoneNumber">
                                {{ phoneNumber.errors.phoneNumber }}
                            </div>


                        </form>
                    </div>
                </div>
                <div v-if="stepIndex === 2" class="flex flex-col h-full">
                    <div>

                        <p class="mb-2 font-semibold transition">
                            کد تایید دریافتی را وارد کنید
                        </p>
                        <p class="text-xs text-muted-foreground transition  lg:text-sm text-justify">
                            کد تاییدی را که برای شماره
                            <span dir="ltr" class="font-bold">
                        {{ "&thinsp; +98" + phoneNumber.phoneNumber.substring(1) + " " }}
                            </span>
                            پیامک شده را وارد کنید. در صورتی که این شماره شما نیست لطفا به مرحله قبل بازگردید.
                        </p>
                    </div>
                    <div class="my-auto">


                        <form @submit.prevent="handleOTPVerification">
                            <PinInput
                                id="pin-input"
                                v-model="otpCode.otpCode"
                                placeholder="○"
                                name="pin-input"
                                @complete="handleOTPVerification"
                                :disabled="isLoading || isError"
                            >

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
                            <div class="text-xs text-red-600 font-bold my-2" v-if="otpCode.errors.invalid">
                                {{ otpCode.errors.invalid }}
                            </div>
                            <div class="text-xs text-red-600 font-bold my-2" v-else-if="otpCode.errors.otpCode">
                                {{ otpCode.errors.otpCode }}
                            </div>

                        </form>

                    </div>
                </div>
                <div v-if="stepIndex === 3" class="flex flex-col h-full">
                    <div>
                        <p class="mb-2 font-semibold transition">
                            انتخاب رمز عبور
                        </p>
                        <p class=" text-xs text-muted-foreground transition  lg:text-sm">
                            برای حساب کاربری خود یک رمز عبور انتخاب کنید
                        </p>
                    </div>


                    <div class="grid gap-1 my-auto">
                        <form @submit.prevent="handleNext">


                        <Label class="" for="password">
                            رمز عبور
                        </Label>
                        <PasswordInput
                            v-model="password.password"
                            id="password"
                            placeholder=""
                            auto-capitalize="none"
                            auto-correct="off"
                            :disabled="isLoading"
                        />
                            <div class="text-xs text-red-600 font-bold my-2" v-if="password.errors.password">
                                {{password.errors.password }}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="flex justify-between">
                <div id="prev">
                    <Button variant="outline" v-if="stepIndex !== 1" @click="handlePrev">
                        <span v-if="stepIndex !== 3">مرحله قبل</span>
                        <span v-else>تغییر شماره</span>
                    </Button>
                </div>
                <div>
                    <Button @click="handleNext" :disabled="isLoading || isError" class="w-20">

                        <span v-if="!isLoading">
                            <span v-if="stepIndex === 1">
                            دریافت کد
                            </span>
                            <span v-else-if="stepIndex === 2">
                            تایید کد
                            </span>
                            <span v-else-if="stepIndex === 3">
                           ثبت نام
                            </span>

                        </span>
                        <span v-else><LoaderCircle class="animate-spin"/></span>


                    </Button>

                </div>
            </div>
        </div>


        <!--footer-->
        <div class="basis-4/12 ">
            <Separator class="my-6"/>

            <p class=" text-sm text-muted-foreground text-justify">
                در صورتی که اکانت دارید میتوانید از طربق این
                <Link
                    href="/login"
                    class="underline underline-offset-4 hover:text-primary"
                >
                    لینک
                </Link>
                وارد حساب کاربری خود شوید.
            </p>
            <p class="text-sm text-muted-foreground mt-2 text-justify">
                با ثبت نام در این وبسایت تمام

                <Drawer/>

                سایت را می‌پذیرم.
            </p>
        </div>

    </div>
</template>
