<template>
    <Head>
        <title>Profile</title>
    </Head>
    <section class="w-full">
        <Navbar />
    </section>
    <section class="w-full font-body px-4 xl:px-32 pb-14">
        <div
            class="relative flex flex-col items-center rounded-[20px] mx-auto bg-white bg-clip-border shadow-3xl shadow-shadow-500 dark:!bg-navy-800 dark:text-white dark:!shadow-none p-3"
        >
            <div class="w-full mx-auto py-5 px-5">
                <div
                    class="py-7 px-5 flex flex-col items-center bg-slate-800 rounded-xl border-2 border-slate-900"
                >
                    <img
                        v-if="$page.props.auth?.user?.avatar"
                        :src="$page.props.auth?.user?.avatar"
                        alt="User Avatar"
                        class="h-[70px] w-[70px] rounded-full border-2 border-slate-500 dark:border-gray-800 mx-auto"
                    />

                    <!-- <i class="text-slate-500">
        <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 24 24"><path fill="currentColor" d="M12 11q.825 0 1.413-.588Q14 9.825 14 9t-.587-1.413Q12.825 7 12 7q-.825 0-1.412.587Q10 8.175 10 9q0 .825.588 1.412Q11.175 11 12 11Zm0 2q-1.65 0-2.825-1.175Q8 10.65 8 9q0-1.65 1.175-2.825Q10.35 5 12 5q1.65 0 2.825 1.175Q16 7.35 16 9q0 1.65-1.175 2.825Q13.65 13 12 13Zm0 11q-2.475 0-4.662-.938q-2.188-.937-3.825-2.574Q1.875 18.85.938 16.663Q0 14.475 0 12t.938-4.663q.937-2.187 2.575-3.825Q5.15 1.875 7.338.938Q9.525 0 12 0t4.663.938q2.187.937 3.825 2.574q1.637 1.638 2.574 3.825Q24 9.525 24 12t-.938 4.663q-.937 2.187-2.574 3.825q-1.638 1.637-3.825 2.574Q14.475 24 12 24Zm0-2q1.8 0 3.375-.575T18.25 19.8q-.825-.925-2.425-1.612q-1.6-.688-3.825-.688t-3.825.688q-1.6.687-2.425 1.612q1.3 1.05 2.875 1.625T12 22Zm-7.7-3.6q1.2-1.3 3.225-2.1q2.025-.8 4.475-.8q2.45 0 4.463.8q2.012.8 3.212 2.1q1.1-1.325 1.713-2.95Q22 13.825 22 12q0-2.075-.788-3.887q-.787-1.813-2.15-3.175q-1.362-1.363-3.175-2.151Q14.075 2 12 2q-2.05 0-3.875.787q-1.825.788-3.187 2.151Q3.575 6.3 2.788 8.113Q2 9.925 2 12q0 1.825.6 3.463q.6 1.637 1.7 2.937Z"/></svg>
      </i> -->
                    <div class="mt-4 flex flex-col items-center text">
                        <h1
                            class="text-white text-sm sm:text-lg font-bold capitalize text-center"
                        >
                            {{ $page.props.auth?.user?.fullname }}
                        </h1>
                        <p
                            class="inline-block rounded-full px-4 py-1 border border-red-400 text-center mt-2 text-xs text-red-400"
                        >
                            {{ $page.props.auth?.user?.status }}
                        </p>
                    </div>
                </div>
                <ul class="overflow-x-auto flex gap-5 mt-5">
                    <li
                        class="inline-block min-w-[12rem] w-[12rem] md:w-1/4 border rounded-lg px-3 py-5"
                    >
                        <h3 class="text-xs text-slate-500">Bidded business</h3>
                        <p class="font-bold text-lg md:text-3xl">10</p>
                    </li>
                    <li
                        class="inline-block min-w-[12rem] w-[12rem] md:w-1/4 border rounded-lg px-3 py-5"
                    >
                        <h3 class="text-xs text-slate-500">
                            Purchased businesses
                        </h3>
                        <p class="font-bold text-lg md:text-3xl">10</p>
                    </li>
                    <li
                        class="inline-block min-w-[12rem] w-[12rem] md:w-1/4 border rounded-lg px-3 py-5"
                    >
                        <h3 class="text-xs text-slate-500">
                            Leased businesses
                        </h3>
                        <p class="font-bold text-lg md:text-3xl">10</p>
                    </li>
                    <li
                        class="inline-block min-w-[12rem] w-[12rem] md:w-1/4 border rounded-lg px-3 py-5"
                    >
                        <h3 class="text-xs text-slate-500">
                            Invested business
                        </h3>
                        <p class="font-bold text-lg md:text-3xl">10</p>
                    </li>
                </ul>

                <div class="flex justify-between md:justify-end gap-3 mt-6">
                    <button
                        @click="showProfileEditDialog = true"
                        class="flex-shrink btn primary mb-4"
                    >
                        Edit Profile
                    </button>
                    <ProfileEdit
                        :user="user"
                        :visible="showProfileEditDialog"
                        @update:visible="showProfileEditDialog = $event"
                    />

                    <button
                        @click="showPasswordChangeDialog = true"
                        class="flex-shrink btn primary mb-4"
                    >
                        Change Password
                    </button>
                    <ChangePassword
                        :user="user"
                        :visible="showPasswordChangeDialog"
                        @update:visible="showPasswordChangeDialog = $event"
                    />
                </div>

                <div class="border mt-6 rounded-lg px-5 py-7">
                    <h2 class="font-bold">User profile</h2>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-7">
                        <div>
                            <h3
                                class="text-[0.59rem] uppercase tracking-widest text-slate-500"
                            >
                                Full name
                            </h3>
                            <p class="text-sm">
                                {{ $page.props.auth?.user?.fullname }}
                            </p>
                        </div>
                        <div>
                            <h3
                                class="text-[0.59rem] uppercase tracking-widest text-slate-500"
                            >
                                Email
                            </h3>
                            <p class="text-sm">
                                {{ $page.props.auth?.user?.email }}
                            </p>
                        </div>
                        <div>
                            <h3
                                class="text-[0.59rem] uppercase tracking-widest text-slate-500"
                            >
                                Phone number
                            </h3>
                            <p class="text-sm">
                                {{ $page.props.auth?.user?.phone }}
                            </p>
                        </div>
                        <div>
                            <h3
                                class="text-[0.59rem] uppercase tracking-widest"
                            >
                                State
                            </h3>
                            <p class="text-sm">
                                {{ $page.props.auth?.user?.state }}
                            </p>
                        </div>
                        <div>
                            <h3
                                class="text-[0.59rem] uppercase tracking-widest text-slate-500"
                            >
                                LGA
                            </h3>
                            <p class="text-sm">
                                {{ $page.props.auth?.user?.lga }}
                            </p>
                        </div>
                        <div>
                            <h3
                                class="text-[0.59rem] uppercase tracking-widest text-slate-500"
                            >
                                Bio
                            </h3>
                            <p class="text-sm">
                                {{ $page.props.auth?.user?.bio }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="max-w-sm mx-auto bg-white dark:bg-gray-900 rounded-lg overflow-hidden">
                <div class="px-4 pb-6">
                    <div class="text-center my-4">
                            <img v-if="$page.props.auth?.user?.avatar" :src="$page.props.auth?.user?.avatar" alt="User Avatar" class="h-32 w-32 rounded-full border-4 border-white dark:border-gray-800 mx-auto my-4" />
                        <div class="py-2">
                            <h3 class="font-bold text-2xl text-gray-800 dark:text-white mb-1">{{ $page.props.auth?.user?.fullname }}</h3>
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- <div class="grid sm:grid-cols-2 gap-4 px-2 w-full">
                <div
                    class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="text-base font-medium text-navy-700 dark:text-white">
                        {{ $page.props.auth?.user?.email }}
                    </p>
                </div>

                <div
                    class="flex flex-col sm:items-end justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                    <p class="text-sm text-gray-600">Phone Number</p>
                    <p class="text-base font-medium text-navy-700 dark:text-white">
                        {{ $page.props.auth?.user?.phone }}
                    </p>
                    
                </div>
            </div> -->
            <div class="container mx-auto p-4 flex justify-between gap-[3rem]">
                <!-- <div>
            <button @click="showProfileEditDialog = true" class="btn primary mb-4">Edit Profile</button>
            <ProfileEdit :user="user" :visible="showProfileEditDialog" @update:visible="showProfileEditDialog = $event"/>

        </div>
        <div>
            <button @click="showPasswordChangeDialog = true" class="btn primary mb-4">Change Password</button>
            <ChangePassword :user="user" :visible="showPasswordChangeDialog" @update:visible="showPasswordChangeDialog = $event"/>

        </div> -->
            </div>
        </div>
    </section>

    <section class="w-full">
        <Footer />
    </section>
</template>

<script setup>
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import ProfileEdit from "../Components/Profileedit.vue";
import ChangePassword from "../Components/Changepassword.vue";
import Navbar from "../Components/Navbar.vue";
import Footer from "../Components/Footer.vue";

const showProfileEditDialog = ref(false);
const showPasswordChangeDialog = ref(false);

const { props } = usePage();
const user = ref(props.auth.user);
</script>
