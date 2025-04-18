<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const error = ref(null)

import { useAuthStore } from '@/stores/authStore'
const store = useAuthStore()

onMounted(async () => {
    try {
      store.logout()
      router.push('/')
    } catch (err) {
      error.value = err.response?.data?.message || 'Logout failed'
    }
});
</script>