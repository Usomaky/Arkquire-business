<template>
    <Navbar />
    <Header />
    <section class="w-full mt-10 wrapper md:my-15 mb-14">

        <div v-if="localBookmarks.length === 0" class="flex flex-col items-center text-center text-gray-500">
            <h1 class="mb-10 text-2xl text-center sm:text-3xl md:text-5xl text-neutral-800">Bookmarked Businesses</h1>
            <img class="object-contain w-full pointer-events-none opacity-40" src="/images/bookmark_not_found.svg"
                alt="image" style="width: 300px;">
            <span>No bookmarks found.</span>
        </div>
        <div v-else class="flex xl:gap-x-5 md:gap-x-5">

            <!-- left -->
            <div class="w-full space-y-10 lg:w-8/12">

                <h1 class="mb-10 text-2xl sm:text-3xl lg:text-4xl xl:text-5xl text-neutral-800">Bookmarked Businesses</h1>

                <ul>
                    <div class="flex justify-end pb-3">
                        <button v-if="localBookmarks.length > 0" @click="removeAllBookmarks"
                            class="text-xs hover:text-red-600">Remove All
                            Bookmarks</button>
                    </div>
                    <li v-for="bookmark in localBookmarks" :key="bookmark"
                        class="flex flex-col items-end justify-start p-5 mb-3 border rounded-lg lg:items-center lg:justify-between lg:flex-row group">
                        <div class="w-10/12">
                            <Link :href="`/business/` + bookmark.listing_id" class="group-hover:text-green-500">
                            <div class="flex">
                                <img class="object-contain rounded-t-lg" :src="business?.images[0]?.url"
                                    alt="image" />
                                <div class="ml-3">
                                    <span class="group-hover:text-green-500">{{ bookmark.business_name }}</span>
                                    <div class="flex flex-wrap gap-2 my-3">
                                        <div
                                            class="p-2 text-xs bg-gray-100 border rounded-xl group-hover:text-gray-700">
                                            Category:
                                            {{ bookmark.category.category_name }}
                                        </div>
                                        <div
                                            class="p-2 text-xs bg-gray-100 border rounded-xl group-hover:text-gray-700">
                                            Business
                                            type: {{ bookmark.business_type }}
                                        </div>
                                        <div class="p-2 text-xs bg-gray-100 border rounded-xl group-hover:text-gray-700">
                                            Location: {{ bookmark.address }}
                                        </div>
                                        <div class="p-2 text-xs bg-gray-100 border rounded-xl group-hover:text-gray-700">
                                            transaction type: {{ bookmark.transaction_type }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </Link>
                        </div>
                        <button
                            class="p-2 text-xs text-red-500 transition-opacity duration-200 bg-gray-100 rounded-md lg:hidden hover:text-red-700 group-hover:block hover:bg-gray-100 lg:bg-transparent"
                            @click="removeBookmark(bookmark.id)"><span><i class="pi pi-trash"></i></span></button>
                    </li>
                </ul>

            </div>

            <!-- right -->
            <div class="hidden w-full lg:justify-center lg:w-5/12 lg:flex">
                <img class="object-contain w-full pointer-events-none" src="/images/bookmark.svg" alt="image">
            </div>
        </div>
    </section>
    <Footer />

</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import Navbar from '../Components/Navbar.vue';
import Footer from '../Components/Footer.vue';
import Avatar from "primevue/avatar";
import Categories from '../Components/Business/Categories.vue';
import Details from '../Components/Business/Details.vue';

import { onMounted, ref, defineProps, defineOptions, watch, defineEmits } from 'vue';
import Dialog from 'primevue/dialog';
import { Inertia } from '@inertiajs/inertia';
import { router, Link, usePage, useForm } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";

import Services from '../Layouts/Services.vue';
defineOptions({ layout: Services });

// const props = defineProps({
//     business: Object
// });

const toast = useToast();
const props = defineProps({
    visible: {
        type: Boolean,
        default: false,
    },
    bookmarks: {
        type: Array,
        default: () => [], // Ensure default is an empty array
    },
    businesses: {
        type: Array,
        default: () => [], // Ensure default is an empty array
    }
});



const emit = defineEmits(['update:visible']);

//   const show = ref(props.visible);
const localBookmarks = ref([...props.bookmarks]);
const processing = ref(false);
const messages = ref([]);
let count = ref(0);

const goToDetails = (id) => {
    Inertia.visit(`/business/${id}`);
};


const fetchBookmarks = () => {
    Inertia.get('/bookmarks', {}, {
        onSuccess: (page) => {
            localBookmarks.value = page.props.bookmarks || []; // Ensure bookmarks is always an array
        },
        onError: () => {
            showMessage('error', 'Failed to fetch bookmarks.');
        }
    });
};

const removeBookmark = (id) => {
    processing.value = true;
    Inertia.delete(`/bookmarks/${id}`, {
        onFinish: () => {
            localBookmarks.value = localBookmarks.value.filter(bookmark => bookmark.id !== id);
            showMessage('success', 'Bookmark removed successfully.');
            processing.value = false;
        },
        onError: () => {
            showMessage('error', 'Failed to remove bookmark.');
            processing.value = false;
        }
    });
};

const removeAllBookmarks = () => {
    processing.value = true;
    Inertia.delete(`/bookmarks`, {
        onFinish: () => {
            localBookmarks.value = [];
            showMessage('success', 'All bookmarks removed successfully.');
            processing.value = false;
        },
        onError: () => {
            showMessage('error', 'Failed to remove all bookmarks.');
            processing.value = false;
        }
    });
};

const showMessage = (severity, content) => {
    messages.value = [{ severity, content, id: count.value++ }];
};

</script>

<style scoped>
p {
    font-family: "DM Sans", sans-serif;
}
</style>
