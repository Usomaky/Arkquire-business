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


const submitForm = () => {
    form.post(route('update.profile'), {
        preserveState: true,
        onSuccess: () => {
            // Optionally show a success message
            toast.success('Profile updated successfully');
            closePopup();
        },
        onError: (errors) => {
            // Handle errors if needed
            console.error(errors);
        },
    });
};

const toast = useToast();
const props = defineProps({
    errors: Object,
    transaction_types: Object,
    categories: Object,
    properties: Object
});

const showPopup = ref(false);
const popupType = ref('');

function openPopup(type) {
    popupType.value = type;
    showPopup.value = true;
}

function closePopup() {
    showPopup.value = false;
}

</script>



<template>
     <Navbar/>
  <div>
    <h1>Edit Profile</h1>
    <form @submit.prevent="updateProfile">
      <div>
        <label for="fullname">Full Name</label>
        <input v-model="form.fullname" id="fullname" type="text" />
        <span v-if="errors.fullname">{{ errors.fullname }}</span>
      </div>
      <div>
        <label for="fullname">Full Name</label>
        <input v-model="form.fullname" id="fullname" type="text" />
        <span v-if="errors.fullname">{{ errors.fullname }}</span>
      </div>

      <div>
        <label for="email">Email</label>
        <input v-model="form.email" id="email" type="email" />
        <span v-if="errors.email">{{ errors.email }}</span>
      </div>

      <div>
        <label for="phone">Phone</label>
        <input v-model="form.phone" id="phone" type="text" />
        <span v-if="errors.phone">{{ errors.phone }}</span>
      </div>

      <div>
        <label for="password">Password (leave blank to keep current password)</label>
        <input v-model="form.password" id="password" type="password" />
        <span v-if="errors.password">{{ errors.password }}</span>
      </div>

      <div>
        <label for="password_confirmation">Confirm Password</label>
        <input v-model="form.password_confirmation" id="password_confirmation" type="password" />
      </div>

      <button type="submit">Save</button>
    </form>

    <div v-if="message">{{ message }}</div>
  </div>
</template>

