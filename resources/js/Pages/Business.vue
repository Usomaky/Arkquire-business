<script setup>
import { onMounted, defineOptions, defineProps } from 'vue';
import { Head } from '@inertiajs/vue3';
import Navbar from '../Components/Navbar.vue';
import Footer from '../Components/Footer.vue';
import Categories from '../Components/Business/Categories.vue';
import Details from '../Components/Business/Details.vue';
import { usePage } from '@inertiajs/vue3';

import Services from '../Layouts/Services.vue';
defineOptions({ layout: Services });

// const { props } = usePage();

const props = defineProps({
    business: Object
});
</script>

<template>
    <Head>
        <title>{{ business?.business_name }}</title>
    </Head>
    <section class="w-full">
        <Navbar/>
        <Details/>
        <Categories/>
        <Footer/>
    </section>
</template>
