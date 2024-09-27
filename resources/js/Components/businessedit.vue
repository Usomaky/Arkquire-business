<script setup>
import { ref, defineProps, watch, defineEmits } from "vue";
import { Link, router } from "@inertiajs/vue3";
import Dialog from "primevue/dialog";
import InputText from "primevue/inputtext";
import Password from "primevue/password";
import Button from "primevue/button";
import Message from "primevue/message";

</script>

<style scoped>
* {
    font-family: "DM Sans", sans-serif;
}
</style>

<template>
    <Dialog v-model:visible="show"
        modal
        header="Edit Profile"
        :style="{ width: '26rem' }"
        :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">

    <div class="w-full mb-2">
                <label class="text-xs">Description</label>
                <InputText
                class="w-full"
                />
               
            </div>
      <!-- <div class="field">
        <label for="business_name">Business Name </label>
        <input id="business_name" class="input" required />
      </div> -->
      <!-- Add more fields as necessary -->
      <div class="flex justify-end mt-4">
        <button type="submit" class="btn primary">Save</button>
        <button type="button" @click="closeDialog" class="btn secondary">Cancel</button>
        </div>
         </Dialog>
</template>

<!-- 
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
                <label class="text-xs">Fullname</label>
                <InputText
                    :class="$page?.props?.errors?.fullname && 'p-invalid'"
                    class="w-full"
                    v-model="form.fullname"
                    size="small"
                />
                <small
                    v-if="$page?.props?.errors?.fullname"
                    class="text-xs text-red-400"
                >
                    {{ $page?.props?.errors?.fullname }}
                </small>
            </div>
            <div class="w-full mb-2">
                <label class="text-xs">Phone</label>
                <InputText
                    :class="$page?.props?.errors?.phone && 'p-invalid'"
                    class="w-full"
                    v-model="form.phone"
                    size="small"
                />
                <small
                    v-if="$page?.props?.errors?.phone"
                    class="text-xs text-red-400"
                >
                    {{ $page?.props?.errors?.phone }}
                </small>
            </div>

             <div class="w-full mb-2">
                <label class="text-xs"> Current Password</label>
                <Password
                    :class="$page?.props?.errors?.current_password && 'p-invalid'"
                    class="w-full p-inputtext-sm"
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
    </Dialog> -->