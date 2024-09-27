<script setup>
import { ref, defineProps, watch, defineEmits } from "vue";
import { Link, router } from "@inertiajs/vue3";
import Dialog from "primevue/dialog";
import InputText from "primevue/inputtext";
import Password from "primevue/password";
import Button from "primevue/button";
import Message from "primevue/message";

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    visible: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["update:visible"]);

const show = ref(props.visible);

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
    fullname: props.user.fullname || "",
    email: props.user.email || "",
    phone: props.user.phone || "",
    current_password: '',
    password: "",
    password_confirmation: "",
});

const processing = ref(false);
const messages = ref([]);
let count = ref(0);

const showMessage = (severity, content) => {
    messages.value = [{ severity, content, id: count.value++ }];
};

const updateProfile = () => {
    processing.value = true;
    router.put("/profile/update", form.value, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: (res) => {
            showMessage("success", res.props.flash?.message);
            processing.value = false;
            setTimeout(() => {
                show.value = false;
            }, 3000);
        },
        onError: (err) => {
            err?.message && showMessage("warn", err.message);
            processing.value = false;
            console.log(err);
        },
    });
};
</script>

<style scoped>
* {
    font-family: "DM Sans", sans-serif;
}
</style>

<template>
    <Dialog
        v-model:visible="show"
        modal
        header="Edit Profile"
        :style="{ width: '26rem' }"
        :breakpoints="{ '1199px': '75vw', '575px': '90vw' }"
    >
        <div class="w-full mb-3">
            <Message
                v-for="msg of messages"
                :key="msg.id"
                :severity="msg.severity"
            >
                {{ msg.content }}
            </Message>
        </div>
        <section>

             <div class="w-full mb-2">
                <label class="text-xs"> Current Password</label>
                <Password
                    :class="$page?.props?.errors?.current_password && 'p-invalid'"
                    class="w-full p-inputtext-sm" inputStyle="width:100%"
                    v-model="form.current_password"
                    toggleMask
                    aria-describedby="text-error"
                />
                <small
                    v-if="$page?.props?.errors?.current_password"
                    class="text-xs text-red-400"
                >
                    {{ $page?.props?.errors?.current_password }}
                </small>
            </div>
           <div class="w-full mb-2">
                <label class="text-xs">New Password</label>
                <Password
                    :class="$page?.props?.errors?.password && 'p-invalid'"
                    class="w-full p-inputtext-sm"
                    v-model="form.password" inputStyle="width:100%"
                    toggleMask
                    aria-describedby="text-error"
                />
                <small
                    v-if="$page?.props?.errors?.password"
                    class="text-xs text-red-400"
                >
                    {{ $page?.props?.errors?.password }}
                </small>
            </div>
            <div class="w-full mb-2">
                <label class="text-xs">Confirm New Password</label>
                <Password
                    :class="
                        $page?.props?.errors?.password_confirmation && 'p-invalid'
                    "
                    class="w-full p-inputtext-sm"
                    v-model="form.password_confirmation" inputStyle="width:100%"
                    toggleMask
                    aria-describedby="text-error"
                />
                <small
                    v-if="$page?.props?.errors?.password_confirmation"
                    class="text-xs text-red-400"
                >
                    {{ $page?.props?.errors?.password_confirmation }}
                </small>
            </div>
            


            <div class="w-full mb-3">
                <button
                    :disabled="processing"
                    @click="updateProfile"
                    class="btn w-full primary"
                >
                    Save
                </button>
            </div>
        </section>
        <div class="w-full flex justify-between text-xs text-neutral-400">
            <Link href="#">Terms and conditions</Link>
            <Link href="#">Privacy policy</Link>
        </div>
    </Dialog>
</template>
