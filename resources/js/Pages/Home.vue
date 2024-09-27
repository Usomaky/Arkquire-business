<script setup>
import { Head } from '@inertiajs/vue3';
import Navbar from '../Components/Navbar.vue';
import Hero from '../Components/Hero.vue';
import Slider from '../Components/Slider.vue';
import Category from '../Components/Category.vue';
import Trustees from '../Components/Trustees.vue';
import Info from '../Components/Info.vue';
import Services from '../Components/Services.vue';
import Testimonies from '../Components/Testimonies.vue';
import Footer from '../Components/Footer.vue';
import { ref, onMounted, defineOptions, defineProps } from 'vue';

import Foreground from '../Layouts/Services.vue';
defineOptions({ layout: Foreground });

const props = defineProps({
    businesses: Array
});

import { usePage } from '@inertiajs/vue3';

// Fetch categories from the backend
const { featuredCategories } = usePage().props;
const { categories } = usePage().props;
</script>

<template>
    <Head>
        <title>Home</title>
    </Head>
    <section class="w-full">
        <Navbar/>
        <Hero :businesses = "businesses"  :categories="categories"/>

        <Slider :businesses = "businesses"/>

        <Category :featuredCategories="featuredCategories" />

        <Trustees/>
        <Info/>
        <Services/>
        <Testimonies/>
        <Footer/>
    </section>
</template>
