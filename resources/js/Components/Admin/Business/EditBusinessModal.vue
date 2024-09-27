<template>
  <div
    class="fixed z-10 inset-0 overflow-y-auto"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
  >
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div
        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
        aria-hidden="true"
      ></div>

      <span
        class="hidden sm:inline-block sm:align-middle sm:h-screen"
        aria-hidden="true"
      >&#8203;</span>

      <div
        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
      >
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div
              class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10"
            >
              <svg
                class="h-6 w-6 text-blue-600"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                aria-hidden="true"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M5.121 19.071A7.5 7.5 0 1012 4.5a7.5 7.5 0 00-6.879 14.571zm0 0L3 21l1.929-2.121"
                />
              </svg>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
              <h3
                class="text-lg leading-6 font-medium text-gray-900"
                id="modal-title"
              >
                Edit Business
              </h3>
              <div class="mt-2">
                <form @submit.prevent="submit">
                  <div class="mb-4">
                    <label
                      class="block text-gray-700 text-sm font-bold mb-2"
                      for="business_name"
                    >
                      Business Name
                    </label>
                    <input
                      v-model="form.business_name"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      id="business_name"
                      type="text"
                      placeholder="Business Name"
                    />
                  </div>
                  <div class="mb-4">
                    <label
                      class="block text-gray-700 text-sm font-bold mb-2"
                    >
                      Status
                    </label>
                      <div>
                      <label class="inline-flex items-center">
                        <input
                          type="radio"
                          v-model="form.status"
                          value="review"
                          class="form-radio"
                          id="status-review"
                        />
                        <span class="ml-2">Review</span>
                      </label>
                      <label class="inline-flex items-center ml-4">
                        <input
                        type="radio"
                        v-model="form.status"
                        value="approved"
                        class="form-radio"
      id="status-approved"
    />
    <span class="ml-2">Approved</span>
  </label>
  
  <label class="inline-flex items-center ml-4">
    <input
      type="radio"
      v-model="form.status"
      value="rejected"
      class="form-radio"
      id="status-rejected"
    />
    <span class="ml-2">Rejected</span>
  </label>
  
