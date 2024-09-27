<script setup>
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';
import currency from 'currency.js';

import Paginate from '../Paginate.vue';

const props = defineProps({
    businesses: Object
});

const formatCurrency = (value) => {
    return currency(value, { separator: ',', symbol: '₦', precision: 0 }).format();
}
</script>

<template>
    <section class="w-full wrapper mt-16">
        <header class="w-full flex items-start justify-between mb-8">
            <div>
                <p class="text-neutral-700 font-semibold text-lg">Available for sale</p>
                <small>
                    These are the list of businesses available on sale
                </small>
            </div>
        </header>
        
        <div
            class="w-full grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-4"
        >
            <Link
                class="w-full block group pr-2 mb-6"
                v-for="(business, index) in businesses?.data"
                :key="index"
                :href="`/business/${business?.listing_id}`"
            >
                <div class="w-full relative">
                    <img
                        class="w-full object-cover object-center rounded-t-lg"
                        :src="business?.images[0]?.url"
                        alt="image"
                    />
                </div>
                <div class="rounded-b-lg">
                    <p class="text-sm font-bold mt-3 group-hover:text-primary-400">
                            {{ business.business_name }}
                        </p>
                    <div class="flex justify-between">
                        <div class="flex text-xs mt-2">
                            <span
                                class="text-xs capitalize py-1 px-3 rounded-full border border-neutral-200"
                            >
                               <span class="text-black f11">{{ business.category.category_name }}</span>  <br>
                                <span class="tracking-wider f8">CATEGORY</span>
                            </span>
        
                        </div>

                         <!-- <div class="flex text-xs mt-2">
                            <span
                                class="f11 text-black inline-block capitalize py-1 px-3 rounded-full border border-neutral-200"
                            >
                               3hrs 57mins left <br>
                               <span class="tracking-widest flex justify-end text-xs text-neutral-500 f8" >{{ business?.bid }} {{ business?.bid > 1 ? 'BIDS' : 'BID' }}</span>
                           
                            </span>
                             
                        </div> -->
                       
                    </div>
                            <div class="flex justify-between mt-2">

                                <div>
                                    <span
                                class="text-xs inline-block capitalize py-1 px-2 f9"
                            >
                               Sales Price
                               <br>
                               <span class="text-sm font-bold">{{ formatCurrency(business?.price) }}</span>

                               
                            </span>
                            
                                </div>
                                
                                
                                <div
                                   class="text-neutral-400 group-hover:text-primary-500 transition-opacity duration-300 ease-in"
                               >
                                   <i class="relative -bottom-[22px] bx bx-right-arrow-alt text-lg"></i>
                               </div>
                            </div>


                </div>
                
            </Link>
        </div>

        <div v-show="businesses?.data?.length > 0" class="w-full mt-4 overflow-auto scrollbar-hide md:scrollbar-default col-span-12 flex md:justify-end">
            <Paginate :links="businesses?.links"/>
        </div>
    </section>
</template>
