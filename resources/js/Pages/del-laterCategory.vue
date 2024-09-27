<script setup>
import { onMounted, defineOptions, defineProps } from 'vue';
import { Head } from '@inertiajs/vue3';
import Navbar from '../Components/Navbar.vue';
import Footer from '../Components/Footer.vue';
import Header from '../Components/Header.vue';
import Auction from '../Components/Business/Auction.vue';
import Categories from '../Components/Business/Categories.vue';
import Sale from '../Components/Business/Sale.vue';
import Investment from '../Components/Business/Investment.vue';
import Lease from '../Components/Business/Lease.vue';

import Services from '../Layouts/Services.vue';
defineOptions({ layout: Services });

const props = defineProps({
    auction: Object,
    sale: Object,
    lease: Object,
    investment: Object
});

// console.log(props);
</script>

<template>
    <Head>
        <title>Businesses</title>
    </Head>
    <section class="w-full">
        <Navbar/>
        <Header/>
        <Auction :businesses="auction"/>
        <Sale :businesses="sale"/>
        <Investment :businesses="investment"/>
        <Lease :businesses="lease"/>
        <Categories/>
        <Footer/>
    </section>
</template>
