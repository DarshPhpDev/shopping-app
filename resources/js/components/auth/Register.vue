<template>
    <b-container class="mt-5">
        <b-card title="Register" class="mx-auto" style="max-width: 400px">
            <b-form @submit.prevent="register">
                <b-form-group label="Name">
                    <b-form-input v-model="form.name" required></b-form-input>
                </b-form-group>

                <b-form-group label="Email">
                    <b-form-input v-model="form.email" type="email" required></b-form-input>
                </b-form-group>

                <b-form-group label="Password">
                    <b-form-input v-model="form.password" type="password" required></b-form-input>
                </b-form-group>

                <b-button 
                    type="submit" 
                    variant="primary"
                    :disabled="authStore.isLoading"
                >
                    <b-spinner small v-if="authStore.isLoading" />
                    {{ authStore.isLoading ? 'Registering...' : 'Register' }}
                </b-button>
            </b-form>
        </b-card>
    </b-container>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/authStore'

const router = useRouter()
const form = ref({
  name: '',
  email: '',
  password: ''
})
const error = ref(null)

const authStore = useAuthStore()

const register = async () => {
    const registered = await authStore.register(form.value);
    if(registered)
        router.push('/')
}
</script>