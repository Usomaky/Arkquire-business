<script setup>
import { defineOptions, defineProps, ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import layout from '../../Layouts/Admin/Dashboard/Index.vue';
import Table from '../../Components/Table.vue';
import InputText from 'primevue/inputtext';
import RadioButton from 'primevue/radiobutton';

defineOptions({
    layout
});

// Define props
const props = defineProps({
    users: Array
});

const value2 = ref('');

const updateStatus = (user, newStatus) => {
    // Send request to backend to update status
    router.post(`/super_admin/users/${user.id}/status`, { status: newStatus }, {
        onSuccess: () => {
            // Optionally, you can handle any success actions here
        }
    });
};

const updateType = (user, newType) => {
    // Send request to backend to update status
    router.post(`/super_admin/users/${user.id}/usertype`, { usertype: newType }, {
        onSuccess: () => {
            // Optionally, you can handle any success actions here
        }
    });
};
</script>

<template>
    <Head>
        <title>Users</title>
    </Head>
    <section class="w-full">
        <header class="w-full mb-8">
            <h3 class="text-2xl font-semibold md:text-3xl text-neutral-700">
                Users
            </h3>
        </header>
        <div class="flex items-start justify-end w-full mb-2">
            <span class="p-input-icon-right">
                <i class="pi pi-search" />
                <InputText v-model="value2" placeholder="Search" size="small"/>
            </span>
        </div>
        <div class="w-full">
            <Table :record="users">
                <template #head>
                    <tr>
                        <th>S/N</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>User Type</th>
                        <!-- <th>Created At</th> -->
                        <!-- <th>Updated At</th> -->
                    </tr>
                </template>
                <template #body>
                    <tr v-for="(user, index) in users" :key="user.id">
                        <td>{{ index + 1 }}</td>
                        <td>{{ user.fullname }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.phone }}</td>
                        <td>
                            <div class="flex items-center space-x-2">
                                <RadioButton 
                                    v-model="user.status" 
                                    :value="'active'" 
                                    @change="updateStatus(user, 'active')" 
                                /> Active
                                <RadioButton 
                                    v-model="user.status" 
                                    :value="'disabled'" 
                                    @change="updateStatus(user, 'disabled')" 
                                /> Disabled
                            </div>
                        </td>
                        <td>
                            <div class="flex items-center space-x-2">
                                <RadioButton 
                                    v-model="user.usertype" 
                                    :value="'customer'" 
                                    @change="updateType(user, 'customer')" 
                                /> customer
                                <RadioButton 
                                    v-model="user.usertype" 
                                    :value="'admin'" 
                                    @change="updateType(user, 'admin')" 
                                /> admin
                                <RadioButton 
                                    v-model="user.usertype" 
                                    :value="'super_admin'" 
                                    @change="updateType(user, 'super_admin')" 
                                /> super_admin
                            </div>
                        </td>
                        <!-- <td>{{ user.usertype }}</td> -->
                        <!-- <td>{{ user.created_at }}</td> -->
                        <!-- <td>{{ user.updated_at }}</td> -->
                    </tr>
                </template>
            </Table>
        </div>
    </section>
</template>
