<template></template>
<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const error = ref(null)

import { useAuthStore } from '@/stores/authStore'
const authStore = useAuthStore()

onMounted(async () => {
    authStore.logout()
    router.push('/')
});
</script>