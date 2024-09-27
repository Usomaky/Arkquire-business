<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <section class="w-full wrapper my-10">
        <header class="w-full mb-4">
            <div>
                <p class="text-neutral-700 font-semibold text-lg">Auctions</p>
                <small>
                    These are the list of businesses on auction
                </small>
            </div>
        </header>

        <div class="w-full grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 md:gap-4">
            <!-- Cards -->
            <Link class="w-full block group mr-2" href="#" v-for="index in 12" :key="index">
                <div class="w-full relative">
                    <img class="w-full grayscale group-hover:grayscale-0 transition-all duration-300 ease-in-out h-32 border border-neutral-100 rounded-t-lg group-hover:border-primary-400 object-cover object-center relative" src="/images/meeting.jpeg" alt="image">
                </div>
                <div class="w-full text-left border-x border-b p-2 rounded-b-lg space-y-1">
                    <p class="text-sm font-semibold group-hover:text-primary-400 flex items-center justify-between">
                        <span>Lorem ipsum dolor</span>
                        <span class="font-normal text-xs text-primary-400 shrink-0">3 bids</span>
                    </p>
                    <p class="text-neutral-700 flex items-center justify-between">
                        <span class="text-xs">Starting bid</span>
                        <span class="text-sm font-semibold">₦750,000,000</span>
                    </p>
                    <p class="text-xs flex items-center justify-between">
                        <span>Time left</span>
                        <span class="font-normal text-xs text-red-400 shrink-0">3hrs 57mins</span>
                    </p>
                </div>
            </Link>
        </div>
    </section>
</template>
