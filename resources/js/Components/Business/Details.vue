<script setup>
import currency from 'currency.js';
import Galleria from 'primevue/galleria';
import { ref, computed, defineProps, onMounted, watch } from 'vue';
import Message from 'primevue/message';
// import {  } from '@inertiajs/vue3';
import { Link, router, usePage, useForm } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import Textarea from 'primevue/textarea';
import InputText from 'primevue/inputtext';
import InputNumber from "primevue/inputnumber";
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import Login from "../Auth/Login.vue";
import draggable from 'vuedraggable';


import Table from '../../Components/Table.vue';
const formatCurrency = (value) => {
    return currency(value, {separator: ',', symbol: '₦', precision: 0}).format();
}

const showLargeGallery = ref(false);
const showSmallGallery = ref(false);


const responsiveOptions = ref([
    {
        breakpoint: '1500px',
        numVisible: 5,
        showThumbnails: false
    },
    {
        breakpoint: '1024px',
        numVisible: 3
    },
    {
        breakpoint: '768px',
        numVisible: 2
    },
    {
        breakpoint: '560px',
        numVisible: 9,
        containerStyle: 'max-width: 80%'
    }
]);

const calculateAge = (year) => {
    const currentYear = new Date().getFullYear();
    return currentYear - year;
}

const { props } = usePage();
const business = props.business;
const bookmarks = ref(props.bookmarks ? props.bookmarks : []);  // Ensure bookmarks is an array even if undefined
const isBookmarked = computed(() => {
    return bookmarks.value.some(bookmark => bookmark.id === business.id);
});

const authUser = props.auth.user; // Get authenticated user
console.log('Authenticated user:', authUser); // Debugging log
// console.log('Business id:', business_id);

const toggleBookmark = () => {
    if (isBookmarked.value) {
        processing.value = true;
        Inertia.delete(`/bookmarks/${business.id}`, {
            preserveScroll: true,
            onFinish: (res) => {
                // Update the bookmarks array directly
                bookmarks.value = bookmarks.value.filter(bookmark => bookmark.id !== business.id);
                toast.add(
                    { severity: 'success', summary: 'Success', detail: res.props.flash.message, life: 5000 }
                );
            },
            onError: (err) => {
                err?.message &&
                toast.add(
                    { severity: 'error', summary: 'Error', detail: err?.message, life: 20000 }
                );
            }
        });
    } else {
        Inertia.post('/bookmarks', { business_id: business.id }, {
            preserveScroll: true,
            onFinish: (res) => {
                // Update the bookmarks array directly
                bookmarks.value.push(business);
                // alert('Business bookmarked successfully!');
                toast.add(
                    { severity: 'success', summary: 'Success', detail: res.props.flash.message, life: 5000 }
                );
            },
            onError: (err) => {
                alert('Failed to bookmark the business.');
            }
        });
    }
}

// Dialog visibility
const inquiryVisible = ref(false);

const bidVisible = ref(false);

// Form data for sending an inquiry
const processing = ref(false);
const messages = ref([]);
const inquiryForm = ref({
    business_id: business.id || "",
    user_id: authUser ? authUser.id : null,
    message: "",
});

const bidForm = ref({
    // user_id: authUser ? authUser.id : null,
    business_id: business.id || "",
    bid_price: "",
    files: [],
})

const checkForRequiredFields = (timeline) => {
    let errors = 0;
    for (const field of fields.value[timeline]) {
        if (!form[field]) {
            !(field in form.errors) && form.setError(field, "Required field");
            errors++;
        } else {
            if (typeof form[field] === "object") {
                if (Array.isArray(form[field])) {
                    if (form[field]?.length > 0) {
                        field in form.errors && form.clearErrors(field);
                    } else {
                        !(field in form.errors) && form.setError(field, "Required field");
                        errors++;
                    }
                } else {
                    if (form[field]) {
                        field in form.errors && form.clearErrors(field);
                    } else {
                        !(field in form.errors) && form.setError(field, "Required field");
                        errors++;
                    }
                }
            } else {
                field in form.errors && form.clearErrors(field);
            }
        }
    }
    return errors;
};

