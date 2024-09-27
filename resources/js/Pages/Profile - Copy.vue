<script setup>
import { onMounted, defineOptions, defineProps, ref, watch } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Navbar from '../Components/Navbar.vue';
import Footer from '../Components/Footer.vue';
import Timeliner from '../Components/Timeliner.vue';
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import Dropdown from 'primevue/dropdown';
import Textarea from 'primevue/textarea';
import SelectButton from 'primevue/selectbutton';
import draggable from 'vuedraggable';
import { useToast } from 'primevue/usetoast';
import Calendar from 'primevue/calendar';
import Services from '../Layouts/Services.vue';

defineOptions({ layout: Services });

const toast = useToast();
const props = defineProps({
    errors: Object,
    transaction_types: Object,
    categories: Object
});

const showPopup = ref(false);
const popupType = ref('');

function openPopup(type) {
    popupType.value = type;
    showPopup.value = true;
}

function closePopup() {
    showPopup.value = false;
}
</script>


<template>
    <Head>
        <title>Profile</title>
    </Head>
    <section class="flex flex-col justify-center items-center h-[100vh]">
        <div
            class="relative flex flex-col items-center rounded-[20px] w-[700px] max-w-[95%] mx-auto bg-white bg-clip-border shadow-3xl shadow-shadow-500 dark:!bg-navy-800 dark:text-white dark:!shadow-none p-3">
            <div class="max-w-sm mx-auto bg-white dark:bg-gray-900 rounded-lg overflow-hidden">
                <div class="px-4 pb-6">
                    <div class="text-center my-4">
                            <img v-if="$page.props.auth?.user?.avatar" :src="$page.props.auth?.user?.avatar" alt="User Avatar" class="h-32 w-32 rounded-full border-4 border-white dark:border-gray-800 mx-auto my-4" />
                        <div class="py-2">
                            <h3 class="font-bold text-2xl text-gray-800 dark:text-white mb-1">{{ $page.props.auth?.user?.fullname }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 px-2 w-full">
                <div
                    class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="text-base font-medium text-navy-700 dark:text-white">
                        {{ $page.props.auth?.user?.email }}
                    </p>
                </div>

                <div
                    class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                    <p class="text-sm text-gray-600">Phone Number</p>
                    <p class="text-base font-medium text-navy-700 dark:text-white">
                        {{ $page.props.auth?.user?.phone }}
                    </p>
                    
                </div>

                <a href="#" class="text-sm flex" @click.prevent="openPopup('editProfile')">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M6.414 16.0001L16.556 5.85808L15.142 4.44408L5 14.5861V16.0001H6.414ZM7.243 18.0001H3V13.7571L14.435 2.32208C14.6225 2.13461 14.8768 2.0293 15.142 2.0293C15.4072 2.0293 15.6615 2.13461 15.849 2.32208L18.678 5.15108C18.8655 5.33861 18.9708 5.59292 18.9708 5.85808C18.9708 6.12325 18.8655 6.37756 18.678 6.56508L7.243 18.0001ZM3 20.0001H21V22.0001H3V20.0001Z"
                            fill="#4ade80" />
                    </svg>
                    &nbsp; Edit Profile
                </a>
                <a href="#" class="text-red-light text-sm flex" @click.prevent="openPopup('changePassword')">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M6.414 16.0001L16.556 5.85808L15.142 4.44408L5 14.5861V16.0001H6.414ZM7.243 18.0001H3V13.7571L14.435 2.32208C14.6225 2.13461 14.8768 2.0293 15.142 2.0293C15.4072 2.0293 15.6615 2.13461 15.849 2.32208L18.678 5.15108C18.8655 5.33861 18.9708 5.59292 18.9708 5.85808C18.9708 6.12325 18.8655 6.37756 18.678 6.56508L7.243 18.0001ZM3 20.0001H21V22.0001H3V20.0001Z"
                            fill="#4ade80" />
                    </svg>
                    &nbsp; Change Password
                </a>
            </div>
        </div>
    </section>
    <div v-if="showPopup"
        class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 transition-opacity duration-300">
        <div class="bg-white p-8 rounded shadow-md max-w-md transform transition-transform duration-300">
            <h1 class="text-2xl font-semibold mb-4">{{ popupType === 'editProfile' ? 'Edit Profile' : 'Change Password' }}
            </h1>
            <form v-if="popupType === 'editProfile'">
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-bold mb-2">Email Address:</label>
                    <input type="email" id="email" name="email" :value="$page.props.auth?.user?.email" class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 font-bold mb-2">Phone Number:</label>
                    <input type="text" id="phone" name="phone" :value="$page.props.auth?.user?.email" class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">Submit</button>
                <button type="button" @click="closePopup"
                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out ml-4">Close</button>
            </form>
            <form v-else>
                <div class="mb-4">
                    <label for="current-password" class="block text-gray-700 font-bold mb-2">Current Password:</label>
                    <input type="password" id="current-password" name="current-password"
                        class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
                <div class="mb-4">
                    <label for="new-password" class="block text-gray-700 font-bold mb-2">New Password:</label>
                    <input type="password" id="new-password" name="new-password"
                        class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">Submit</button>
                <button type="button" @click="closePopup"
                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out ml-4">Close</button>
            </form>
        </div>
    </div>
</template>
