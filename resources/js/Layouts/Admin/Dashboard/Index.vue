<script setup>
import Sidebar from './Sidebar.vue';
import Topbar from './Topbar.vue';
import Toast from 'primevue/toast';
</script>

<template>
    <Toast/>
    <div class="relative flex items-start w-full h-screen">
        <!-- Sidebar -->
        <Sidebar/>
        <div class="w-full h-full lg:w-[calc(100%-6rem)] trans relative">
            <!-- Topbar -->
            <Topbar/>
            <!-- Main content -->
            <main class="w-full h-full max-h-[calc(100%-4rem)] lg:max-h-[calc(100%-5rem)] overflow-auto trans px-4 pt-4 md:px-8 lg:px-16 lg:pt-12">
                <slot/>
            </main>
        </div>
    </div>
</template>
