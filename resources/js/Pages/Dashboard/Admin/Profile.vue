<script>
import Index from './Index.vue'
export default {
    layout: Index
}
</script>

<script setup>
import AdminProfile from "@/Pages/Dashboard/Admin/Components/AdminProfile.vue";
defineProps({
    name:String,
    family:String,
    phoneNumber:String
})
</script>

<template>

    <AdminProfile :name :family :phoneNumber  />
</template>

<style scoped>

</style>