const validate = () => {
    if (!checkForRequiredFields(currentTimeline.value)) {
        switch (currentTimeline.value) {
            case 0:
            case 1:
                currentTimeline.value++;
                break;
            case 2:
                submit();
                break;
        }
    }
};

// File Handling Functions
const removeFileExtension = (filename) => {
    const lastDotIndex = filename.lastIndexOf(".");
    if (lastDotIndex === -1) {
        return filename; // No extension found
    } else {
        return filename.substring(0, lastDotIndex);
    }
};

const createURL = (file) => {
    return URL.createObjectURL(file);
};

const onFileChange = (e) => {
    const files = e.target.files;
    let key;
    for (const file of files) {
        key = removeFileExtension(file.name);
        if (
            (file.type === "image/png" || file.type === "image/jpeg" || file.type === "application/pdf") &&
            file.size < 3145728 &&
            bidForm.files.length <= 8
        ) {
            bidForm.files.push(file);
        }
    }
};

const deleteFile = (pos) => {
    pos < bidForm.image.length &&
        pos > -1 &&
        bidForm.image.splice(pos, 1);
};

// Watch dialog visibility
watch(
    () => inquiryVisible.value,
    (visible) => {
        inquiryVisible.value = visible;
    }
);
watch(
    () => bidVisible.value,
    (visible) => {
        bidVisible.value = visible;
    }
);

// Send inquiry function
const sendInquiry = () => {
    processing.value = true;

    router.post('/inquiry', inquiryForm.value, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: (res) => {
            // Show success message
            messages.value = [{ severity: 'success', content: res.props.flash?.message, id: Date.now() }];

            // Clear the form message field

            // Clear the success message after a short delay
            setTimeout(() => {
                messages.value = []; // Clear messages
                inquiryForm.value.message = "";
                inquiryVisible.value = false; // Hide the dialog
            }, 2000);

            processing.value = false;
        },
        onError: (err) => {
            if (err?.message) {
                messages.value = [{ severity: 'warn', content: err.message, id: Date.now() }];
            }
            processing.value = false;
        }
    });
};
// place bid function
const placeBid = () => {
    processing.value = true;

    router.post('/bid', bidForm.value, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: (res) => {
            // Show success message
            messages.value = [{ severity: 'success', content: res.props.flash?.message, id: Date.now() }];

            // Clear the form message field

            // Clear the success message after a short delay
            setTimeout(() => {
                messages.value = []; // Clear messages
                bidForm.value.bid_price = "";
                bidForm.value.files = [];
                bidVisible.value = false; // Hide the dialog
            }, 2000);

            processing.value = false;
        },
        onError: (err) => {
            if (err?.message) {
                messages.value = [{ severity: 'warn', content: err.message, id: Date.now() }];
            }
            processing.value = false;
        }
    });
};



