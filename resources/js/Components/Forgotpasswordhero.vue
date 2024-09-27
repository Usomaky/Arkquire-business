<template>
    <section class="w-full wrapper pb-8 pt-4 md:py-24 flex xl:gap-x-16">
        <!-- left -->
        <div class="w-full md:w-11/12 lg:w-8/12 space-y-10">
            <h1 class="text-neutral-800 text-3xl">Reset Password</h1>
            <small class="text-neutral-500">Let's verify it's you. Kindly enter your email.</small>
            <div class="w-full md:w-8/12 space-y-4">
                <InputText v-model="email" class="w-full" size="small" placeholder="Enter your email" />
                <button :disabled="processing || !email" @click="sendOTP" class="btn w-full primary">SEND OTP</button>
            </div>
            <p v-if="error" class="text-red-600">{{ error }}</p>

            <ForgotPasswordOtp 
                :user="user" 
                :visible="showOTPDialog" 
                @update:visible="showOTPDialog = $event"
                :email="email"
            />
        </div>

        <!-- right -->
        <div class="w-full lg:w-4/12 xl:w-6/12 hidden lg:flex items-center justify-end">
            <div>
                <img class="w-full object-contain pointer-events-none" src="/images/rectangle.png" alt="image">
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputText from 'primevue/inputtext';
import ForgotPasswordOtp from '../Components/Forgotpasswordotp.vue';

const email = ref('');
const processing = ref(false);
const error = ref('');
const showOTPDialog = ref(false);

const sendOTP = async () => {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    // Trim spaces from the email input
    const trimmedEmail = email.value.trim();
    
    if (!emailPattern.test(trimmedEmail)) {
        error.value = 'The email field must be a valid email address.';
        return;
    }

    try {
        processing.value = true;
        error.value = '';

        const form = useForm({ email: trimmedEmail });

        form.post('/password/otp', {
            onSuccess: ({ props }) => {
                // Ensure the dialog is closed before opening it again
                showOTPDialog.value = false;
                setTimeout(() => {
                    showOTPDialog.value = true; // Open the OTP dialog
                }, 0); // Small delay
            },
            onError: () => {
                error.value = 'No account exists with such email!';
            }
        });
    } catch (err) {
        error.value = 'An unexpected error occurred.';
    } finally {
        processing.value = false;
    }
};
</script>
