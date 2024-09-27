<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const open = ref(false);

const links = [
    {
        title: 'Dashboard',
        href: '#',
        icon: 'pi-home text-lg',
        page: '/dashboard'
    },
    {
        title: 'Businesses',
        href: 'businesses',
        icon: 'pi-th-large',
        page: '/businesses'
    },
    {
        title: 'Users',
        href: 'users',
        icon: 'pi-users text-lg',
        page: '/users'
    }
];
</script>

<template>
    <!-- Large screens -->
    <aside :class="open ? 'w-[18rem]' : 'w-[6rem]'" class="h-full px-3 py-6 hidden lg:flex flex-col justify-between trans bg-primary-100 relative top-0 z-[31]">
        <section class="w-full flex flex-col items-center">
            <Link href="#" class="w-full max-w-[4.5rem] mb-12">
                <img class="w-full object-contain pointer-events-none" src="/images/logo.svg" alt="logo">
            </Link>

            <button @click="open = !open" :class="open ? 'rotate-180' : 'rotate-0'" class="w-6 h-6 rounded-full bg-primary-400 absolute -right-3 top-8 flex items-center justify-center transition-transform duration-500 ease-linear z-[31] outline-none">
                <i class="bx bx-chevron-right text-lg pointer-events-none text-white"></i>
            </button>

            <div class="w-full flex flex-col gap-y-4">
                <Link :href="link?.href" :class="$page.url === '/admin'+link?.page && 'bg-primary-400/60'" class="w-full h-[3rem] flex items-center rounded-lg hover:bg-primary-400/30 text-neutral-800" v-tooltip="{value: (open ? '' : link?.title), pt:{ text: 'text-xs p-2' }}" v-for="(link, index) in links" :key="index">
                    <div class="w-full max-w-[4.5rem] h-full shrink-0 flex justify-center items-center">
                        <i :class="link?.icon" class="pi"></i>
                    </div>
                    <div :class="!open && 'ml-3 opacity-0 pointer-events-none'" class="flex-1 h-full flex items-center transition-all duration-300 ease-in">
                        {{ link?.title }}
                    </div>
                </Link>
            </div>
        </section>

        <section class="w-full flex flex-col items-center">
            <div class="w-full flex flex-col gap-y-4">
                <Link href="#" class="w-full h-[3rem] flex items-center rounded-lg hover:bg-primary-400/30 text-neutral-800" v-tooltip="{value: (open ? '' : 'Logout'), pt:{ text: 'text-xs p-2' }}">
                    <div class="w-full max-w-[4.5rem] h-full shrink-0 flex justify-center items-center">
                        <i class="pi pi-sign-out"></i>
                    </div>
                    <div :class="!open && 'ml-3 opacity-0 pointer-events-none'" class="flex-1 h-full flex items-center transition-all duration-300 ease-in">
                        Logout
                    </div>
                </Link>
            </div>
        </section>
    </aside>
</template>