// login modal
const loginVisible = ref(false);

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
    <section class="items-center justify-between hidden w-full py-6 border-b wrapper md:flex">
        <Message v-if="successMessage" severity="success" class="mt-4">
            {{ successMessage }}
        </Message>
        <div>
            <p class="text-lg text-neutral-700">About business</p>
        </div>
        <div class="flex items-center gap-6">
            <template v-if="$page.props.business?.transaction_type.toLowerCase() == 'auction'">
                <p class="text-sm font-medium text-neutral-700">Current bid: <span class="font-light tracking-wide">{{ $page.props.business?.bid > 0 ? formatCurrency($page.props.business?.bid) : formatCurrency($page.props.business?.price) }}</span></p>
                <p class="text-sm font-medium text-neutral-700">Starting bid: <span class="font-light tracking-wide">{{ formatCurrency($page.props.business?.price) }}</span></p>
            </template>
            <template v-else>
                <p class="text-sm font-medium text-neutral-700">Asking price: <span class="font-light tracking-wide">{{ formatCurrency($page.props.business?.price) }}</span></p>
            </template>
            <p class="text-sm font-medium text-neutral-700">Views: <span class="font-light">{{ $page.props.business?.views }}</span></p>
            <p class="text-sm font-medium text-neutral-700">Watchers: <span class="font-light">{{ $page.props.business?.watchers?.length }}</span></p>
        </div>
    </section>
    <section class="grid w-full grid-cols-12 py-4 my-4 gap-y-8 wrapper font-body lg:gap-16">
        <!-- Left -->
        <div class="w-full col-span-12 md:col-span-7 lg:col-span-8 xl:col-span-9 min-h-[7rem] space-y-6">
            <small class="text-sm text-neutral-600">{{ $page.props.business?.category?.category_name }}</small>
            <h3 class="text-xl font-semibold font-body md:text-2xl lg:text-3xl">
                {{ $page.props.business?.business_name }}
            </h3>

            <!-- Tags -->
            <div class="flex items-center w-full gap-4">
                <span class="flex items-center justify-center px-3 py-1 text-sm border rounded-full text-neutral-600">
                    On {{$page.props.business?.transaction_type}}
                </span>
            </div>

            <!-- Basic properties -->
            <div class="flex w-full gap-x-8">
                <div class="text-left">
                    <small class="text-xs text-neutral-500">
                        Type
                    </small>
                    <p class="font-medium capitalize text-neutral-700">
                        {{ $page.props.business?.business_type }}
                    </p>
                </div>
                <div class="text-left">
                    <small class="text-xs text-neutral-500">
                        Category
                    </small>
                    <p class="font-medium text-neutral-700">
                        {{ $page.props.business?.category?.category_name }}
                    </p>
                </div>
                <!-- <div class="text-left">
                    <small class="text-xs text-neutral-500">
                       Avg. monthly profit
                    </small>
                    <p class="font-medium text-neutral-700">
                        {{ formatCurrency($page.props.business?.profit) }}
                    </p>
                </div> -->
            </div>

            <!-- Revenue -->
            <div class="flex items-center w-full gap-x-2">
                <p class="text-sm text-neutral-600">Registration number:</p> <span class="">{{ $page.props.business?.business_number }}</span>
            </div>

            <!-- Images large- carousel -->
            <Galleria v-model:visible="showLargeGallery" :value="$page.props.business?.images" :responsiveOptions="responsiveOptions" :numVisible="9" containerStyle="max-width: 70%" :circular="true" :fullScreen="true" :showItemNavigators="true">
                <template #item="slotProps">
                    <img :src="slotProps.item.url" alt="image" style="width: 100%; display: block" />
                </template>
                <template #thumbnail="slotProps">
                    <img :src="slotProps.item.url" alt="image" style="display: block" />
                </template>
            </Galleria>
            <!-- Images small- carousel -->
            <Galleria v-model:visible="showSmallGallery" :value="$page.props.business?.images" :responsiveOptions="responsiveOptions" :numVisible="9" containerStyle="max-width: 85%" :circular="true" :fullScreen="true"  :showThumbnails="true">
                <template #item="slotProps">
                    <img :src="slotProps.item.url" alt="image" style="width: 100%; display: block" />
                </template>
                <template #thumbnail="slotProps">
                    <img :src="slotProps.item.url" alt="image" style="display: block" />
                </template>
            </Galleria>
            <div class="w-full border rounded-lg md:hidden">
                <!-- Image container -->
                <div class="relative w-full">
                    <img class="object-contain w-full rounded-t-lg" :src="$page.props.business?.images[0]?.url" alt="image"/>
                    <button @click="showSmallGallery = true" class="absolute flex items-center gap-1 px-3 py-2 rounded-full bg-primary-100 right-2 bottom-2">
                        <i class="bx bxs-image text-neutral-600"></i>
                        <span class="text-xs">Show all</span>
                    </button>
                </div>

                <!-- Content -->
                <div class="w-full p-2 divide-y">
                    <div class="w-full py-4">
                        <span v-if="$page.props.business?.transaction_type.toLowerCase() == 'auction'" class="text-sm text-neutral-700">Asking price</span>
                        <span v-else class="text-sm text-neutral-700">Asking price</span>
                        <p class="text-lg font-semibold tracking-wide text-neutral-700">{{ formatCurrency($page.props.business?.price) }}</p>
                    </div>
                    <div class="w-full py-4 space-y-4">
                        <button v-if="$page.props.business?.transaction_type.toLowerCase() == 'auction' && authUser" class="w-full btn primary" label="Show" @click="bidVisible = true">
                            Place bid
                        </button>
                        <button v-else-if="$page.props.business?.transaction_type.toLowerCase() !== 'auction' && authUser" class="w-full btn primary" label="Show" @click="inquiryVisible = true">
                            Register interest
                        </button>
                        <button v-else-if="$page.props.business?.transaction_type.toLowerCase() == 'auction' && !authUser" @click="loginVisible = true" class="w-full btn primary">
                            <span>Place bid</span>
                        </button>
                        <button v-else-if="$page.props.business?.transaction_type.toLowerCase() !== 'auction' && !authUser" @click="loginVisible = true" class="w-full btn primary">
                            <span>Register Interest</span>
                        </button>

                        <button class="w-full btn stroke">
                            <i class="mr-1 text-lg bx bx-show"></i>
                            <span>Watch</span>
                        </button>

                        <!-- Toggle Bookmark button -->
                        <button v-if="authUser" @click="toggleBookmark" :class="[isBookmarked ? 'primary' : 'stroke']" class="w-full btn stroke">
                            <i class="mr-1 text-lg bx" :class="[isBookmarked ? 'bx-bookmark-alt text-white' : 'bx-bookmark']"></i>
                            <span :class="[isBookmarked ? 'text-white' : '']">{{ isBookmarked ? 'Unbookmark' : 'Bookmark' }}</span>
                        </button>
                        <button v-else-if="!authUser" @click="loginVisible = true" class="w-full btn stroke">
                            <i class="mr-1 text-lg bx bx-bookmark"></i>
                            <span>Bookmark</span>
                        </button>
                    </div>
                    <!-- <div class="w-full py-4">
                        <button class="btn w-full bg-[#EEF3FF] rounded-full text-[#2B56C7] text-xs">
                            Have a similar business? Get a free valuation
                        </button>
                    </div> -->
                </div>
            </div>

            <!-- Properties -->
            <div class="w-full space-y-4">
                <div class="flex items-stretch w-full border-b last:border-none">
                    <div class="flex items-center justify-center w-8 text-white md:w-10 lg:w-20 bg-primary-400 shrink-0">
                        <i class="bx bx-info-circle"></i>
                    </div>
                    <div class="p-4">
                        <p class="font-semibold text-neutral-700">Description</p>
                        <small class="text-neutral-600">
                            {{ $page.props.business?.description }}
                        </small>
                    </div>
                </div>
                <div class="flex items-stretch w-full border-b last:border-none">
                    <div class="flex items-center justify-center w-8 text-white md:w-10 lg:w-20 bg-primary-400 shrink-0">
                        <i class="bx bx-hash"></i>
                    </div>
                    <div class="p-4">
                        <p class="font-semibold text-neutral-700">Year Business was built</p>
                        <small class="text-neutral-600">
                            {{ $page.props.business?.business_year }}
                        </small>
                    </div>
                </div>
                <div class="flex items-stretch w-full border-b last:border-none">
                    <div class="flex items-center justify-center w-8 text-white md:w-10 lg:w-20 bg-primary-400 shrink-0">
                        <i class="bx bx-hash"></i>
                    </div>
                    <div class="p-4">
                        <p class="font-semibold text-neutral-700">Age</p>
                        <small class="text-neutral-600">
                            {{ calculateAge($page.props.business?.business_year) }} {{ calculateAge($page.props.business?.business_year) > 1 ? 'years' : 'year' }}
                        </small>
                    </div>
                </div>
                <div class="flex items-stretch w-full border-b last:border-none">
                    <div class="flex items-center justify-center w-8 text-white md:w-10 lg:w-20 bg-primary-400 shrink-0">
                        <i class="bx bx-map"></i>
                    </div>
                    <div class="p-4">
                        <p class="font-semibold text-neutral-700">Location</p>
                        <small class="text-neutral-600">
                            {{ $page.props.business?.address }}
                        </small>
                    </div>
                </div>
                <div class="flex items-stretch w-full border-b last:border-none">
                    <div class="flex items-center justify-center w-8 text-white md:w-10 lg:w-20 bg-primary-400 shrink-0">
                        <i class="bx bxs-landmark"></i>
                    </div>
                    <div class="p-4">
                        <p class="font-semibold text-neutral-700">Landmark</p>
                        <small class="text-neutral-600">
                            {{ $page.props.business?.landmark }}
                        </small>
                    </div>
                </div>
                <div class="flex items-stretch w-full border-b last:border-none">
                    <div class="flex items-center justify-center w-8 text-white md:w-10 lg:w-20 bg-primary-400 shrink-0">
                        <i class="bx bx-buildings"></i>
                    </div>
                    <div class="p-4">
                        <p class="font-semibold text-neutral-700">Property</p>
                        <small class="text-neutral-600">
                            {{ $page.props.business?.property_type }}
                        </small>
                    </div>
                </div>
                <div class="flex items-stretch w-full border-b last:border-none">
                    <div class="flex items-center justify-center w-8 text-white md:w-10 lg:w-20 bg-primary-400 shrink-0">
                        <i class="bx bx-user"></i>
                    </div>
                    <div class="p-4">
                        <p class="font-semibold text-neutral-700">Staffs</p>
                        <small class="text-neutral-600">
                            {{ $page.props.business?.staffs }}
                        </small>
                    </div>
                </div>
                <div class="flex items-stretch w-full border-b last:border-none">
                    <div class="flex items-center justify-center w-8 text-white md:w-10 lg:w-20 bg-primary-400 shrink-0">
                        <i class="bx bx-dollar"></i>
                    </div>
                    <div class="p-4">
                        <p class="font-semibold text-neutral-700">Profit margin</p>
                        <small class="text-neutral-600">
                            {{ $page.props.business?.profit_margin }}%
                        </small>
                    </div>
                </div>
                <div class="flex items-stretch w-full border-b last:border-none">
                    <div>

        </div>

                </div>
            </div>

            <div v-if="$page.props.business?.transaction_type.toLowerCase() == 'auction'" class="w-full">
                <p class="mb-2 text-lg font-semibold text-neutral-700">Bid history</p>
                <Table :record="{}">
                    <template #head>
                        <tr>
                            <th>User</th>
                            <th>Bid amount</th>
                            <th>Initial bid</th>
                            <th>Time</th>
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
        </div>

        <!-- Right -->
        <div class="w-full min-h-[7rem] col-span-12 md:col-span-5 lg:col-span-4 xl:col-span-3 space-y-6">

            <!-- Info one -->
            <div class="hidden w-full border rounded-lg md:block">
                <!-- Image container -->
                <div class="relative w-full">
                    <img class="object-contain w-full rounded-t-lg" :src="$page.props.business?.images[0]?.url" alt="image"/>
                    <button @click="showLargeGallery = true" class="absolute flex items-center gap-1 px-3 py-2 rounded-full bg-primary-100 right-2 bottom-2">
                        <i class="bx bxs-image text-neutral-600"></i>
                        <span class="text-xs">Show all</span>
                    </button>
                </div>

                <!-- Content -->
                <div class="w-full px-5 py-3 divide-y">
                    <div class="w-full py-4">
                        <template v-if="$page.props.business?.transaction_type.toLowerCase() == 'auction'">
                            <span class="text-sm text-neutral-700">Current bid</span>
                            <p class="text-lg font-semibold tracking-wide text-neutral-700">{{ $page.props.business?.bid > 0 ? formatCurrency($page.props.business?.bid) : formatCurrency($page.props.business?.price) }}</p>
                        </template>
                        <template v-else>
                            <span class="text-sm text-neutral-700">Asking price</span>
                            <p class="text-lg font-semibold tracking-wide text-neutral-700">{{ formatCurrency($page.props.business?.price) }}</p>
                        </template>
                    </div>
                    <div class="w-full py-4 space-y-4">
                        <button v-if="$page.props.business?.transaction_type.toLowerCase() == 'auction' && authUser" class="w-full btn primary" label="Show" @click="bidVisible = true">
                            Place bid
                        </button>
                        <button v-else-if="$page.props.business?.transaction_type.toLowerCase() !== 'auction' && authUser" class="w-full btn primary" label="Show" @click="inquiryVisible = true">
                            Register interest
                        </button>
                        <button v-else-if="$page.props.business?.transaction_type.toLowerCase() == 'auction' && !authUser" @click="loginVisible = true" class="w-full btn primary">
                            <span>Place bid</span>
                        </button>
                        <button v-else-if="$page.props.business?.transaction_type.toLowerCase() !== 'auction' && !authUser" @click="loginVisible = true" class="w-full btn primary">
                            <span>Register Interest</span>
                        </button>

                        <!-- Inquiry Dialog -->
                        <Dialog v-model:visible="inquiryVisible" modal header="Register Interest" :style="{ width: '26rem' }"
                            :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
                            <div class="w-full mb-3">
                                <Message v-for="msg of messages" :key="msg.id" :severity="msg.severity" class="text-xs">
                                    {{ msg.content }}
                                </Message>
                            </div>

                            <div class="w-full mb-2">
                                <!-- <label class="text-xs">Business Id</label> -->
                                <InputText class="w-full" v-model="inquiryForm.business_id" size="small" type="hidden" />
                                <small v-if="$page?.props?.errors?.business_id" class="text-xs text-red-400">
                                    {{ $page?.props?.errors?.business_id }}
                                </small>
                            </div>

                            <div class="w-full mb-2">
                                <!-- <label class="text-xs">User Id</label> -->
                                <InputText class="w-full" v-model="inquiryForm.user_id" size="small" type="hidden" />
                                <small v-if="$page?.props?.errors?.user_id" class="text-xs text-red-400">
                                    {{ $page?.props?.errors?.user_id }}
                                </small>
                            </div>

                            <div class="w-full mb-2">
                                <label class="text-xs">Send a message</label>
                                <Textarea v-model="inquiryForm.message" class="w-full p-inputtext-sm" rows="4" autoResize />
                                <small v-if="$page?.props?.errors?.message" class="text-xs text-red-400">
                                    {{ $page?.props?.errors?.message }}
                                </small>
                            </div>

                            <div class="w-full mb-3">
                                <button :disabled="processing" @click="sendInquiry" class="w-full btn primary">
                                    Send Inquiry
                                </button>
                            </div>
                        </Dialog>

                        <!-- place bid dialog -->
                        <Dialog v-model:visible="bidVisible" modal header="Place Bid" :style="{ width: '26rem' }" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
                            <div class="w-full mb-3">
                                <Message v-for="msg of messages" :key="msg.id" :severity="msg.severity" class="text-xs">
                                    {{ msg.content }}
                                </Message>
                            </div>

                            <!-- File Upload Section -->
                            <!-- <div class="w-full mb-3">
                                <label class="text-xs">Upload Files (PNG, JPG, PDF)</label>
                                <input type="file" multiple @change="onFileChange" accept="image/png, image/jpeg, application/pdf" />
                                <div v-if="bidForm.files.length">
                                    <div v-for="(file, index) in bidForm.files" :key="index">
                                        <div v-if="file.type.startsWith('image/')">
                                            <img :src="createURL(file)" alt="Selected Image" class="preview-image" />
                                        </div>
                                        <div v-else-if="file.type === 'application/pdf'">
                                            <span>PDF: {{ removeFileExtension(file.name) }}</span>
                                        </div>
                                        <button @click="deleteFile(index)">Remove</button>
                                    </div>
                                </div>
                            </div> -->

                            <div class="w-full mb-8">
                                <label class="text-xs">Upload Bank Statement</label>
                                <div
                                    class="flex items-center w-full gap-2 my-2 overflow-auto md:gap-3 scrollbar-hide"
                                >
                                    <label
                                        for="file"
                                        class="flex items-center justify-center w-16 h-16 border border-dashed rounded-lg cursor-pointer shrink-0"
                                    >
                                        <i
                                            class="text-xl bx bx-plus text-neutral-600"
                                        ></i>
                                    </label>
                                    <input
                                        class="hidden"
                                        id="file"
                                        type="file"
                                        @change="
                                            onFileChange($event);
                                            'files' in bidForm.errors &&
                                                bidForm.clearErrors('files');
                                        "
                                        multiple
                                        accept="image/png, image/jpeg, application/pdf"
                                    />
                                    <draggable
                                        class="flex items-center gap-2 md:gap-3"
                                        tag="div"
                                        v-model="bidForm.bid_price"
                                        item-key="name"
                                    >
                                        <template
                                            #item="{ element: file, index: key }"
                                        >
                                            <div
                                                :style="`background-image: url(${file.type.startsWith('image') ? createURL(file) : '/pdf-icon.png'});`"
                                                class="relative flex-shrink-0 w-16 h-16 bg-center bg-no-repeat bg-cover rounded-lg group lg:cursor-grab bg-primary-100"
                                            >
                                                <div
                                                    @click="deleteFile(key)"
                                                    class="absolute flex items-center justify-center w-6 h-6 text-white rounded-full cursor-pointer lg:hidden bg-black/50 right-2 top-2 lg:group-hover:flex"
                                                >
                                                    <i
                                                        class="text-lg pointer-events-none bx bx-trash"
                                                    ></i>
                                                </div>
                                                <div
                                                    v-if="key === 0"
                                                    class="p-1 text-[10px] lg:text-xs bg-primary-400 text-white absolute bottom-0 left-0 rounded-tr-lg rounded-bl-lg"
                                                >
                                                    1
                                                </div>
                                                <div
                                                    class="w-5 h-5 p-1 flex justify-center items-center text-[10px] lg:text-xs bg-black/50 text-white absolute bottom-1 right-1 rounded-full"
                                                >
                                                    {{ key + 1 }}
                                                </div>
                                            </div>
                                        </template>
                                    </draggable>
                                </div>
                                <p class="text-sm tracking-wide text-neutral-600">
                                    <small
                                        >.jpg, .png, .pdf, size limit per file: 3MB,
                                        file limit: 8</small
                                    >
                                </p>
                                <!-- <InputText :class="props?.errors?.address && 'p-invalid'" class="w-full" v-model="form.address" size="small"/> -->
                                <small
                                    v-if="bidForm.errors?.files"
                                    class="text-xs text-red-400"
                                >
                                    {{ bidForm.errors?.files }}
                                </small>
                            </div>

                            <!-- Bid Price Input -->
                            <div class="w-full mb-2">
                                <label class="text-xs">Bid Price</label>
                                <!-- <InputText v-model="bidForm.bid_price" type="number" class="w-full p-inputtext-sm" :suffix="bidForm.bid_price > 0 ? 'N' : ''" /> -->
                                <InputNumber
                                    v-model="bidForm.bid_price"
                                    class="w-full p-inputtext-sm" inputId="currency-ng" mode="currency"
                                    currency="NGN" locale="en-NG"
                                />
                                <small v-if="$page?.props?.errors?.bid_price" class="text-xs text-red-400">
                                    {{ $page?.props?.errors?.bid_price }}
                                </small>
                            </div>

                            <!-- Submit Button -->
                            <div class="w-full mb-3">
                                <button :disabled="processing" @click="placeBid" class="w-full btn primary">
                                    Place Bid
                                </button>
                            </div>
                        </Dialog>

                        <button class="w-full btn stroke">
                            <i class="mr-1 text-lg bx bx-show"></i>
                            <span>Watch</span>
                        </button>

                        <!-- Toggle Bookmark button -->
                        <button v-if="authUser" @click="toggleBookmark" :class="[isBookmarked ? 'primary' : 'stroke']" class="w-full btn stroke">
                            <i class="mr-1 text-lg bx" :class="[isBookmarked ? 'bx-bookmark-alt text-white' : 'bx-bookmark']"></i>
                            <span :class="[isBookmarked ? 'text-white' : '']">{{ isBookmarked ? 'Unbookmark' : 'Bookmark' }}</span>
                        </button>

                        <button v-else-if="!authUser" @click="loginVisible = true" class="w-full btn stroke">
                            <i class="mr-1 text-lg bx bx-bookmark"></i>
                            <span>Bookmark</span>
                        </button>
                    </div>
                    <!-- <div class="w-full py-4">
                        <button class="btn w-full bg-[#EEF3FF] rounded-full text-[#2B56C7] text-xs">
                            Have a similar business? Get a free valuation
                        </button>
                    </div> -->
                </div>
            </div>

            <!-- Info two -->
            <div class="w-full p-5 space-y-4 border rounded-lg">
                <p class="text-lg font-semibold tracking-wide text-neutral-800">About the owner</p>
                <div class="flex items-center w-full gap-2">
                    <div class="w-12 h-12 shrink-0">
                        <img class="object-contain w-full rounded-full" :src="$page.props.business?.owner?.avatar" alt="avatar"/>
                    </div>
                    <div class="w-[calc(100%-3rem)]">
                        <p class="flex items-center gap-1">
                            <span class="font-semibold text-neutral-800">{{ $page.props.business?.owner?.fullname }}</span>
                            <i class='text-blue-500 bx bxs-badge-check'></i>
                        </p>
                        <p class="flex items-center" v-if="$page.props.business?.owner?.state && $page.props.business?.owner?.lga">
                            <i class='bx bx-map text-neutral-700'></i>
                            <span class="text-xs text-neutral-800">
                                {{ $page.props.business?.owner?.lga }}, {{ $page.props.business?.owner?.state }}
                            </span>
                        </p>
                    </div>
                </div>
                <div class="w-full text-sm text-neutral-800">
                    {{ $page.props.business?.owner?.bio }}
                </div>
            </div>

            <!-- Info three -->
            <!-- <div class="w-full p-5 space-y-4 border rounded-lg">
                <p class="text-lg font-semibold tracking-wide text-neutral-800">Verification complete</p>
                <div class="w-full space-y-4">
                    <div class="flex items-center w-full gap-2">
                        <i class='text-lg bx bx-check-circle text-primary-500'></i>
                        <p class="text-sm text-neutral-700">Email address</p>
                    </div>
                    <div class="flex items-center w-full gap-2">
                        <i class='text-lg bx bx-check-circle text-primary-500'></i>
                        <p class="text-sm text-neutral-700">Phone number</p>
                    </div>
                    <div class="flex items-center w-full gap-2">
                        <i class='text-lg bx bx-check-circle text-primary-500'></i>
                        <p class="text-sm text-neutral-700">Government issued ID</p>
                    </div>
                </div>
            </div> -->

        </div>
    </section>
    <Inquiry v-model:visible="inquiryVisible" />
    <Login v-model:visible="loginVisible" />
</template>
