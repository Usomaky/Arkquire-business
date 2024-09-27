<script setup>
import { onMounted, defineOptions, defineProps, ref, watch } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Navbar from '../Components/Navbar.vue';
import Footer from '../Components/Footer.vue';
import Timeliner from '../Components/Timeliner.vue';
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import Dropdown from 'primevue/dropdown';
import Textarea from 'primevue/textarea';
import SelectButton from 'primevue/selectbutton';
import draggable from 'vuedraggable';
import { useToast } from 'primevue/usetoast';
import Calendar from 'primevue/calendar';

import Services from '../Layouts/Services.vue';
defineOptions({ layout: Services });

const toast = useToast();

const props = defineProps({
    errors: Object,
    transaction_types: Object,
    categories: Object
});



let today = new Date();
let month = today.getMonth();
let year = today.getFullYear();

const minDate = ref(new Date());

minDate.value.setMonth(month);
minDate.value.setFullYear(year);

const timelines = ref(
    [
        { label: '01', description: 'Business information' },
        { label: '02', description: 'Tell us more about your business' },
        { label: '03', description: 'Financial information' },
        { description: 'Done' },
    ]
);

const currentTimeline = ref(0);

const fields = ref([
    [
        'business_name','business_year', 'business_type', 'category_id', 'property_id', 'age', 'business_number'
    ],
    [
        'description', 'address', 'lga', 'city', 'state', 'country', 'landmark', 'property_type', 'staffs','photos'
    ],
    [
        'transaction_type', 'price', 'profit_margin'
    ]
]);

const combineAndConvertToObj = () => {
    let combinedArray = [];
    combinedArray = fields.value.flatMap(subArray => combinedArray.concat(subArray));

    // Use reduce to transform the combined array into an object with keys and null values
    const resultObject = combinedArray.reduce((acc, item) => {
        acc[item] = null;
        return acc;
    }, {});

    return resultObject;
}

const form = useForm({
    ...combineAndConvertToObj(),
    ends: null,
    photos: [
    ],
})

watch(
  () => form.transaction_type,
  (value) => {
    if(value?.toLowerCase() === 'auction'){
        !fields.value[2]?.includes('ends') && fields.value[2]?.push('ends');
    }
    else{
        if(fields.value[2]?.includes('ends')){
            const index = fields.value[2]?.indexOf('ends');
            fields.value[2]?.splice(index,1);
        }
    }
  }
)

const deleteFile = (pos) =>{
    (pos < form.value.photos.length && pos > -1) && form.value.photos.splice(pos,1);
}

const removeFileExtension = (filename) => {
    const lastDotIndex = filename.lastIndexOf('.');

    if (lastDotIndex === -1) {
        return filename; // No extension found
    } else {
        return filename.substring(0, lastDotIndex);
    }
}

const createURL = (file) => {
    return URL.createObjectURL(file);
}

const onFileChange = (e) => {
    const files = e.target.files;
    let key;
    for(const file of files){
        key = removeFileExtension(file.name);
        if((file.type === 'image/png' || file.type === 'image/jpeg') && file.size < 3145728 && form.photos.length <= 8){
            form.photos.push(file);
        }
    }
}

const showForm = () => {
    if(form.hasErrors){
        const keys = Object.keys(form.errors);
        fields.value?.some(function(field, index){
            // console.log(field, keys);
            if(field?.includes(keys[0])){
                currentTimeline.value = index;
                toast.add(
                    { severity: 'error', summary: 'Error', detail: 'Fields could not be validated!', life: 5000 }
                );
                return true;
            }
            return false;
        });
    }
}

const submit = () => {
    form.post('/postbusiness', {
        preserveScroll: true,
        onSuccess: (res) => {
            toast.add(
                { severity: 'success', summary: 'Success', detail: res.props.flash.message, life: 5000 }
            );
            form.reset();
            currentTimeline.value = 4;
        },
        onError: (err) => {
            showForm();
            err?.message &&
            toast.add(
                { severity: 'error', summary: 'Error', detail: err?.message, life: 20000 }
            );
        }
    })
}

