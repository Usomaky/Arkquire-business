<script setup>
import { defineOptions, ref, onMounted } from "vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import layout from "../../Layouts/Admin/Dashboard/Index.vue";
import EditBusinessModal from "../../Components/Admin/Business/EditBusinessModal.vue";
import { Link, router } from "@inertiajs/vue3";

defineOptions({
    layout,
});


const { businesses } = usePage().props;
const showModal = ref(false);
const showEditModal = ref(false);

const form = useForm({
    id: null,
    business_name: "",
    business_year: "",
    business_type: "",
    category_id: "",
    property_id: "",
    age: "",
    business_number: "",
    description: "",
    address: "",
    lga: "",
    city: "",
    state: "",
    country: "",
    landmark: "",
    property_type: "",
    staffs: "",
    photos: [],
    transaction_type: "",
    price: "",
    profit_margin: "",
    business_status: "",
});

const isEditing = ref(false);

const openModal = () => {
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

const openEditModal = () => {
    showEditModal.value = true;
};

const closeEditModal = () => {
    showEditModal.value = false;
};

const handleEdit = (business) => {
    form.id = business.id;
    form.business_name = business.business_name;
    form.status = business.status;
    form.business_year = business.business_year;
    form.business_type = business.business_type;
    form.category_id = business.category_id;
    form.property_id = business.property_id;
    form.age = business.age;
    form.business_number = business.business_number;
    form.description = business.description;
    form.address = business.address;
    form.lga = business.lga;
    form.city = business.city;
    form.state = business.state;
    form.country = business.country;
    form.landmark = business.landmark;
    form.property_type = business.property_type;
    form.staffs = business.staffs;
    form.photos = business.photos;
    form.transaction_type = business.transaction_type;
    form.price = business.price;
    form.profit_margin = business.profit_margin;
    form.business_status = business.business_status;
    isEditing.value = true;
    openEditModal();

    // Applying CSS to hide the first navigation item and the sidebar with a specific class
    document.querySelector('nav.sticky:nth-child(1)').style.display = 'none';
    document.querySelector('aside.h-full').style.display = 'none';
};

const baseUrl = window.location.pathname.split('/')[1]; // Extracts 'admin' or 'super_admin'

const handleDelete = (id) => {
    if (confirm("Are you sure you want to delete this business?")) {
        router.delete(`/${baseUrl}/businesses/${id}`, {
            onSuccess: () => window.location.reload(),
        });
    }
};

const handleDisable = (business) => {
    if (confirm("Are you sure you want to disable this business?")) {
        router.put(`/${baseUrl}/businesses/disable/${business.id}`, {
            onSuccess: () => window.location.reload(),
        });
    }
};

const handleEnable = (business) => {
    if (confirm("Are you sure you want to enable this business?")) {
        router.put(`/${baseUrl}/businesses/enable/${business.id}`, {
            onSuccess: () => window.location.reload(),
        });
    }
};

const toggleStatus = (business) => {
    const newStatus = business.business_status === "sold" ? "unsold" : "sold";
    if (
        confirm(`Are you sure you want to mark this business as ${newStatus}?`)
    ) {
        router.put(
            `/${baseUrl}/businesses/${business.id}/status`,
            { status: newStatus },
            {
                onSuccess: () => window.location.reload(),
            }
        );
    }
};
</script>

<template>
    <Head>
        <title>Businesses</title>
    </Head>
    <h1 class="text-neutral-800">Business Management</h1>
    <div class="mt-4">
        <button 
            class="px-4 py-2 bg-blue-600 text-white rounded-md"
        > <a href="/postbusiness">Create Business</a>
            
        </button>
    </div>
    <div class="mt-8">
        <h2 class="text-lg font-medium text-gray-900">Business List</h2>
        <table class="min-w-full divide-y divide-gray-200 mt-4">
            <thead class="bg-gray-50">
                <tr>
                    <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        S/N
                    </th>
                    <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Name
                    </th>
                    <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Status
                    </th>
                    <th
                        scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Business Status
                    </th>
                    <th
                        scope="col"
                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="(business, index) in businesses" :key="business.id">
                    <td class="px-6 py-4 whitespace-nowrap">{{ index + 1 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ business.business_name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ business.status }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ business.business_status }}
                    </td>
                    <td
                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                    >
                        <button
                            @click="handleEdit(business)"
                            class="text-indigo-600 hover:text-indigo-900"
                        >
                            Edit
                        </button>
                        <button
                            @click="handleDisable(business)"
                            v-if="business.business_state"
                            class="ml-4 text-yellow-600 hover:text-yellow-900"
                        >
                            Disable
                        </button>

                        <button
                            @click="handleEnable(business)"
                            v-if="!business.business_state"
                            class="ml-4 text-green-600 hover:text-green-900"
                        >
                            Enable
                        </button>
                        <button
                            @click="toggleStatus(business)"
                            class="ml-4 text-blue-600 hover:text-blue-900"
                        >
                            Mark as
                            {{ business.business_status === "sold" ? "Unsold" : "Sold" }}
                        </button>
                        <button
                            @click="handleDelete(business.id)"
                            class="ml-4 text-red-600 hover:text-red-900"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- <CreateBusinessModal v-if="showModal" @close="closeModal" /> -->
    <EditBusinessModal
        v-if="showEditModal"
        :form="form"
        @close="closeEditModal"
    />
</template>
