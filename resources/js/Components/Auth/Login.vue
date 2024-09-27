<script setup>
import { ref, defineProps, watch, defineEmits } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';
import { dialogStyles } from '../../PassThroughs/Dialog.js';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import Button from 'primevue/button';
import Checkbox from 'primevue/checkbox';
import Message from 'primevue/message';

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

const processing = ref(false);
const messages = ref([]);
let count = ref(0);

const showMessage = (severity, content) => {
    messages.value = [
        { severity, content, id: count.value++ }
    ];
}

const form = ref({
    email: null,
    password: null,
    remember: false,
    otp: null
});

const login = () => {
    processing.value = true;
    router.post('/login', form.value, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: (res) => {
            showMessage('success', res.props.flash?.message);
            processing.value = false;
            setTimeout(() => {
                show.value = false;
            }, 1000);
            window.location.reload();
        },
        onError: (err) => {
            err?.message && showMessage('warn', err.message);
            processing.value = false;
            // console.log(err);
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
    <Dialog :pt="dialogStyles" v-model:visible="show" modal header="Sign in" :style="{ width: '26rem' }" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
        <div class="w-full mb-3">
            <Message v-for="msg of messages" :key="msg.id" :severity="msg.severity">
                {{ msg.content }}
            </Message>
        </div>
        <div class="w-full mb-2">
            <label class="text-xs">Email</label>
            <InputText :class="$page?.props?.errors?.email && 'p-invalid'" class="w-full" v-model="form.email" size="small"/>
            <small v-if="$page?.props?.errors?.email" class="text-xs text-red-400">
                {{ $page?.props?.errors?.email }}
            </small>
        </div>
        <div class="w-full mb-4">
            <label class="text-xs">Password</label>
            <Password :class="$page?.props?.errors?.password && 'p-invalid'" class="w-full p-inputtext-sm" inputStyle="width:100%" v-model="form.password" toggleMask aria-describedby="text-error" :feedback="false"/>
            <small v-if="$page?.props?.errors?.password" class="text-xs text-red-400">
                {{ $page?.props?.errors?.password }}
            </small>
        </div>
        <div class="flex items-center justify-between w-full mb-6">
            <div class="flex items-center gap-1">
                <Checkbox v-model="form.remember" inputId="remember" :binary="true"/>
                <label for="remember" class="text-xs"> Remember me </label>
            </div>
            <Link
                    :class="
                        $page.url.startsWith('/forgotpassword')
                            ? 'border-black'
                            : 'border-transparent text-neutral-400'
                    "
                    class="text-xs text-primary-400"
                    href="/forgotpassword"
                    >Forgot password ?</Link
                >
        </div>
        <div class="w-full mb-3">
            <button :disabled="processing" @click="login" class="w-full btn primary">
                Login to account
            </button>
        </div>
        <div class="flex justify-center w-full mb-8">
            <p class="text-xs">New to Arkquire ?
                <Link href="#" class="text-primary-400">Click here to register</Link>
            </p>
        </div>
        <div class="flex justify-between w-full text-xs text-neutral-400">
            <Link href="#">Terms and conditions</Link>
            <Link href="#">Privacy policy</Link>
        </div>
    </Dialog>
</template>
