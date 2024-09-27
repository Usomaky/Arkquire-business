<script setup>
import { ref, defineProps, watch, defineEmits } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';
import { dialogStyles } from '../../PassThroughs/Dialog.js';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import Button from 'primevue/button';
import Message from 'primevue/message';
import OTP from './OTP.vue';

const props = defineProps({
    visible: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['update:visible']);

const show = ref(props.visible);

watch(
    () => props.visible,
    (visible) => {
        show.value = visible;
    }
)
watch(
    () => show.value,
    (visible) => {
        emit('update:visible', visible);
    }
)

const screen = ref('Register');

const form = ref({
    // fullname: 'Okeoghene Esieba',
    // email: 'okecoc1@gmail.com',
    // phone: '09078533114',
    // password: 'test1234',
    // password_confirm: 'test1234',
    // otp: null
    fullname: null,
    email: null,
    phone: null,
    password: null,
    password_confirm: null,
    otp: null
});

const processing = ref(false);
const messages = ref([]);
let count = ref(0);

const showMessage = (severity, content) => {
    messages.value = [
        { severity, content, id: count.value++ }
    ];
}

const clearFields = () => {
    form.value = {
        fullname: null,
        email: null,
        phone: null,
        password: null,
        password_confirm: null,
        otp: null
    }
}

const sendOTP = () => {
    processing.value = true;
    router.post('/sendotp', form.value, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: (res) => {
            screen.value = 'Enter OTP';
            processing.value = false;
        },
        onError: (err) => {
            processing.value = false;
        }
    });
}

const register = () => {
    processing.value = true;
    router.post('/register', form.value, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: (res) => {
            showMessage('success', res.props.flash?.message);
            processing.value = false;
            screen.value = 'Successful';
            clearFields();
            setTimeout(() => {
                show.value = false;
            }, 3000);
        },
        onError: (err) => {
            err?.message && showMessage('warn', err.message);
            processing.value = false;
            console.log(err);
        }
    });
}
</script>

<style scoped>
*{
    font-family: 'DM Sans', sans-serif;
}
</style>

<template>
    <Dialog :pt="dialogStyles" v-model:visible="show" modal :header="screen" :style="{ width: '26rem' }" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
        <div class="w-full mb-3">
            <Message v-for="msg of messages" :key="msg.id" :severity="msg.severity">
                {{ msg.content }}
            </Message>
        </div>
        <section v-if="screen == 'Register'">
            <div class="w-full mb-2">
                <label class="text-xs">Fullname</label>
                <InputText :class="$page?.props?.errors?.fullname && 'p-invalid'" class="w-full" v-model="form.fullname" size="small"/>
                <small v-if="$page?.props?.errors?.fullname" class="text-xs text-red-400">
                    {{ $page?.props?.errors?.fullname }}
                </small>
            </div>
            <div class="w-full grid grid-cols-12 gap-3">
                <div class="w-full mb-2 col-span-7">
                    <label class="text-xs">Email</label>
                    <InputText :class="$page?.props?.errors?.email && 'p-invalid'" class="w-full" v-model="form.email" size="small"/>
                    <small v-if="$page?.props?.errors?.email" class="text-xs text-red-400">
                        {{ $page?.props?.errors?.email }}
                    </small>
                </div>
                <div class="w-full mb-2 col-span-5">
                    <label class="text-xs">Phone</label>
                    <InputText :class="$page?.props?.errors?.phone && 'p-invalid'" class="w-full" v-model="form.phone" size="small"/>
                    <small v-if="$page?.props?.errors?.phone" class="text-xs text-red-400">
                        {{ $page?.props?.errors?.phone }}
                    </small>
                </div>
            </div>
            <div class="w-full grid grid-cols-2 gap-3">
                <div class="w-full mb-2">
                    <label class="text-xs">Password</label>
                    <Password :class="$page?.props?.errors?.password && 'p-invalid'" class="w-full p-inputtext-sm" v-model="form.password" inputStyle="width:100%" toggleMask aria-describedby="text-error"/>
                    <small v-if="$page?.props?.errors?.password" class="text-xs text-red-400">
                        {{ $page?.props?.errors?.password }}
                    </small>
                </div>
                <div class="w-full mb-4">
                    <label class="text-xs">Confirm password</label>
                    <Password :class="$page?.props?.errors?.password_confirm && 'p-invalid'" class="w-full p-inputtext-sm" v-model="form.password_confirm" inputStyle="width:100%" toggleMask aria-describedby="text-error"/>
                    <small v-if="$page?.props?.errors?.password_confirm" class="text-xs text-red-400">
                        {{ $page?.props?.errors?.password_confirm }}
                    </small>
                </div>
            </div>
            <div class="w-full mb-3">
                <button :disabled="processing" @click="sendOTP" class="btn w-full primary">
                    Create account
                </button>
            </div>
            <div class="w-full mb-8 flex justify-center">
                <p class="text-xs text-center">Already a registered on Arkquire ?
                    <Link href="#" class="text-primary-400">Click here to login</Link>
                </p>
            </div>
        </section>
        <section v-else-if="screen == 'Enter OTP'">
            <div class="w-full mb-8 flex flex-col gap-4 items-center">
                <label class="text-xs">An OTP has been sent to your email.</label>
                <OTP v-model="form.otp"/>
                <small v-if="$page?.props?.errors?.otp" class="text-sm text-red-400 mb-4">
                    {{ $page?.props?.errors?.otp }}
                </small>
                <button :disabled="processing" @click="register" class="btn w-1/2 primary">
                    Submit
                </button>
            </div>
        </section>
        <div class="w-full flex justify-between text-xs text-neutral-400">
            <Link href="#">Terms and conditions</Link>
            <Link href="#">Privacy policy</Link>
        </div>
    </Dialog>
</template>
