<script setup>
import { defineOptions } from 'vue';
import { Head } from '@inertiajs/vue3';

import moment from 'moment';

import layout from '../Layouts/Client/Dashboard/Index.vue';
import Table from '../Components/Table.vue';

defineOptions({
    layout
});

const formatDate = (value) => {
    return moment(value).format('HH:mma DD/MM/yy');
};
</script>

<template>
    <Head>
        <title>Dashboard</title>
    </Head>
    <div class="w-full">
        <Table :record="{}">
            <template #head>
                <tr>
                    <th>Action</th>
                    <th>Avatar</th>
                    <th>Fullname</th>
                    <th>Points</th>
                    <th>Status</th>
                    <th>Email</th>
                    <th>Batch</th>
                    <th>Registered</th>
                </tr>
            </template>
            <template #body>
                <tr v-for="(user,index) in []" :key="index">
                    <td>
                        <div class="flex items-center gap-2">
                            <button @click="populateData(user)" class="btn-small primary dark:bg-primary-dark">
                                <i class="text-lg text-white bx bx-file"></i>
                            </button>
                            <button @click="selectedUser = user; confirmation.show = true" :disabled="processing" class="bg-red-500 btn-small">
                                <i class="text-lg text-white bx bx-dislike"></i>
                            </button>
                            <button @click="selectedUser = user; manualPoints.show = true" class="btn-small bg-[var(--success)] dark:bg-success-dark">
                                <i class="text-lg text-white bx bxs-bolt"></i>
                            </button>
                            <button @click="selectedUser = user; form.batch_id = user?.batch_id; batch.show = true" class="btn-small bg-slate-600 dark:bg-black/40">
                                <i class="text-lg text-white bx bx-grid"></i>
                            </button>
                        </div>
                    </td>
                    <td>
                        <div class="w-11 h-11">
                            <img class="object-cover w-full rounded-lg" :src="user?.avatar" alt="avatar">
                        </div>
                    </td>
                    <td>{{ user?.fullname }}</td>
                    <!-- <td>
                        <span class="w-6 h-6 bg-[var(--primary)] dark:bg-primary-dark font-semibold text-xs flex justify-center items-center rounded-lg text-white">{{ user?.course_count }}</span>
                    </td> -->
                    <td>
                        <span class="w-6 h-6 bg-[var(--success)] dark:bg-success-dark font-semibold text-xs flex justify-center items-center rounded-lg text-white">{{ user?.course_point }}</span>
                    </td>
                    <td>
                        <span :class="user.status !== 'active' ? 'bg-red-400' : 'bg-[var(--success)] dark:bg-success-dark'" class="flex justify-center w-16 px-2 py-1 text-xs text-white rounded-lg">{{ user.status }}</span>
                    </td>
                    <td>{{ user?.email }} </td>
                    <td>{{ user?.batch ? user?.batch?.uid : 'N/A' }} </td>
                    <td>{{ formatDate(user?.created_at) }}</td>
                </tr>
            </template>
        </Table>
    </div>
</template>
