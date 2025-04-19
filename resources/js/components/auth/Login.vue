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

				<b-button 
					type="submit" 
					variant="primary"
					:disabled="authStore.isLoading"
				>
					<b-spinner small v-if="authStore.isLoading" />
					{{ authStore.isLoading ? 'Logging in...' : 'Login' }}
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
	email: '',
	password: ''
})
const error = ref(null)
const authStore = useAuthStore()

const login = async () => {
	const loggedIn = await authStore.login(form.value);
	if (loggedIn)
		router.push('/')
}
</script>