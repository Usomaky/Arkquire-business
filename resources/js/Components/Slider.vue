<script setup>
import { Link } from '@inertiajs/vue3';
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel';
import { ref, onMounted, defineOptions, defineProps } from 'vue';
import { usePage } from '@inertiajs/vue3';
import 'vue3-carousel/dist/carousel.css';

const breakpoints = {
    // 768px and up
    850: {
        itemsToShow: 3,
        wrapAround: true
    },
    // 1024 and up
    // 1024: {
    //     itemsToShow: 3,
    //     wrapAround: true
    // },
}

const props = defineProps({
    businesses: Array,
});

const formatPrice = (price) => {
    return price.toLocaleString('en-US');
};

</script>

<style scoped>
.carousel__pagination{
    @apply absolute bottom-2 w-full
}
.carousel__track, .carousel__viewport {
    height: 100%;
}
</style>

<template>
    <section class="w-full wrapper pb-16">
        <p class="text-xs tracking-widest text-neutral-600 uppercase mb-3">
            New Businesses
        </p>
        <Carousel class="w-full overflow-hidden" :itemsToShow="1" :autoplay="2000" :breakpoints="breakpoints" wrapAround>
            <slide class="w-full" v-for="(business, index) in businesses" :key="business.id">
                <Link class="w-full block pr-0 md:pr-3 lg:pr-5 group" :href="`/business/${business?.listing_id}`">
                    <!-- <div class="w-full">
                        <img class="w-full grayscale group-hover:grayscale-0 transition-all duration-300 ease-in-out h-32 border border-neutral-100 rounded-lg group-hover:border-primary-400 object-cover object-center" :src="business?.images[0]?.url" alt="image">
                    </div>
                    <div class="text-left">
                        <p class="text-sm font-bold mt-3 group-hover:text-primary-400">
                            {{ business.business_name }}
                        </p>
                        <p class="text-xs text-neutral-700 mt-1">
                            #{{ formatPrice(business.price) }}
                        </p>
                    </div>

                    <div class="flex justify-between items-center text-xs mt-2">
                        <span class="inline-block capitalize py-1 px-2 rounded-full text-neutral-400 border border-neutral-400">
                            {{ business.transaction_type }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center text-xs mt-2">
                        <span class="inline-block capitalize py-1 px-2 rounded-full text-neutral-400 border border-neutral-400">
                            {{ business.category.category_name }}
                        </span>
                        <span class="opacity-0 group-hover:opacity-100 text-primary-500 transition-opacity duration-300 ease-in">
                            <i class="bx bx-right-arrow-alt text-lg"></i>
                        </span>
                    </div> -->
                     <div class="w-full relative">
                    <img
                        class="w-full object-cover object-center rounded-t-lg"
                        :src="business?.images[0]?.url"
                        alt="image"
                    />
                </div>
                <div class="rounded-b-lg">
                    <p class="text-left text-sm font-bold mt-3 group-hover:text-primary-400">
                            {{ business.business_name }}
                        </p>
                    <div class="flex justify-between">
                        <div class="flex text-xs mt-2">
                            <span
                                class="text-xs capitalize py-1 px-3 rounded-full border border-neutral-200"
                            >
                               <span class="text-black f11">{{ business.category.category_name }}</span>  <br>
                                <span class="tracking-wider f8 flex justify-start">CATEGORY</span>
                            </span>
        
                        </div>

                         <div v-if="business.transaction_type.toLowerCase() == 'auction'" class="flex text-xs mt-2">
                            <span
                                class="f11 text-black inline-block capitalize py-1 px-3 rounded-full border border-neutral-200"
                            >
                               3hrs 57mins left <br>
                               <span class="tracking-widest flex justify-end text-xs text-neutral-500 f8" >{{ business?.bid }} {{ business?.bid > 1 ? 'BIDS' : 'BID' }}</span>
                           
                            </span>
                             
                        </div>
                         <div v-else class="hidden">
                            <span
                                class="f11 text-black inline-block capitalize py-1 px-3 rounded-full border border-neutral-200"
                            >
                               3hrs 57mins left <br>
                               <span class="tracking-widest flex justify-end text-xs text-neutral-500 f8" >{{ business?.bid }} {{ business?.bid > 1 ? 'BIDS' : 'BID' }}</span>
                           
                            </span>
                             
                        </div>
                       
                    </div>
                            <div class="flex justify-between mt-2">

                                <div>
                                    <span
                                class="text-xs inline-block capitalize py-1 px-2 f9"
                            >
                               <span v-if="business.transaction_type.toLowerCase() == 'auction'"  class="flex justify-start">Auction starts at</span>
                               <span v-else-if="business.transaction_type.toLowerCase() == 'sale'"  class="flex justify-start">Sales Price</span>
                               <span v-else-if="business.transaction_type.toLowerCase() == 'investment'"  class="flex justify-start">Investment Amount</span>
                               <span v-else class="flex justify-start">Lease Price</span>
                               <span class="text-sm font-bold">₦ {{ formatPrice(business.price) }}</span>

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
            </slide>
        </Carousel>
    </section>
</template>
