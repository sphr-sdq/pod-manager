<script setup>
import HideOnScrollNavbar from './components/HideOnScrollNavbar.vue'
import Hero from "./components/Hero.vue"
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
import {Button} from "@/Components/ui/button";
import UserAuthForm from "@/Pages/components/UserAuthForm.vue";
import {ref} from "vue";
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from '@/components/ui/accordion'
import {Link} from "@inertiajs/vue3"


const features = [
    {
        icon: "fas fa-rocket",
        title: "استقرار سریع",
        description: "اپلیکیشن‌های خود را در چند ثانیه آنلاین کنید.",
    },
    {
        icon: "fas fa-shield-alt",
        title: "امنیت بالا",
        description: "با زیرساخت امن، اپلیکیشن‌های خود را ایمن نگه دارید.",
    },
    {
        icon: "fas fa-sync-alt",
        title: "انعطاف‌پذیری",
        description: "زیرساختی که با نیازهای شما رشد می‌کند.",
    },
    {
        icon: "fas fa-cogs",
        title: "مدیریت ساده",
        description: "همه چیز در یک داشبورد کارآمد و ساده.",
    },
];

const hoverIndex = ref(null);

const defaultValue = 'item-1'

const accordionItems = [
    { value: 'item-1', title: ' این پلتفرم چگونه کار می‌کند؟', content: 'پلتفرم ما به شما این امکان را می‌دهد که اپلیکیشن‌های خود را تنها با چند کلیک ساده استقرار دهید. کافی است پروژه خود را انتخاب کنید، تنظیمات موردنظر را انجام دهید و اپلیکیشن شما به‌صورت خودکار روی سرورها مستقر می‌شود.' },
    { value: 'item-2', title: ' آیا نیاز به دانش فنی برای استفاده از این پلتفرم دارم؟', content: 'خیر، این پلتفرم به گونه‌ای طراحی شده که حتی کاربران غیرتخصصی نیز بتوانند به راحتی از آن استفاده کنند. البته، کاربران حرفه‌ای می‌توانند از قابلیت‌های پیشرفته نیز بهره‌مند شوند.\n' +
            '\n' },
    { value: 'item-3', title: ' آیا می‌توانم دامنه شخصی خود را به اپلیکیشن متصل کنم؟', content: 'بله، شما می‌توانید دامنه شخصی خود را به اپلیکیشن متصل کنید. راهنمای اتصال دامنه در بخش تنظیمات موجود است.' },
    { value: 'item-4', title: 'هزینه استفاده از پلتفرم چقدر است؟', content: 'هزینه‌ها بر اساس منابعی که استفاده می‌کنید (مانند پردازنده، رم و فضای ذخیره‌سازی) محاسبه می‌شود. شما تنها برای منابعی که مصرف می‌کنید، پرداخت می‌کنید.' },
    { value: 'item-5', title: 'من توسعه‌دهنده هستم؛ آیا می‌توانم از این پلتفرم کسب درامد کنم؟', content: 'بله، توسعه‌دهندگان اپن سورس می‌توانند با ورود به یک توافق‌نامه اشتراک درآمد، 20٪ از درآمد تولید شده توسط اپلیکیشن خود را دریافت کنند. اگر علاقه‌مند به استفاده از پلتفرم ما به‌عنوان گزینه میزبانی برای پروژه خود هستید، لطفاً از طریق آدرس تماس موجود در پایین صفحه با ما در ارتباط باشید.\n' +
            '\n' },

]


defineProps({
    pods : Array,
    tags : Array
})
</script>