const checkForRequiredFields = (timeline) => {
    let errors = 0;
    for (const field of fields.value[timeline]) {
        if(!form[field]){
            !(field in form.errors) && form.setError(field, 'Required field');
            errors++;
        }
        else{
            if(typeof form[field] === 'object'){
                if(Array.isArray(form[field])){
                    if(form[field]?.length > 0){
                        field in form.errors && form.clearErrors(field);
                    }
                    else{
                        !(field in form.errors) && form.setError(field, 'Required field');
                        errors++;
                    }
                }
                else{
                    if(form[field]){
                        field in form.errors && form.clearErrors(field);
                    }
                    else{
                        !(field in form.errors) && form.setError(field, 'Required field');
                        errors++;
                    }
                }

            }
            else{
                field in form.errors && form.clearErrors(field);
            }
        }
    }
    return errors;
}

const validate = () => {
    if(!checkForRequiredFields(currentTimeline.value)){
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
}

// Watch for changes in the business type to toggle address field visibility
watch(() => form.business_type, (newValue) => {
    if (newValue === 'digital') {
    form.lga = form.city = form.state = form.country = null;
    }
});

</script>


<style scoped>
*   .hidden {
            display: none;
        }
</style>

<template>
    <Head>
        <title>Post Business</title>
    </Head>
    <section class="w-full bg-[#F7FFFC] font-body">
        <div class="w-full md:min-h-[28rem] pb-4 bg-primary-100">
            <Navbar/>
            <div class="w-full mt-8 space-y-4">
                <h2 class="text-3xl font-semibold text-center md:text-4xl lg:text-5xl font-head">
                    Put business on sale <br/><span class="text-primary-400">with Arkquire</span>
                </h2>
                <p class="text-sm text-center md:text-lg">We will help you cash-in on your business</p>
                <!-- <pre class="text-xs">
                    {{ form }}
                </pre> -->
            </div>
        </div>
        <div class="flex justify-center w-full mb-8">
            <div class="flex justify-center w-full md:relative md:-top-28">
                <form @submit.prevent="submit" class="p-4 md:p-8 w-full min-h-[28rem] max-w-xl bg-white rounded-lg shrink-0 border-b relative">
                    <img src="/images/pattern_leaf.svg" class="w-[20rem] hidden lg:block h-auto rotate-[220deg] opacity-50 absolute -top-48 -left-56" alt="image">
                    <img src="/images/pattern_naira.svg" class="w-[15rem] hidden lg:block h-auto absolute opacity-50 -right-60 -top-48" alt="image">
                    <header class="w-full mb-4">
                        <p class="text-lg font-semibold text-neutral-800">Create your business</p>
                        <small class="block mb-2 text-neutral-700">Kindly provide more information about your business</small>
                        <Timeliner :timelines="timelines" :current="currentTimeline" orientation="horizontal"/>
                        <p class="mt-8 text-sm text-neutral-500">
                            {{ timelines[currentTimeline]?.description == 'Done' ? '' : timelines[currentTimeline]?.description }}
                        </p>
                    </header>
                    <section v-show="currentTimeline === 0">
                      <div class="grid w-full grid-cols-1 gap-2 mb-2 md:grid-cols-2">
                             <div class="w-full mb-2">
                            <label class="text-xs">Business name</label>
                            <InputText @input="'business_name' in form.errors && form.clearErrors('business_name')" :class="(form.errors?.business_name) && 'p-invalid'" class="w-full" v-model="form.business_name" size="small"/>
                            <small v-if="form.errors?.business_name" class="text-xs text-red-400">
                                {{ form.errors?.business_name }}
                            </small>
                        </div>
                        <div class="w-full mb-2">
            <label class="text-xs">Year Business was built</label>
            <InputText @input="clearError('business_year')" 
                       :class="{'p-invalid': form.errors?.business_year}" 
                       class="w-full" 
                       v-model="form.business_year" 
                       size="small" />
            <small v-if="form.errors?.business_year" class="text-xs text-red-400">
                {{ form.errors?.business_year }}
            </small>
        </div>
    
                            <div class="w-full">
                                <label class="text-xs">Business type</label>
                                <Dropdown @change="form.business_type === 'digital' && (form.address = 'Online'); 'business_type' in form.errors && form.clearErrors('business_type')" v-model="form.business_type" :class="(form.errors.business_type) && 'p-invalid'" :options="[{name: 'Digital', value: 'digital'}, {name: 'Physical', value: 'physical'}]" optionLabel="name" optionValue="value" placeholder="" id="businessType" class="w-full md:w-14rem p-inputtext-sm" />
                                <small v-if="form.errors?.business_type" class="text-xs text-red-400">
                                    {{ form.errors?.business_type}}
                                </small>
                            </div>
                            <div class="w-full">
                                <label class="text-xs">Business category</label>
                                <Dropdown @change="'category_id' in form.errors && form.clearErrors('category_id')" v-model="form.category_id" :class="(form.errors?.category_id) && 'p-invalid'" :options="categories" optionLabel="category_name" optionValue="id" placeholder="" class="w-full md:w-14rem p-inputtext-sm" />
                                <small v-if="form.errors?.category_id" class="text-xs text-red-400">
                                    {{ form.errors?.category_id}}
                                </small>
                            </div>
                        </div>
                        <div class="grid w-full grid-cols-1 gap-2 mb-4 md:grid-cols-2">
                            <div class="w-full">
                                <label class="text-xs">Business age</label>
                                <InputNumber :min="1" @input="'age' in form.errors && form.clearErrors('age')" v-model="form.age" :class="(form.errors.age) && 'p-invalid'" class="w-full p-inputtext-sm" inputId="expiry" :suffix="form.age > 1 ? ' years' : ' year'"/>
                                <small v-if="form.errors.age" class="text-xs text-red-400">
                                    {{ form.errors.age }}
                                </small>
                            </div>
                            <div class="w-full">
                                <label class="text-xs">CAC Registration number</label>
                                <InputText @input="'business_number' in form.errors && form.clearErrors('business_number')" :class="(form.errors?.business_number) && 'p-invalid'" class="w-full" v-model="form.business_number" size="small"/>
                                <small v-if="form.errors?.business_number" class="text-xs text-red-400">
                                    {{ form.errors?.business_number }}
                                </small>
                            </div>
                        </div>
                        <div class="flex justify-end w-full">
                            <button @click="validate" type="button" class="btn primary">Continue</button>
                        </div>
                    </section>
                    <section v-show="currentTimeline === 1">
                        <div class="w-full mb-2">
                            <label class="text-xs">Description</label>
                            <Textarea @input="'description' in form.errors && form.clearErrors('description')" v-model="form.description" :class="(form.errors?.description) && 'p-invalid'" class="w-full" rows="2" autoResize/>
                            <small v-if="form.errors?.description" class="text-xs text-red-400">
                                {{ form.errors?.description }}
                            </small>
                        </div>
                        <div class="w-full mb-2">
                            <label class="text-xs">Address of business</label>
                            <InputText @input="'address' in form.errors && form.clearErrors('address')" :class="(form.errors?.address) && 'p-invalid'" class="w-full" v-model="form.address" size="small"/>
                            <small v-if="form.errors?.address" class="text-xs text-red-400">
                                {{ form.errors?.address }}
                            </small>
                        </div>
                        <div v-show="form.business_type !== 'digital'" id="addressFields">
                            <div class="w-full mb-2">
                                <label class="text-xs">LGA</label>
                                <InputText @input="'lga' in form.errors && form.clearErrors('lga')" :class="(form.errors?.lga) && 'p-invalid'" class="w-full" v-model="form.lga" size="small"/>
                                <small v-if="form.errors?.lga" class="text-xs text-red-400">
                                    {{ form.errors?.lga }}
                                </small>
                            </div>
                            <div class="w-full mb-2">
                                <label class="text-xs">City</label>
                                <InputText @input="'city' in form.errors && form.clearErrors('city')" :class="(form.errors?.city) && 'p-invalid'" class="w-full" v-model="form.city" size="small"/>
                                <small v-if="form.errors?.city" class="text-xs text-red-400">
                                    {{ form.errors?.city }}
                                </small>
                            </div>
                            <div class="w-full mb-2">
                                <label class="text-xs">State</label>
                                <InputText @input="'state' in form.errors && form.clearErrors('state')" :class="(form.errors?.state) && 'p-invalid'" class="w-full" v-model="form.state" size="small"/>
                                <small v-if="form.errors?.state" class="text-xs text-red-400">
                                    {{ form.errors?.state }}
                                </small>
                            </div>
                            <div class="w-full mb-2">
                                <label class="text-xs">Country</label>
                                <InputText @input="'country' in form.errors && form.clearErrors('country')" :class="(form.errors?.country) && 'p-invalid'" class="w-full" v-model="form.country" size="small"/>
                                <small v-if="form.errors?.country" class="text-xs text-red-400">
                                    {{ form.errors?.country }}
                                </small>
                            </div>
                            <div class="w-full mb-2">
                                <label class="text-xs">What is the nearest landmark in your business location?</label>
                                <InputText @input="'landmark' in form.errors && form.clearErrors('landmark')" :class="(form.errors?.landmark) && 'p-invalid'" class="w-full" v-model="form.landmark" placeholder="10mins drive from Asaba International Airport" size="small"/>
                                <small v-if="form.errors?.landmark" class="text-xs text-red-400">
                                    {{ form.errors?.landmark }}
                                </small>
                            </div>
                        </div>
                        <div class="grid w-full grid-cols-1 gap-2 mb-2 md:grid-cols-2">
                            <div class="w-full">
                                <label class="text-xs">Property type</label>
                                <Dropdown @change="'property_type' in form.errors && form.clearErrors('property_type')" v-model="form.property_type" :class="(form.errors?.property_type) && 'p-invalid'" :options="['Rented office', 'Shop', 'Workspace', 'None']" placeholder="" class="w-full md:w-14rem p-inputtext-sm" />
                                <small v-if="form.errors?.property_type" class="text-xs text-red-400">
                                    {{ form.errors?.property_type }}
                                </small>
                            </div>
                            <div class="w-full">
                                <label class="text-xs">Business category</label>
                                <Dropdown @change="'property_id' in form.errors && form.clearErrors('property_id')" v-model="form.property_id" :class="(form.errors?.property_id) && 'p-invalid'" :options="properties" optionLabel="property_name" optionValue="id" placeholder="" class="w-full md:w-14rem p-inputtext-sm" />
                                <small v-if="form.errors?.property_id" class="text-xs text-red-400">
                                    {{ form.errors?.property_id}}
                                </small>
                            </div>
                            <div class="w-full">
                                <label class="text-xs">Number of staffs</label>
                                <Dropdown @change="'staffs' in form.errors && form.clearErrors('staffs')" v-model="form.staffs" :class="(form.errors?.staffs) && 'p-invalid'" :options="['1 - 20', '20 - 40', '40 - 60', 'More than 60', 'None']" placeholder="" class="w-full md:w-14rem p-inputtext-sm" />
                                <small v-if="form.errors?.staffs" class="text-xs text-red-400">
                                    {{ form.errors?.staffs }}
                                </small>
                            </div>
                        </div>
                        <div class="w-full mb-8">
                            <label class="text-xs">Photos of business</label>
                            <div class="flex items-center w-full gap-2 my-2 overflow-auto md:gap-3 scrollbar-hide">
                                <label for="file" class="flex items-center justify-center w-16 h-16 border border-dashed rounded-lg cursor-pointer shrink-0">
                                    <i class='text-xl bx bx-plus text-neutral-600'></i>
                                </label>
                                <input class="hidden" id="file" type="file" @change="onFileChange($event); 'photos' in form.errors && form.clearErrors('photos')" multiple accept="image/png, image/jpeg"/>
                                <draggable class="flex items-center gap-2 md:gap-3" tag="div" v-model="form.photos" item-key="name">
                                    <template #item="{ element: image, index: key }">
                                        <div
                                            :style="`background-image: url(${createURL(image)});`"
                                            class="relative flex-shrink-0 w-16 h-16 bg-center bg-no-repeat bg-cover rounded-lg group lg:cursor-grab bg-primary-100"
                                            >
                                            <div @click="deleteFile(key)"
                                                class="absolute flex items-center justify-center w-6 h-6 text-white rounded-full cursor-pointer lg:hidden bg-black/50 right-2 top-2 lg:group-hover:flex"
                                                >
                                                <i class='text-lg pointer-events-none bx bx-trash'></i>
                                            </div>
                                            <div v-if="key === 0"
                                                class="p-1 text-[10px] lg:text-xs bg-primary-400 text-white absolute bottom-0 left-0 rounded-tr-lg rounded-bl-lg"
                                                >
                                                Main
                                            </div>
                                            <div class="w-5 h-5 p-1 flex justify-center items-center text-[10px] lg:text-xs bg-black/50 text-white absolute bottom-1 right-1 rounded-full"
                                                >
                                                {{ key + 1 }}
                                            </div>
                                        </div>
                                    </template>
                                </draggable>
                            </div>
                            <p class="text-sm tracking-wide text-neutral-600"><small>.jpg, .png, size limit per photo: 3MB, photos limit: 8</small></p>
                            <!-- <InputText :class="props?.errors?.address && 'p-invalid'" class="w-full" v-model="form.address" size="small"/> -->
                            <small v-if="form.errors?.photos" class="text-xs text-red-400">
                                {{ form.errors?.photos }}
                            </small>
                        </div>
                        <div class="flex justify-end w-full gap-2">
                            <button @click="currentTimeline--" type="button" class="btn stroke">Back</button>
                            <button @click="validate" type="button" class="btn primary">Continue</button>
                        </div>
                    </section>
                    <section v-show="currentTimeline === 2">
                        <div class="w-full mb-2">
                            <label class="text-xs">Put business up for</label>
                            <SelectButton @change="'transaction_type' in form.errors && form.clearErrors('transaction_type')" v-model="form.transaction_type" :class="(form.errors?.transaction_type) && 'p-invalid'" :options="transaction_types" optionLabel="name" optionValue="value" />
                            <small v-if="form.errors?.transaction_type" class="text-xs text-red-400">
                                {{ form.errors?.transaction_type }}
                            </small>
                        </div>
                        <div v-if="form?.transaction_type?.toLowerCase() === 'auction'" class="w-full mb-2">
                            <label class="text-xs">Auction ends by</label>
                            <Calendar @date-select="'ends' in form.errors && form.clearErrors('ends')" :class="form.errors?.ends && 'p-invalid'" class="w-full lg:hidden" v-model="form.ends" size="small" :minDate="minDate" :manualInput="false" touchUI/>
                            <Calendar @date-select="'ends' in form.errors && form.clearErrors('ends')" :class="form.errors?.ends && 'p-invalid'" class="w-full hidden lg:flex" v-model="form.ends" size="small" :minDate="minDate" :manualInput="false"/>
                            <small v-if="form.errors?.ends" class="text-xs text-red-400">
                                {{ form.errors?.ends }}
                            </small>
                        </div>
                        <div class="w-full mb-2">
                            <label class="text-xs">What is your profit margin ?</label>
                            <InputNumber @input="'profit_margin' in form.errors && form.clearErrors('profit_margin')" v-model="form.profit_margin" :class="(form.errors?.profit_margin) && 'p-invalid'" class="w-full p-inputtext-sm" inputId="minmaxfraction" :minFractionDigits="1" :min="1" :max="100" :maxFractionDigits="2" suffix="%"/>
                            <small v-if="form.errors?.profit_margin" class="text-xs text-red-400">
                                {{ form.errors?.profit_margin }}
                            </small>
                        </div>
                        <div class="w-full mb-8">
                            <label class="text-xs">Set a price</label>
                            <InputNumber @input="'price' in form.errors && form.clearErrors('price')" v-model="form.price" :class="(form.errors?.price) && 'p-invalid'" class="w-full p-inputtext-sm" inputId="currency-ng" mode="currency" currency="NGN" locale="en-NG"/>
                            <small v-if="form.errors?.price" class="text-xs text-red-400">
                                {{ form.errors?.price }}
                            </small>
                        </div>
                        <div class="flex justify-end w-full gap-2">
                            <button @click="currentTimeline--" type="button" class="btn stroke">Back</button>
                            <button :disabled="form.processing" type="button" @click="validate" class="btn primary">Submit</button>
                        </div>
                    </section>
                    <section v-show="currentTimeline > 2">
                        <div class="w-full min-h-[15rem] flex flex-col gap-y-4 items-center justify-center">
                            <div class="w-20">
                                <img class="object-contain w-full" src="/images/tick.png" alt="image"/>
                            </div>
                            <p class="text-center text-neutral-700">
                                Your business has been submitted successfully, but under review. We will notify you once it is approved.
                            </p>
                            <div class="flex items-center justify-center w-full gap-3">
                                <Link href="/" class="btn primary">Go to home</Link>
                                <button @click="currentTimeline = 0" type="button" class="btn stroke">Add another</button>
                            </div>
                        </div>
                    </section>
                </form>
            </div>
        </div>
        <Footer/>
    </section>
</template>
