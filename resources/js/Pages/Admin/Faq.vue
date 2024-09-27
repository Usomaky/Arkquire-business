<script setup>
import { defineOptions, ref, onMounted } from "vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import layout from "../../Layouts/Admin/Dashboard/Index.vue";
import CreatecategoryModal from "../../Components/Admin/Category/Createcategorymodal.vue";
import EditcategoryModal from "../../Components/Admin/Category/Editcategorymodal.vue";
import { Link, router } from "@inertiajs/vue3";

defineOptions({
    layout,
});

const { faqData } = usePage().props;
const showModal = ref(false);
const showEditModal = ref(false);

const form = useForm({
    id: null,
    faq_header: "",
    faq_content: "",
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

const handleEdit = (faq) => {
    form.id = faq.id;
    form.faq_header = faq.faq_header;
    form.faq_content = faq.faq_content;
    isEditing.value = true;
    openEditModal();
};

const handleDelete = (id) => {
    if (confirm("Are you sure you want to delete this faq?")) {
        router.delete(`/admin/faq/${id}`, {
            onSuccess: () => window.location.reload(),
        });
    }
};


</script>

<template>
    <Head>
        <title>Faqs</title>
    </Head>
    <h1 class="text-neutral-800">Faq Management</h1>
    <div class="mt-4">
        <button
            @click="openModal"
            class="px-4 py-2 bg-blue-600 text-white rounded-md"
        >
            Create Faq
        </button>
    </div>
    <div class="mt-8">
        <h2 class="text-lg font-medium text-gray-900">Faq List</h2>
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
                <tr v-for="(faq, index) in faqData" :key="faq.id">
                    
                    <td class="px-6 py-4 whitespace-nowrap">{{ index + 1 }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ faq.faq_header }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ faq.faq_content }}
                    </td>
                    <td
                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                    >
                        <button
                            @click="handleEdit(faq)"
                            class="text-indigo-600 hover:text-indigo-900"
                        >
                            Edit
                        </button>
                         <button
                            @click="handleDelete(faq.id)"
                            class="ml-4 text-red-600 hover:text-red-900"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <CreatecategoryModal v-if="showModal" @close="closeModal" />
    <EditcategoryModal
        v-if="showEditModal"
        :form="form"
        @close="closeEditModal"
    />
</template>
