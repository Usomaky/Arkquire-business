<script setup>
import { onMounted, defineOptions, defineProps, ref, watch } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import Navbar from "../Components/Navbar.vue";
import Footer from "../Components/Footer.vue";
import Timeliner from "../Components/Timeliner.vue";
import InputText from "primevue/inputtext";
import InputNumber from "primevue/inputnumber";
import Dropdown from "primevue/dropdown";
import Textarea from "primevue/textarea";
import SelectButton from "primevue/selectbutton";
import draggable from "vuedraggable";
import { useToast } from "primevue/usetoast";
import Calendar from "primevue/calendar";

import Services from "../Layouts/Services.vue";
defineOptions({ layout: Services });

const toast = useToast();

const props = defineProps({
    errors: Object,
    transaction_types: Object,
    categories: Object,
    properties: Object,
});

let today = new Date();
let month = today.getMonth();
let year = today.getFullYear();

const minDate = ref(new Date());

minDate.value.setMonth(month);
minDate.value.setFullYear(year);

const timelines = ref([
    { label: "01", description: "Business information" },
    { label: "02", description: "Tell us more about your business" },
    { label: "03", description: "Financial information" },
    { description: "Done" },
]);

const currentTimeline = ref(0);

const fields = ref([
    [
        "business_name",
        "business_year",
        "business_type",
        "category_id",
        "age",
        "business_number",
    ],
    [
        "description",
        "address",
        "lga",
        "city",
        "state",
        "country",
        "landmark",
        "property_id",
        "staffs",
        "photos",
    ],
    ["transaction_type", "price", "profit_margin"],
]);

const combineAndConvertToObj = () => {
    let combinedArray = [];
    combinedArray = fields.value.flatMap((subArray) =>
        combinedArray.concat(subArray)
    );

    // Use reduce to transform the combined array into an object with keys and null values
    const resultObject = combinedArray.reduce((acc, item) => {
        acc[item] = null;
        return acc;
    }, {});

    return resultObject;
};

const form = useForm({
    ...combineAndConvertToObj(),
    ends: null,
    photos: [],
});

watch(
    () => form.transaction_type,
    (value) => {
        if (value?.toLowerCase() === "auction") {
            !fields.value[2]?.includes("ends") && fields.value[2]?.push("ends");
        } else {
            if (fields.value[2]?.includes("ends")) {
                const index = fields.value[2]?.indexOf("ends");
                fields.value[2]?.splice(index, 1);
            }
        }
    }
);

const deleteFile = (pos) => {
    pos < form.value.photos.length &&
        pos > -1 &&
        form.value.photos.splice(pos, 1);
};

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
            (file.type === "image/png" || file.type === "image/jpeg") &&
            file.size < 3145728 &&
            form.photos.length <= 8
        ) {
            form.photos.push(file);
        }
    }
};

const showForm = () => {
    if (form.hasErrors) {
        const keys = Object.keys(form.errors);
        fields.value?.some(function (field, index) {
            // console.log(field, keys);
            if (field?.includes(keys[0])) {
                currentTimeline.value = index;
                toast.add({
                    severity: "error",
                    summary: "Error",
                    detail: "Fields could not be validated!",
                    life: 5000,
                });
                return true;
            }
            return false;
        });
    }
};

const submit = () => {
    form.post("/postbusiness", {
        preserveScroll: true,
        onSuccess: (res) => {
            toast.add({
                severity: "success",
                summary: "Success",
                detail: res.props.flash.message,
                life: 5000,
            });
            form.reset();
            currentTimeline.value = 4;
        },
        onError: (err) => {
            showForm();
            err?.message &&
                toast.add({
                    severity: "error",
                    summary: "Error",
                    detail: err?.message,
                    life: 20000,
                });
        },
    });
};

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
                        !(field in form.errors) &&
                            form.setError(field, "Required field");
                        errors++;
                    }
                } else {
                    if (form[field]) {
                        field in form.errors && form.clearErrors(field);
                    } else {
                        !(field in form.errors) &&
                            form.setError(field, "Required field");
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

// Watch for changes in the business type to toggle address field visibility
// watch(() => form.business_type, (newValue) => {
//     if (newValue === 'digital') {
//      form.lga = form.city = form.state = form.country = null;
//     }
// });
</script>
<style scoped>
.rounded-full {
    border-radius: 6px;
}
</style>

<template>
    <section class="mt-8 px-5 mb-[4rem] w-full font-body xl:px-32 pb-14"> 
        <div class="flex flex-col md:flex-row justify-between gap-[3rem]">
            <div class="flex flex-col justify-between">
                <div class="text-center md:text-left">
                    <h1 class="text-3xl">How can we help today?</h1>
                    <p>Send us a message. We're just a message away.</p>
                </div>
                <div
                    class="hidden md:block relative md:-bottom-[7rem] lg:bottom-[0] right-[10rem] md:right-[7rem]"
                >
                    <img class="" src="/images/contact_leaf.png" alt="" />
                </div>
            </div>
            <div class="md:w-7/12 flex flex-col justify-between">
                <form @submit.prevent="submit" class="">
                    <div class="">
                        <div class="w-full mt-8 mb-4">
                            <label class="text-xs">Name</label>
                            <InputText
                                @input="
                                    'business_name' in form.errors &&
                                        form.clearErrors('business_name')
                                "
                                :class="
                                    form.errors?.business_name && 'p-invalid'
                                "
                                class="w-full text-xs"
                                v-model="form.business_name"
                                size="small"
                                placeholder="Enter name"
                            />
                            <small
                                v-if="form.errors?.business_name"
                                class="text-xs text-red-400"
                            >
                                {{ form.errors?.business_name }}
                            </small>
                        </div>
                        <div class="w-full mb-4">
                            <label class="text-xs"
                                >Email</label
                            >
                            <InputText
                                @input="clearError('business_year')"
                                :class="{
                                    'p-invalid': form.errors?.business_year,
                                }"
                                class="w-full text-xs"
                                v-model="form.business_year"
                                size="small"
                                placeholder="Enter Email"
                            />
                            <small
                                v-if="form.errors?.business_year"
                                class="text-xs text-red-400"
                            >
                                {{ form.errors?.business_year }}
                            </small>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="w-full">
                            <label class="text-xs"
                                >Subject</label
                            >
                            <InputText
                                @input="
                                    'business_number' in form.errors &&
                                        form.clearErrors('business_number')
                                "
                                :class="
                                    form.errors?.business_number && 'p-invalid'
                                "
                                class="w-full"
                                v-model="form.business_number"
                                size="small"
                            />
                            <small
                                v-if="form.errors?.business_number"
                                class="text-xs text-red-400"
                            >
                                {{ form.errors?.business_number }}
                            </small>
                        </div>
                    </div>
                    <section>
                        <div class="w-full mb-4">
                            <label class="text-xs">How can we help?</label>
                            <Textarea
                                @input="
                                    'description' in form.errors &&
                                        form.clearErrors('description')
                                "
                                v-model="form.description"
                                :class="form.errors?.description && 'p-invalid'"
                                class="w-full"
                                rows="4"
                                autoResize
                            />
                            <small
                                v-if="form.errors?.description"
                                class="text-xs text-red-400"
                            >
                                {{ form.errors?.description }}
                            </small>
                        </div>
                    </section>
                    <div class="flex justify-end w-full">
                        <button
                            @click="validate"
                            type="button"
                            class="btn primary"
                        >
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>
