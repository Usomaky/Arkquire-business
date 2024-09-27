<script setup>
import { ref, defineProps, watch, defineEmits } from "vue";
import { Link, router } from "@inertiajs/vue3";
import Dialog from "primevue/dialog";
import InputText from "primevue/inputtext";
import Password from "primevue/password";
import Button from "primevue/button";
import Message from "primevue/message";
import Dropdown from "primevue/dropdown";
import InputNumber from "primevue/inputnumber";
import Calendar from "primevue/calendar";

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
        header="Advanced Search"
        :style="{ width: '70rem' }"
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
            <div class="flex flex-col lg:flex-row gap-5">
                <!-- Categories and properties -->
                <div class="w-full lg:w-[300px] space-y-3">
                    <div>
                        <label class="text-black" for="category"
                            >Categories</label
                        >
                        <textarea
                            name="categories"
                            id=""
                            class="w-full border px-4 py-2"
                            placeholder="New Categories"
                            rows="6"
                        ></textarea>
                    </div>
                    <div>
                        <label class="text-black" for="propertytypes"
                            >Property Types</label
                        >
                        <textarea
                            name="Property Types"
                            id=""
                            class="w-full border px-4 py-2"
                            placeholder="New Property"
                            rows="6"
                        ></textarea>
                    </div>
                </div>
                <!-- 2nd part -->
                <div class="w-full lg:w-[43rem] space-y-4">
                    <div class="flex flex-col lg:flex-row gap-4">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <div class="w-full">
                                <label class="text-xs"
                                    >Start of Operations</label
                                >
                                <Dropdown
                                    placeholder="New Category"
                                    class="w-full md:w-14rem p-inputtext-sm"
                                />
                            </div>
                            <div class="w-full">
                                <label class="text-xs"
                                    >Start of Operations</label
                                >
                                <Dropdown
                                    placeholder="New Category"
                                    class="w-full md:w-14rem p-inputtext-sm"
                                />
                            </div>
                        </div>

                        <div class="flex flex-col lg:flex-row gap-4">
                            <div class="w-full">
                                <label class="text-xs"
                                    >Start of Operations</label
                                >
                                <div class="flex space-x-3 items-center">
                                    <InputNumber inputStyle="width:100px" />
                                    <span>to</span>
                                    <InputNumber inputStyle="width:100px" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col lg:flex-row gap-4">
                        <div class="grid grid-cols-1 gap-4">
                            <div class="w-full">
                                <label class="text-xs">Number of Staffs</label>
                                <div class="flex items-center gap-2">
                                    <Calendar
                                        class="w-full"
                                        size="small"
                                        :minDate="minDate"
                                        :manualInput="false"
                                        touchUI
                                    />
                                    <span>to</span>
                                    <Calendar
                                        class="w-full"
                                        size="small"
                                        :minDate="minDate"
                                        :manualInput="false"
                                        touchUI
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col lg:flex-row gap-4">
                            <div class="w-full">
                                <label class="text-xs"
                                    >Number of rooms/units</label
                                >
                                <div class="flex space-x-3 items-center">
                                    <InputNumber
                                        placeholder="Min."
                                        inputStyle="width:100px"
                                    />
                                    <span>to</span>
                                    <InputNumber
                                        placeholder="Max."
                                        inputStyle="width:100px"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col lg:flex-row gap-4">
                        <div class="flex flex-col lg:flex-row gap-4">
                            <div class="w-full">
                                <label class="text-xs"
                                    >Cash flow per month</label
                                >
                                <div class="flex space-x-3 items-center">
                                    <InputNumber
                                        placeholder="Min."
                                        inputStyle="width:80px"
                                    />
                                    <span>to</span>
                                    <InputNumber
                                        placeholder="Max."
                                        inputStyle="width:80px"
                                    />
                                </div>
                            </div>
                            <div class="w-full">
                                <label class="text-xs"
                                    >Date registered on Arkquire</label
                                >
                                <Calendar
                                    class="w-full"
                                    size="small"
                                    :minDate="minDate"
                                    :manualInput="false"
                                    touchUI
                                />
                            </div>
                        </div>

                        <div class="flex flex-col lg:flex-row gap-4">
                            <div class="w-full">
                                <label class="text-xs">Listing ID</label>
                                <div class="flex space-x-3 items-center">
                                    <InputNumber inputStyle="width:240px" />
                                    <!-- <span>to</span>
                                    <InputNumber inputStyle="width:100px" /> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col lg:flex-row gap-4">
                        <div class="flex flex-col lg:flex-row gap-4">
                            <div class="w-full">
                                <label class="text-xs"
                                    >Business sale price range</label
                                >
                                <div class="flex space-x-3 items-center">
                                    <InputNumber
                                        placeholder="Min."
                                        inputStyle="width:85px"
                                    />
                                    <span>to</span>
                                    <InputNumber
                                        placeholder="Max."
                                        inputStyle="width:85px"
                                    />
                                </div>
                            </div>
                            <div class="w-full">
                                <label class="text-xs"
                                    >Business lease price range</label
                                >
                                <div class="flex space-x-3 items-center">
                                    <InputNumber
                                        placeholder="Min."
                                        inputStyle="width:83px"
                                    />
                                    <span>to</span>
                                    <InputNumber
                                        placeholder="Max."
                                        inputStyle="width:83px"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col lg:flex-row gap-4">
                            <div class="w-full">
                                <label class="text-xs">Bidding date</label>
                                <Calendar
                                    placeholder="mm/dd/yy"
                                    class="w-full"
                                    size="small"
                                    :minDate="minDate"
                                    :manualInput="false"
                                    touchUI
                                />
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col lg:flex-row gap-4">
                        <div class="flex flex-col lg:flex-row gap-4">
                            <div class="w-full">
                                <label class="text-xs"
                                    >Bidding rate range</label
                                >
                                <div class="flex space-x-3 items-center">
                                    <InputNumber
                                        placeholder="Min."
                                        inputStyle="width:80px"
                                    />
                                    <span>to</span>
                                    <InputNumber
                                        placeholder="Max."
                                        inputStyle="width:80px"
                                    />
                                </div>
                            </div>
                            <div class="w-full">
                                <label class="text-xs"
                                    >Investment Type</label>

                                <Dropdown class="w-full " placeholder="Shares" />
                            </div>
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>

        <!-- <section>

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
        </section> -->
        <div class="w-full flex justify-between text-xs text-neutral-400">
            <Link href="#">Terms and conditions</Link>
            <Link href="#">Privacy policy</Link>
        </div>
    </Dialog>
</template>
