<script setup>
import { defineProps } from 'vue';
import Paginate from '../Components/Paginate.vue';

const props = defineProps({
    record: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <div class="w-full md:max-h-[30rem] overflow-auto scrollbar-hide lg:scrollbar-default rounded-lg border">
        <table class="tbl">
            <thead>
                <slot name="head"/>
            </thead>
            <tbody>
                <slot name="body"/>
            </tbody>
        </table>
    </div>

    <div v-show="!record || record.length === 0" class="card col-span-12 min-h-[4rem] flex justify-center items-center border-x border-b rounded-lg">
        <p class="text-sm text-center text-slate-600">
            No data yet...
        </p>
    </div>

    <div v-show="record && record.length > 0" class="flex col-span-12 overflow-auto scrollbar-hide md:scrollbar-default md:justify-end">
        <Paginate :links="record.links"/>
    </div>
</template>