<template>
    <section >
        <nav >
            <HideOnScrollNavbar/>
        </nav>

    </section>
    <section>
        <main class="container">
            <div class="h-20"></div>
            <div class=" mx-auto">
                <Hero height="250px">
                    <div class="mx-auto p-8">
                        <h1 class="text-4xl font-bold text-white my-10">اینجا همه چیز با یک کلیک شروع می‌شود!</h1>
                        <p class="text-white">پلتفرمی برای توسعه‌دهندگان که استقرار اپلیکیشن‌ها را به ساده‌ترین شکل ممکن تبدیل می‌کند. در سریع‌ترین زمان، اپلیکیشن‌های خود را آنلاین کنید.</p>
                    </div>
                </Hero>
            </div>

        </main>
    </section>

    <div class="container grid grid-cols-4 gap-4 mt-10">
        <div
            v-for="(feature, index) in features"
            :key="index"
            class="feature-box"
            @mouseover="hoverIndex = index"
            @mouseleave="hoverIndex = null"
            :class="{ hovered: hoverIndex === index }"
        >
            <i :class="feature.icon" class="feature-icon"></i>
            <h3 class="feature-title">{{ feature.title }}</h3>
            <p class="feature-description">{{ feature.description }}</p>
        </div>
    </div>
    <section class="container mt-16 mb-8">
        <div class="flex flex-row items-baseline gap-2 mb-8">
            <div class="w-3 h-3 border-2 border-black p-0.5">
                <div class="w-full h-full bg-black"></div>
            </div>
            <h1 class="text-3xl font-bold"> پاد‌ها</h1>
        </div>

        <div class="grid gap-4 grid-cols-2">
        <Card v-for="(pod , index) in pods" :key="index">
            <CardHeader>
                <CardTitle class="flex items-center gap-3">
                    <img  :alt="pod.name" :src="'storage/' + pod.image_path" height="50px" width="50px" />
                    <Link :href="'/pods/'+pod.slug" class="underline opacity-70 hover:opacity-100">
                        {{pod.name}}
                    </Link>

                </CardTitle>
                <CardDescription class="text-container" v-html="pod.description">
                </CardDescription>
            </CardHeader>
            <CardContent>

                    <Button
                        v-for="(tag, iindex) in pod.tags"
                        variant="outline"
                        size="sm"
                        :key="iindex"
                        :class="[
                            iindex !== 0 ? 'mr-2' : '',
                            'h-7 border-dashed hover:border-red-500 hover:bg-red-50 hover:text-red-600 transition-colors'
                        ]"
                    >
                        <span class="ml-1" >{{ tag.name }}</span>

                    </Button>

            </CardContent>
        </Card>
        </div>
    </section>
    <section>
        <div class="bg-black/10 ">
            <div class="grid grid-cols-2 gap-4 container py-10">
                <div>
                    <div class="flex flex-row items-baseline gap-2 mb-4">
                        <div class="w-3 h-3 border-2 border-black p-0.5">
                            <div class="w-full h-full bg-black"></div>
                        </div>
                        <h1 class="text-3xl font-bold"> در هر زمینه</h1>
                    </div>
                    <p class="text-black/60">
                        از
                        <span class="bg-black/10 px-1 rounded-xl">
                             localhost:3000
                        </span>
                        &nbsp
                        تا
                        <span class="bg-black/10 px-1 rounded-xl">
                            awesome.com
                        </span>
                        &nbsp
                        با یک کلیک.

                    </p>
                </div>

                <div>
                    <div class="flex gap-2">
                                     <span v-for="tag in tags" :key="tag.slug" class="border border-dashed p-1 border-black/40 text-black/80 text-sm
                                              hover:text-black/50 hover:border-black/20 hover:cursor-pointer ">

                    {{tag.name}}

            </span>
                    </div>

                </div>
            </div>


        </div>
    </section>
    <section class="container mt-16 mb-8">
        <div class="flex flex-row items-baseline gap-2 mb-4">
            <div class="w-3 h-3 border-2 border-black p-0.5">
                <div class="w-full h-full bg-black"></div>
            </div>
            <h1 class="text-3xl font-bold"> سوالات متداول</h1>

        </div>

        <Accordion type="single" class="w-[100%] mx-auto" collapsible :default-value="defaultValue">
            <AccordionItem v-for="item in accordionItems" :key="item.value" :value="item.value">
                <AccordionTrigger>{{ item.title }}</AccordionTrigger>
                <AccordionContent>
                    {{ item.content }}
                </AccordionContent>
            </AccordionItem>
        </Accordion>


    </section>
    <section class="">
        <footer class="bg-black/90 text-white py-10">
            <div class="container mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-semibold mb-4">درباره ما</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-gray-400">درباره ما</a></li>
                        <li><a href="#" class="hover:text-gray-400">خدمات</a></li>
                        <li><a href="#" class="hover:text-gray-400">تیم ما</a></li>
                        <li><a href="#" class="hover:text-gray-400">سوالات متداول</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xl font-semibold mb-4">تماس با ما</h3>
                    <ul class="space-y-2 text-sm">
                        <li>ایمیل: <a href="mailto:info@example.com" class="hover:text-gray-400"></a></li>
                        <li>تلفن: <a href="" class="hover:text-gray-400"></a></li>
                        <li>آدرس:</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xl font-semibold mb-4">شبکه‌های اجتماعی</h3>
                    <ul class="flex space-x-4 rtl:space-x-reverse">
                        <li>
                            <a href="#" class="hover:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                                    <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                                    <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="hover:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                                    <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>

    </section>
</template>

<style scoped>
.text-container {
    display: -webkit-box;
    -webkit-line-clamp: 3; /* Limit the text to 3 lines */
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.5em; /* Adjust line height for spacing */
    max-height: 4.5em; /* Ensures it hides after 3 lines */
    position: relative;

    /* Create the gradient fade effect at the bottom of the text */
    //background: linear-gradient(to top, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 100%);
    //-webkit-mask-image: linear-gradient(to top, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 100%);
    mask-image: linear-gradient(to top, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 100%);
}


.feature-box {
    background: #f9f9f9;
    border: 1px solid #e0e0e0;
    padding: 20px;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s, background 0.3s;
    cursor: pointer;
}

.feature-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    background: #ffffff;
}

.feature-box.hovered {
    border-color: #1e1e1e;
}

.feature-icon {
    font-size: 40px;
    color: #656565;
    margin-bottom: 15px;
    transition: transform 0.3s;
}

.feature-box:hover .feature-icon {
    transform: rotate(20deg);
}

.feature-title {
    font-size: 18px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

.feature-description {
    font-size: 14px;
    color: #666;
}

.hover\:text-gray-400 {
    transition: color 0.3s ease;
}
</style>