</div>

                  </div>
                  <div class="mb-4">
                    <label
                      class="block text-gray-700 text-sm font-bold mb-2"
                      for="business_year"
                    >
                      Business Year
                    </label>
                    <input
                      v-model="form.business_year"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      id="business_year"
                      type="text"
                      placeholder="Business Year"
                    />
                  </div>
                  <div class="hidden mb-4">
                    <label
                      class="block text-gray-700 text-sm font-bold mb-2"
                      for="business_type"
                    >
                      Business Type
                    </label>
                    <input
                      v-model="form.business_type"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      id="business_type"
                      type="text"
                      placeholder="Business Type"
                    />
                  </div>
                  <div class="mb-4 hidden">
                    <label
                      class="block text-gray-700 text-sm font-bold mb-2"
                      for="category_id"
                    >
                      Category ID
                    </label>
                    <input
                      v-model="form.category_id"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      id="category_id"
                      type="text"
                      placeholder="Category ID"
                    />
                  </div>
                  <!-- <div class="mb-4">
                    <label
                      class="block text-gray-700 text-sm font-bold mb-2"
                      for="age"
                    >
                      Age
                    </label>
                    <input
                      v-model="form.age"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      id="age"
                      type="text"
                      placeholder="Age"
                    />
                  </div> -->
                  <div class="mb-4">
                    <label
                      class="block text-gray-700 text-sm font-bold mb-2"
                      for="business_number"
                    >
                      Business Number
                    </label>
                    <input
                      v-model="form.business_number"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      id="business_number"
                      type="text"
                      placeholder="Business Number"
                    />
                  </div>
                  <div class="mb-4">
                    <label
                      class="block text-gray-700 text-sm font-bold mb-2"
                      for="description"
                    >
                      Description
                    </label>
                    <textarea
                      v-model="form.description"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      id="description"
                      placeholder="Description"
                    ></textarea>
                  </div>
                  <div class="mb-4">
                    <label
                      class="block text-gray-700 text-sm font-bold mb-2"
                      for="address"
                    >
                      Address
                    </label>
                    <input
                      v-model="form.address"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      id="address"
                      type="text"
                      placeholder="Address"
                    />
                  </div>
                  <div class="mb-4">
                    <label
                      class="block text-gray-700 text-sm font-bold mb-2"
                      for="lga"
                    >
                      LGA
                    </label>
                    <input
                      v-model="form.lga"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      id="lga"
                      type="text"
                      placeholder="lga"
                    />
                  </div>
                  <div class="mb-4">
                    <label
                      class="block text-gray-700 text-sm font-bold mb-2"
                      for="city"
                    >
                      City
                    </label>
                    <input
                      v-model="form.city"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      id="city"
                      type="text"
                      placeholder="city"
                    />
                  </div>
                  <div class="mb-4">
                    <label
                      class="block text-gray-700 text-sm font-bold mb-2"
                      for="state"
                    >
                      State
                    </label>
                    <input
                      v-model="form.state"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      id="state"
                      type="text"
                      placeholder="state"
                    />
                  </div>
                  <div class="mb-4">
                    <label
                      class="block text-gray-700 text-sm font-bold mb-2"
                      for="country"
                    >
                      Country
                    </label>
                    <input
                      v-model="form.country"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      id="country"
                      type="text"
                      placeholder="country"
                    />
                  </div>
                  <div class="mb-4">
                    <label
                      class="block text-gray-700 text-sm font-bold mb-2"
                      for="landmark"
                    >
                      Landmark
                    </label>
                    <input
                      v-model="form.landmark"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      id="landmark"
                      type="text"
                      placeholder="landmark"
                    />
                  </div>
                  <div class="mb-4 hidden">
                    <label
                      class="block text-gray-700 text-sm font-bold mb-2"
                      for="property_type"
                    >
                      Property Type
                    </label>
                    <input
                      v-model="form.property_type"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      id="property_type"
                      type="text"
                      placeholder="Property Type"
                    />
                  </div>
                  <div class="mb-4">
                    <label
                      class="block text-gray-700 text-sm font-bold mb-2"
                      for="staffs"
                    >
                      Staffs
                    </label>
                    <input
                      v-model="form.staffs"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      id="staffs"
                      type="text"
                      placeholder="Staffs"
                    />
                  </div>
                  <div class="mb-4">
                    <label
                      class="block text-gray-700 text-sm font-bold mb-2"
                      for="transaction_type"
                    >
                      Transaction Type
                    </label>
                    <input
                      v-model="form.transaction_type"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      id="transaction_type"
                      type="text"
                      placeholder="Transaction Type"
                    />
                  </div>
                  <div class="mb-4">
                    <label
                      class="block text-gray-700 text-sm font-bold mb-2"
                      for="price"
                    >
                      Price
                    </label>
                    <input
                      v-model="form.price"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      id="price"
                      type="text"
                      placeholder="Price"
                    />
                  </div>
                  <div class="mb-4">
                    <label
                      class="block text-gray-700 text-sm font-bold mb-2"
                      for="profit_margin"
                    >
                      Profit Margin
                    </label>
                    <input
                      v-model="form.profit_margin"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                      id="profit_margin"
                      type="text"
                      placeholder="Profit Margin"
                    />
                  </div>
                  <div class="flex items-center justify-end">
                    <button
                       @click="close"
                      class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                      type="button"
                    >
                      Cancel
                    </button>
                    <button
                      class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-4"
                      type="submit"
                    >
                      Save
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Link, router } from "@inertiajs/vue3";

const props = defineProps({
  form: {
    type: Object,
    required: true,
  },
});
const emit = defineEmits(["close"]);
const close = () => {
    emit("close");
     window.location.reload();
};

const baseUrl = window.location.pathname.split('/')[1]; // Extracts 'admin' or 'super_admin'

const submit = () => {
  // Send a PUT request to update the business
  router.put(`/${baseUrl}/business/${props.form.id}`, props.form, {
    onSuccess: () => {
      close()
    },
  });
};
</script>

<style scoped>
/* Add any custom styles for the modal here */
</style>
