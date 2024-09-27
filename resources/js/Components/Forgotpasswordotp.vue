<template>
    <Dialog
        v-model:visible="show"
        modal
        header="Reset Password"
        :style="{ width: '26rem' }"
        :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
    >
        <Message v-if="successMessage" severity="success" class="mt-4">
            {{ successMessage }}
        </Message>
        <form @submit.prevent="resetPassword">
            <div class="hidden">
                <label for="email">Email</label>
                <InputText v-model="form.email" id="email" />
            </div>

            <div class="w-full mb-2">
                <label class="text-xs flex justify-center"
                    >An OTP has been sent to your email, enter it below</label
                >
                <OTP
                    v-model="form.otp"
                    id="otp"
                    class="mt-2 flex justify-center"
                />
                <small
                    v-if="$page?.props?.errors?.otp"
                    class="text-sm text-red-400 mb-4"
                >
                    {{ $page?.props?.errors?.otp }}
                </small>
            </div>
            <div class="w-full mb-2">
                <label for="password" class="text-xs">New Password</label>
                <Password
                    v-model="form.password"
                    id="password" inputStyle="width:100%"
                    class="w-full p-inputtext-sm"
                    toggleMask
                />
                <small
                    v-if="$page?.props?.errors?.password"
                    class="text-xs text-red-400"
                >
                    {{ $page?.props?.errors?.password }}
                </small>
            </div>
            <div class="w-full">
                <label for="password_confirmation" class="text-xs"
                    >Confirm New Password</label
                >
                <Password
                    v-model="form.password_confirm"
                    id="password_confirmation" inputStyle="width:100%"
                    class="w-full p-inputtext-sm"
                    toggleMask
                />
            </div>
            <small
                v-if="$page?.props?.errors?.password_confirm"
                class="text-xs text-red-400"
            >
                {{ $page?.props?.errors?.password_confirm }}
            </small>
            <Button
                type="submit"
                class="btn w-full primary mt-5"
                label="Save"
            />
        </form>
    </Dialog>
</template>

<script setup>
import { ref, defineProps, watch } from "vue";
import { router } from "@inertiajs/vue3";
import Dialog from "primevue/dialog";
import InputText from "primevue/inputtext";
import Password from "primevue/password";
import Button from "primevue/button";
import Message from "primevue/message";
import OTP from "../Components/Auth/OTP.vue";

const props = defineProps({
    visible: Boolean,
    email: String,
});
const emit = defineEmits(["update:visible"]);
const show = ref(props.visible);
const successMessage = ref(null);

watch(
    () => props.visible,
    (visible) => {
        show.value = visible;
    }
);
watch(
    () => show.value,
    (visible) => {
        emit("update:visible", visible);
    }
);

const form = ref({
    otp: null,
    email: props.email,
    password: null,
    password_confirm: null,
});

const clearFields = () => {
    form.value.otp = "";
    form.value.email = "";
    form.value.password = "";
    form.value.password_confirm = "";
};

const resetPassword = () => {
    form.value.email = props.email;

    router.post("/reset-password", form.value, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: (res) => {
            successMessage.value = res.props.flash?.message;
            clearFields();
            setTimeout(() => {
                show.value = false;
                setTimeout(() => {
                    router.visit("/");
                }, 0); // 0 seconds delay
            }, 5000); // Keep the dialog visible for 5 seconds to show the success message
        },
        onError: (err) => {
            successMessage.value = null;
            console.error(err);
        },
    });
};
</script>

