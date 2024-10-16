<script setup lang="js">

</script>

<template>

    <div class="container relative hidden h-screen flex-col items-center justify-center md:grid lg:max-w-none lg:grid-cols-2 lg:px-0
">
        <div class="lg:p-8">
            <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                <slot />
            </div>
        </div>

        <div class="relative hidden h-full flex-col bg-muted p-10 text-white dark:border-r lg:flex">
            <div class="bg-cover absolute inset-0 bg-zinc-900
            bg-[url('https://images.unsplash.com/photo-1687300172792-68a13c4e149a?q=80&w=2574&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')]
" />

        </div>
    </div>

</template>
