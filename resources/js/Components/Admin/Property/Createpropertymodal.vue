<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Link, router } from '@inertiajs/vue3';
import { defineProps, watch, defineEmits } from "vue";
import Dialog from "primevue/dialog";
import InputText from "primevue/inputtext";
import Password from "primevue/password";
import Button from "primevue/button";

const emit = defineEmits(['close']);

const form = useForm({
    property_name: '',
});

const handleSubmit = () => {
    

    const propertyData = {
        property_name: form.property_name,
    };

    router.post('property', propertyData, {
        onSuccess: () => {
            close();
            window.location.reload();
        }
    });
};



const close = () => {
    form.reset();
    emit('close');
};
</script>

<template>
    <div class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Create Property</h3>
                            <div class="mt-2">
                                <form @submit.prevent="handleSubmit">
                                    <!-- <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700">property Name</label>
                                        <input v-model="form.property_name" type="text" name="name" id="name" class="mt-1 block w-full">
                                    </div> -->

                                     <div class="w-full mb-2">
                <label class="text-xs">Property Name</label>
                <InputText
                    class="w-full"
                    v-model="form.property_name"
                    size="small"
                    type="text" name="name" id="name"
                />
            </div>


                                    <div class="mt-4">
                                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Create</button>
                                        <button type="button" @click="close" class="ml-2 px-4 py-2 bg-gray-600 text-white rounded-md">Cancel</button>
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
