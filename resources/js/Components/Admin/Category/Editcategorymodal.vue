<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import { Link, router } from "@inertiajs/vue3";

const props = defineProps(["form"]);
const emit = defineEmits(["close"]);

const handleSubmit = () => {
    router.put(
        `category/${props.form.id}`,
        {
            category_name: props.form.category_name,
        },
        {
            onSuccess: () => {
                close();
                window.location.reload();
            },
        }
    );
};

const close = () => {
    emit("close");
};
</script>

<template>
    <div class="fixed z-10 inset-0 overflow-y-auto">
        <div
            class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0"
        >
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span
                class="hidden sm:inline-block sm:align-middle sm:h-screen"
                aria-hidden="true"
                >​</span
            >
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            >
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left"
                        >
                            <h3
                                class="text-lg leading-6 font-medium text-gray-900"
                                id="modal-title"
                            >
                                Edit Category
                            </h3>
                            <div class="mt-2">
                                <form @submit.prevent="handleSubmit">
                                    <div class="w-full mb-2">
                                        <label class="text-xs"
                                            >Category Name</label
                                        >
                                        <InputText
                                            class="w-full"
                                            v-model="props.form.category_name"
                                            size="small"
                                            type="text"
                                            name="name"
                                            id="name"
                                        />
                                    </div>
                                    <div class="mt-4">
                                        <Button
                                            type="submit"
                                            label="Save"
                                            class="px-4 py-2 bg-blue-600 text-white rounded-md"
                                        />
                                        <Button
                                            type="button"
                                            label="Cancel"
                                            @click="close"
                                            class="ml-2 px-4 py-2 bg-gray-600 text-white rounded-md"
                                        />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
