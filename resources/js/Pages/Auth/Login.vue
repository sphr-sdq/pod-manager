<!-- Using Composition API -->
<script setup>
import UserAuthForm from "@/Pages/components/UserAuthForm.vue";
import AuthLayout from '../Layouts/AuthLayout.vue'

defineOptions({ layout: AuthLayout })
</script>

<template>

    <UserAuthForm/>

</template>
