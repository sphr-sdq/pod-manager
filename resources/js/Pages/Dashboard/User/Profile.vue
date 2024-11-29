<script>
import Index from './Index.vue'
export default {
    layout: Index
}
</script>

<script setup>
import UserProfile from "@/Pages/Dashboard/User/Components/UserProfile.vue";
defineProps({
    name:String,
    family:String,
    phoneNumber:String
})
</script>

<template>

    <UserProfile :name :family :phoneNumber  />
</template>

<style scoped>

</style>
