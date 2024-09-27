<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import InputText from 'primevue/inputtext';
import Avatar from 'primevue/avatar';
import Menu from 'primevue/menu';

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

const menu = ref();
const items = ref([
    {
        label: 'Menu',
        items: [
            {
                label: 'Profile',
                icon: 'pi pi-user'
            },
            {
                label: 'Export',
                icon: 'pi pi-upload'
            },
            {
                separator: true
            },
            {
                label: 'Logout',
                icon: 'pi pi-sign-out',
                route: '/logout',
                method: 'post'
            },
        ]
    }
]);

const toggle = (event) => {
    menu.value.toggle(event);
};
</script>

<template>
    <!-- Large screens -->
    <nav class="sticky top-0 z-30 items-center justify-between hidden w-full h-20 border-b lg:flex trans md:px-8 lg:px-16 backdrop-blur">
        <!-- Left -->
        <div>
            <InputText type="text" placeholder="Search" size="small"/>
        </div>

        <!-- Right -->
        <div class="flex items-center gap-4">
            <section class="flex items-center">
            <button v-if="$page.props.auth?.user" v-ripple class="flex items-center gap-2 p-2 rounded-lg outline-none p-ripple hover:bg-primary-100">
                <i v-badge class="text-2xl bx bx-bell p-overlay-badge"></i>
            </button>

            <div v-if="$page.props.auth?.user" class="w-0 h-6 mx-4 border-l"></div>

            <div v-if="!$page.props.auth?.user" class="flex items-center gap-4">
                <button @click="loginVisible = true" class="font-semibold btn text-primary-500">Login</button>
                <button @click="registerVisible = true" class="font-semibold btn bg-primary-500 text-primary-200">Register</button>
            </div>
            <button v-else v-ripple class="flex items-center gap-2 p-1 rounded-lg outline-none p-ripple hover:bg-primary-100 md:p-2" @click="toggle">
                <Avatar :image="$page.props.auth?.user?.avatar" shape="circle"/>
                <!-- <Avatar label="T" shape="circle"/> -->
                <p class="hidden text-sm font-medium lg:block">{{ $page.props.auth?.user?.fullname }}</p>
            </button>
            <Menu ref="menu" id="overlay_menu" :model="items" class="text-sm lg:text-xs" :popup="true">
                <template #item="{ item, props }">
                    <Link v-if="item.route" :href="item.route" v-bind="props.action" :method="item.method" as="button" custom>
                        <span :class="item.icon" />
                        <span class="ml-2">{{ item.label }}</span>
                    </Link>
                    <a v-else v-ripple :href="item.url" :target="item.target" v-bind="props.action">
                        <span :class="item.icon" />
                        <span class="ml-2">{{ item.label }}</span>
                    </a>
                </template>
            </Menu>
        </section>
        </div>
    </nav>

    <!-- Small & Medium screens -->
    <nav class="sticky top-0 flex items-center justify-between w-full h-16 px-4 border-b lg:hidden trans backdrop-blur">
        <!-- Menu button -->
        <button @click="open = !open" class="flex items-center justify-center p-2 border rounded-lg">
            <i class="text-2xl bx bx-menu text-neutral-700"></i>
        </button>

        <!-- Notification buttons -->
        <div class="flex items-center gap-4">
            <button v-ripple class="flex items-center gap-2 p-2 rounded-lg outline-none p-ripple hover:bg-primary-100">
                <i v-badge class="text-2xl bx bx-bell bx-tada p-overlay-badge"></i>
            </button>

            <button v-ripple class="flex items-center gap-2 p-1 rounded-lg outline-none p-ripple hover:bg-primary-100 md:p-2" @click="toggle">
                <Avatar :image="$page.props.auth?.user?.avatar" shape="circle"/>
                <!-- <Avatar label="T" shape="circle"/> -->
                <p class="hidden text-sm font-medium lg:block">{{ $page.props.auth?.user?.fullname }}</p>
            </button>

            <Menu ref="menu" id="overlay_menu" :model="items" class="text-sm lg:text-xs" :popup="true">
                <template #item="{ item, props }">
                    <Link v-if="item.route" :href="item.route" v-bind="props.action" :method="item.method" as="button" custom>
                        <span :class="item.icon" />
                        <span class="ml-2">{{ item.label }}</span>
                    </Link>
                    <a v-else v-ripple :href="item.url" :target="item.target" v-bind="props.action">
                        <span :class="item.icon" />
                        <span class="ml-2">{{ item.label }}</span>
                    </a>
                </template>
            </Menu>
        </div>

        <!-- Menu -->
        <aside :class="open ? 'left-0' : '-left-full'" class="w-full h-screen px-3 py-6 flex flex-col justify-between trans bg-primary-100 absolute top-0 z-[31]">
            <section class="flex flex-col items-center w-full">
                <Link href="#" class="w-full max-w-[4.5rem] mb-12">
                    <img class="object-contain w-full pointer-events-none" src="/images/logo.svg" alt="logo">
                </Link>

                <button @click="open = !open" :class="open ? 'rotate-180' : 'rotate-0'" class="w-10 h-10 rounded-lg bg-primary-400 absolute left-6 top-8 flex items-center justify-center transition-transform duration-500 ease-linear z-[31] outline-none">
                    <i class="text-lg text-white pointer-events-none bx bx-chevron-right"></i>
                </button>

                <div class="flex flex-col w-full gap-y-4">
                    <Link :href="link?.href" :class="$page.url === '/admin'+link?.page && 'bg-primary-400/60'" class="w-full h-[3rem] flex items-center rounded-lg hover:bg-primary-400/30 text-neutral-800" v-tooltip="{value: (open ? '' : link?.title), pt:{ text: 'text-xs p-2' }}" v-for="(link, index) in links" :key="index">
                        <div class="w-full max-w-[4.5rem] h-full shrink-0 flex justify-center items-center">
                            <i :class="link?.icon" class="pi"></i>
                        </div>
                        <div :class="!open && 'ml-3 opacity-0 pointer-events-none'" class="flex items-center flex-1 h-full transition-all duration-300 ease-in">
                            {{ link?.title }}
                        </div>
                    </Link>
                </div>
            </section>

            <section class="flex flex-col items-center w-full">
                <div class="flex flex-col w-full gap-y-4">
                    <Link href="#" class="w-full h-[3rem] flex items-center rounded-lg hover:bg-primary-400/30 text-neutral-800" v-tooltip="{value: (open ? '' : 'Logout'), pt:{ text: 'text-xs p-2' }}">
                        <div class="w-full max-w-[4.5rem] h-full shrink-0 flex justify-center items-center">
                            <i class="pi pi-sign-out"></i>
                        </div>
                        <div :class="!open && 'ml-3 opacity-0 pointer-events-none'" class="flex items-center flex-1 h-full transition-all duration-300 ease-in">
                            Logout
                        </div>
                    </Link>
                </div>
            </section>
        </aside>
    </nav>
</template>
