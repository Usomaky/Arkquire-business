<script setup>
import { onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import Navbar from '../Components/Navbar.vue';
import Footer from '../Components/Footer.vue';
import Header from '../Components/Header.vue';
import Categories from '../Components/Business/Categories.vue';
import Auctions from '../Components/Business/Auctions.vue';

import Services from '../Layouts/Services.vue';
defineOptions({ layout: Services });
</script>

<template>
    <Head>
        <title>Auctions</title>
    </Head>
    <section class="w-full">
        <Navbar/>
        <Header/>
        <Auctions/>
        <Categories/>
        <Footer/>
    </section>
</template>
