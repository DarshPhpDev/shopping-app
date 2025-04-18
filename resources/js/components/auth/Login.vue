<template>
  <b-container class="mt-5">
    <b-card title="Login" class="mx-auto" style="max-width: 400px">
      <b-form @submit.prevent="login">
        <b-form-group label="Email">
          <b-form-input v-model="form.email" type="email" required></b-form-input>
        </b-form-group>
        
        <b-form-group label="Password">
          <b-form-input v-model="form.password" type="password" required></b-form-input>
        </b-form-group>
        
        <b-button type="submit" variant="primary" block>Login</b-button>
      </b-form>
      <b-alert v-if="error" variant="danger" class="mt-3">{{ error }}</b-alert>
    </b-card>
  </b-container>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/authStore'

const router = useRouter()
const form = ref({
  email: '',
  password: ''
})
const error = ref(null)
const store = useAuthStore()

const login = async () => {
  try {
    store.login(form.value)
    router.push('/')
  } catch (err) {
    error.value = err.response?.data?.message || 'Login failed'
  }
}
</script>