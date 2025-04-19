<template>
    <b-container class="mt-5">
        <b-card title="Login" class="mx-auto" style="max-width: 400px">
            <b-form @submit.prevent="validateAndLogin">
            <!-- Email Field -->
                <b-form-group 
                  label="Email"
                  :state="emailState"
                  invalid-feedback="Please enter a valid email address"
                >
                    <b-form-input
                        v-model="form.email"
                        type="email"
                        :state="emailState"
                        @input="validateEmail"
                        trim
                    ></b-form-input>
                </b-form-group>

                <!-- Password Field -->
                <b-form-group
                    label="Password"
                    :state="passwordState"
                    invalid-feedback="Password must be at least 8 characters"
                >
                    <b-input-group>
                        <b-form-input
                            v-model="form.password"
                            :type="showPassword ? 'text' : 'password'"
                            :state="passwordState"
                            @input="validatePassword"
                        ></b-form-input>
                        <b-input-group-append>
                            <b-button 
                                @click="showPassword = !showPassword" 
                                variant="outline-secondary"
                                tabindex="-1"
                            >
                                <i :class="showPassword ? 'bi-eye' : 'bi-eye-slash'"></i>
                            </b-button>
                        </b-input-group-append>
                    </b-input-group>
                </b-form-group>

                <!-- Submit Button -->
                <b-button 
                    type="submit" 
                    variant="primary"
                    :disabled="!formIsValid || authStore.isLoading"
                    block
                >
                <b-spinner small v-if="authStore.isLoading" />
                    {{ authStore.isLoading ? 'Logging in...' : 'Login' }}
                </b-button>
            </b-form>
        </b-card>
    </b-container>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/authStore';

const router = useRouter();
const authStore = useAuthStore();
const error = ref(null);

const form = ref({
    email: '',
    password: ''
});

const emailState = ref(null); // null, true (valid), false (invalid)
const passwordState = ref(null);
const showPassword = ref(false);

// Validation functions (email & password)
const validateEmail = () => {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    emailState.value = regex.test(form.value.email);
};

const validatePassword = () => {
    passwordState.value = form.value.password.length >= 6;
};

// Computed property for form validity
const formIsValid = computed(() => {
    return emailState.value === true && passwordState.value === true;
});

const validateAndLogin = async () => {
    // Manual inputs validation
    validateEmail();
    validatePassword();

    if (!formIsValid.value) {
        return;
    }

    try {
        const loggedIn = await authStore.login(form.value);
        if (loggedIn) 
            router.push('/');
    } catch (err) {
        throw err;
    }
};
</script>