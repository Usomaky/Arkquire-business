<script setup>
import { Link } from '@inertiajs/vue3';

import { defineProps } from 'vue';

// Accept categories as a prop
const props = defineProps({
    featuredCategories: Array
});
</script>

<template>
    <section class="mx-4 py-24 wrapper rounded-3xl bg-black shadow-2xl shadow-neutral-600">
         <div>
            <p class="text-xs tracking-widest text-primary-400 mb-2 uppercase">Business categories</p>
            <h2 class="w-full font-Fraunces md:w-8/12 lg:w-5/12 text-4xl font-semibold text-white md:text-6xl"> A slew of business categories to explore </h2>
        </div>
        <div class="w-full grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-x-7 md:gap-y-7 pt-20">
            <Link 
                class="inline-flex group flex-col relative rounded-[10rem] h-80 text-white border overflow-hidden border-white hover:border-primary-400"
                :href="`/category/${category.id}`" 
                v-for="category in featuredCategories" 
                :key="category.id"
            >
            <img class="w-full h-full absolute top-0 left-0 z-0 brightness-50 object-cover object-center group-hover:scale-150 transition-all duration-500 ease-in-out" src="https://imageio.forbes.com/specials-images/imageserve/5d95d03767dd830006a295b6/GETTY/960x0.jpg?format=jpg&amp;width=960" alt="">
                <div class="h-48 z-[5] flex justify-between text-lg px-5 mt-auto pt-4 bg-opacity-70 bg-clip-padding backdrop-blur-md bg-black">
                    <div>
                        <p class="font-semibold text-xs md:text-base">{{ category.category_name }}</p>
                        <!-- <span class="text-xs text-neutral-400">{{ category.business_count }} Businesses</span> -->
                    </div>
                    <span class="text-xl group-hover:text-primary-400"> → </span>
                </div>
            </Link>
            <Link 
                class="inline-flex group flex-col relative rounded-[10rem] h-80 text-white border overflow-hidden border-white hover:border-primary-400"
                href="/businesses"
            >
            <img class="w-full h-full absolute top-0 left-0 z-0 brightness-50 object-cover object-center group-hover:scale-150 transition-all duration-500 ease-in-out" src="https://imageio.forbes.com/specials-images/imageserve/5d95d03767dd830006a295b6/GETTY/960x0.jpg?format=jpg&amp;width=960" alt="">
                <div class="h-48 z-[5] flex justify-between text-lg px-5 mt-auto pt-4 bg-opacity-70 bg-clip-padding backdrop-blur-md bg-black">
                    <div>
                        <p class="font-semibold text-xs md:text-base">All Categories</p>
                        <!-- <span class="text-xs text-neutral-400">{{ category.business_count }} Businesses</span> -->
                    </div>
                    <span class="text-xl group-hover:text-primary-400"> → </span>
                </div>
            </Link>
        </div>
    </section>
</template>
