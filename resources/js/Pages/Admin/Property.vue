<script setup>
import { defineOptions, ref, onMounted } from "vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import layout from "../../Layouts/Admin/Dashboard/Index.vue";
import CreatepropertyModal from "../../Components/Admin/Property/Createpropertymodal.vue";
import EditpropertyModal from "../../Components/Admin/Property/Editpropertymodal.vue";
import { Link, router } from "@inertiajs/vue3";

defineOptions({
    layout,
});

const { properties } = usePage().props;
const showModal = ref(false);
const showEditModal = ref(false);

const form = useForm({
    id: null,
    property_name: "",
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

const handleEdit = (property) => {
    form.id = property.id;
    form.property_name = property.property_name;
    isEditing.value = true;
    openEditModal();
};

const handleDelete = (id) => {
    if (confirm("Are you sure you want to delete this property?")) {
        router.delete(`/admin/property/${id}`, {
            onSuccess: () => window.location.reload(),
        });
    }
};

const handleDisable = (id) => {
    if (confirm("Are you sure you want to disable this property?")) {
        router.put(`/admin/property/disable/${id}`, {
            onSuccess: () => window.location.reload(),
        });
    }
};
const handleEnable = (id) => {
    if (confirm("Are you sure you want to enable this property?")) {
        router.put(`/admin/property/enable/${id}`);
    }
};
</script>

<template>
    <Head>
        <title>properties</title>
    </Head>
    <h1 class="text-neutral-800">Property Management</h1>
    <div class="mt-4">
        <button
            @click="openModal"
            class="px-4 py-2 bg-blue-600 text-white rounded-md"
        >
            Create Property
        </button>
    </div>
    <div class="mt-8">
        <h2 class="text-lg font-medium text-gray-900">Property List</h2>
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
                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="(property, index) in properties" :key="property.id">
                    <td class="px-6 py-4 whitespace-nowrap">{{ index + 1 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ property.property_name }}
                    </td>
                    <td
                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                    >
                        <button
                            @click="handleEdit(property)"
                            class="text-indigo-600 hover:text-indigo-900"
                        >
                            Edit
                        </button>
                        <button
                            @click="handleDisable(property.id)"
                            v-if="property.status"
                            class="ml-4 text-yellow-600 hover:text-yellow-900"
                        >
                            Disable
                        </button>
                        <button
                            @click="handleEnable(property.id)"
                            v-if="!property.status"
                            class="ml-4 text-green-600 hover:text-green-900"
                        >
                            Enable
                        </button>
                        <button
                            @click="handleDelete(property.id)"
                            class="ml-4 text-red-600 hover:text-red-900"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <CreatepropertyModal v-if="showModal" @close="closeModal" />
    <EditpropertyModal
        v-if="showEditModal"
        :form="form"
        @close="closeEditModal"
    />
</template>
