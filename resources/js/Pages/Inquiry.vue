<template>
    <Navbar />
    <Header />
    <section class="w-full mt-10 wrapper md:my-15 mb-14">

        <h1 class="mb-10 text-2xl text-center sm:text-3xl md:text-5xl text-neutral-800">Inquiries</h1>
        <div v-if="myInquiries.length === 0" class="flex flex-col items-center text-center text-gray-500">
            <img class="object-contain w-full pointer-events-none opacity-40" src="/images/bookmark_not_found.svg"
                alt="image" style="width: 300px;">
            <span>No inquiries found.</span>
        </div>
        <div v-else>
            <div class="w-full">
            <Table :record="inquiries">
                <template #head>
                    <tr>
                        <th>S/N</th>
                        <th>Business</th>
                        <th>Message</th>
                        <th>Action</th>
                    </tr>
                </template>
                <template #body>
                    <tr v-for="(inquiry, index) in inquiries" :key="inquiry.id">
                        <td>{{ index + 1 }}</td>
                        <td><Link :href="`/business/` + inquiry.business.listing_id" class="underline hover:text-green-500">{{ inquiry.business.business_name }}</Link></td>
                        <td>{{ inquiry.message }}</td>

                        <td>Pending</td>
                    </tr>
                </template>
            </Table>
        </div>
        </div>
    </section>
    <Footer />

</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import Navbar from '../Components/Navbar.vue';
import Footer from '../Components/Footer.vue';
import Avatar from "primevue/avatar";
import Categories from '../Components/Business/Categories.vue';
import Details from '../Components/Business/Details.vue';

import { onMounted, ref, defineProps, defineOptions, watch, defineEmits } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { router, Link, usePage, useForm } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";
import Table from '../Components/Table.vue';
import layout from '../Layouts/Admin/Dashboard/Index.vue'

import Services from '../Layouts/Services.vue';
defineOptions({
    layout: Services,
});

const toast = useToast();
const props = defineProps({
    visible: {
        type: Boolean,
        default: false,
    },
    inquiries: {
        type: Array,
        default: () => [], // Ensure default is an empty array
    },
    businesses: {
        type: Array,
        default: () => [], // Ensure default is an empty array
    },
    // business: Object
});

const emit = defineEmits(['update:visible']);

//   const show = ref(props.visible);
const myInquiries = ref([...props.inquiries]);
const processing = ref(false);
const messages = ref([]);
let count = ref(0);

const showMessage = (severity, content) => {
    messages.value = [{ severity, content, id: count.value++ }];
};

console.log(myInquiries.id);

</script>

<style scoped>
p {
    font-family: "DM Sans", sans-serif;
}
</style>
