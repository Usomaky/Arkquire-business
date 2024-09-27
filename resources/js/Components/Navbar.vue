<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import Button from "primevue/button";
import { useToast } from "primevue/usetoast";
import Avatar from "primevue/avatar";
import Menu from "primevue/menu";
import Login from "./Auth/Login.vue";
import Register from "./Auth/Register.vue";

const loginVisible = ref(false);
const registerVisible = ref(false);
const toast = useToast();

const menu = ref();
const items = ref([
    {
        label: "Menu",
        items: [
            {
                label: "Profile",
                icon: "pi pi-user",
                route: "/profile",
                method: "get",
            },
            {
                label: "Bookmarks",
                icon: "pi pi-bookmark",
                route: "/bookmarks",
                method: "get",
            },
            {
                label: "Inquiries",
                icon: "pi pi-question",
                route: "/inquiry",
                method: "get",
            },
            {
                label: "Export",
                icon: "pi pi-upload",
            },
            {
                separator: true,
            },
            {
                label: "Logout",
                icon: "pi pi-sign-out",
                route: "/logout",
                method: "post",
            },
        ],
    },
]);

const toggle = (event) => {
    menu.value.toggle(event);
};

const showMessage = () => {
    toast.add({
        severity: "success",
        summary: "Success Message",
        detail: "Message Content",
        life: 3000,
    });
};
</script>

<template>
    <!-- Topbar -->
    <nav
        class="flex items-center justify-between w-full py-5 border-t-8 wrapper border-primary-400 font-body"
    >
        <div class="w-24 md:w-32">
            <a href="/">

                <img class="w-full" src="/images/arkquire_logo_3.png" alt="logo" />

            </a>
        </div>

        <ul
            class="fixed bottom-0 left-0 z-30 flex items-center justify-around w-full px-3 py-4 text-xs bg-white/80 md:bg-transparent backdrop-blur-md md:backdrop-blur-none md:w-fit gap-x-8 md:text-sm md:static"
        >
            <li>
                <Link
                    :class="
                        $page.url === '/'
                            ? 'border-black'
                            : 'border-transparent text-neutral-400'
                    "
                    class="inline-block pb-2 border-b-4"
                    href="/"
                    >Home</Link
                >
            </li>
            <li>
                <Link
                    :class="
                        $page.url.startsWith('/businesses')
                            ? 'border-black'
                            : 'border-transparent text-neutral-400'
                    "
                    class="inline-block pb-2 border-b-4"
                    href="/businesses"
                    >Businesses</Link
                >
            </li>
            <li>
                <Link
                    :class="
                        $page.url === '/about'
                            ? 'border-black'
                            : 'border-transparent text-neutral-400'
                    "
                    class="inline-block pb-2 border-b-4"
                    href="/about"
                    >About</Link
                >
            </li>
            <li>
                <Link
                    :class="
                        $page.url === '/postbusiness'
                            ? 'border-black'
                            : 'border-transparent text-neutral-400'
                    "
                    class="inline-block pb-2 border-b-4"
                    href="/postbusiness"
                    >Post business</Link
                >
            </li>
        </ul>

        <section class="flex items-center">
            <button
                v-if="$page.props.auth?.user"
                v-ripple
                class="flex items-center gap-2 p-2 rounded-lg outline-none p-ripple hover:bg-primary-100"
            >
                <i v-badge class="text-2xl bx bx-bell p-overlay-badge"></i>
            </button>

            <div
                v-if="$page.props.auth?.user"
                class="w-0 h-6 mx-4 border-l"
            ></div>

            <div v-if="!$page.props.auth?.user" class="flex items-center gap-4">
                <button
                    @click="loginVisible = true"
                    class="font-semibold btn text-primary-500"
                >
                    Login
                </button>
                <button
                    @click="registerVisible = true"
                    class="font-semibold btn bg-primary-500 text-primary-200"
                >
                    Register
                </button>
            </div>
            <button
                v-else
                v-ripple
                class="flex items-center gap-2 p-1 rounded-lg outline-none p-ripple hover:bg-primary-100 md:p-2"
                @click="toggle"
            >
                <Avatar
                    :image="$page.props.auth?.user?.avatar"
                    shape="circle"
                />
                <!-- <Avatar label="T" shape="circle"/> -->
                <p class="hidden text-sm font-medium lg:block">
                    {{ $page.props.auth?.user?.fullname }}
                </p>
            </button>
            <Menu
                ref="menu"
                id="overlay_menu"
                :model="items"
                class="text-sm lg:text-xs"
                :popup="true"
            >
                <template #item="{ item, props }">
                    <Link
                        v-if="item.route"
                        :href="item.route"
                        v-bind="props.action"
                        :method="item.method"
                        as="button"
                        custom
                    >
                        <span :class="item.icon" />
                        <span class="ml-2">{{ item.label }}</span>
                    </Link>
                    <a
                        v-else
                        v-ripple
                        :href="item.url"
                        :target="item.target"
                        v-bind="props.action"
                    >
                        <span :class="item.icon" />
                        <span class="ml-2">{{ item.label }}</span>
                    </a>
                </template>
            </Menu>
        </section>
    </nav>
    <Login v-model:visible="loginVisible" />
    <Register v-model:visible="registerVisible" />
</template>
