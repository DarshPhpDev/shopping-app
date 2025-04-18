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
        
        <b-button type="submit" variant="primary" block>Register</b-button>
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
  name: '',
  email: '',
  password: ''
})
const error = ref(null)

const store = useAuthStore()

const register = async () => {
  try {
    store.register(form.value)
    router.push('/')
  } catch (err) {
    error.value = err.response?.data?.message || 'Registration failed'
  }
}
</script>