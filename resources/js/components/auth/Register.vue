<template>
    <b-container class="mt-5">
        <b-card title="Register" class="mx-auto" style="max-width: 400px">
            <b-form @submit.prevent="validateAndRegister">
                <!-- Name Field -->
                <b-form-group 
                    label="Full Name"
                    :state="nameState"
                    invalid-feedback="Name must be at least 3 characters"
                >
                    <b-form-input
                        v-model="form.name"
                        :state="nameState"
                        @input="validateName"
                        trim
                    ></b-form-input>
                </b-form-group>

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
                    invalid-feedback="Password must be at least 6 characters"
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
                    {{ authStore.isLoading ? 'Registering...' : 'Register' }}
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
const showPassword = ref(false);

const form = ref({
    name: '',
    email: '',
    password: ''
});

const nameState = ref(null);
const emailState = ref(null);
const passwordState = ref(null);

// Validation functions
const validateName = () => {
    nameState.value = form.value.name.trim().length >= 3;
};

const validateEmail = () => {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    emailState.value = regex.test(form.value.email);
};

const validatePassword = () => {
    passwordState.value = form.value.password.length >= 6;
};

// Computed property for form validity
const formIsValid = computed(() => {
    return nameState.value === true && 
           emailState.value === true && 
           passwordState.value === true;
});

const validateAndRegister = async () => {    
    // Manual inputs validation
    validateName();
    validateEmail();
    validatePassword();

    if (!formIsValid.value) {        
        return;
    }

    try {
        const registered = await authStore.register(form.value);
        if (registered) router.push('/');
    } catch (err) {
        throw err;
    }
};
</script>