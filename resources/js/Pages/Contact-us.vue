<script setup>
import { Head } from '@inertiajs/vue3';
import Navbar from '../Components/Navbar.vue';
import Contactform from '../Components/Contactform.vue';
import Footer from '../Components/Footer.vue';

import Foreground from '../Layouts/Services.vue';
defineOptions({ layout: Foreground });
</script>

<template>
    <Head>
        <title>Home</title>
    </Head>
    <section class="w-full">
        <Navbar/>
        <Contactform/>

        <Footer/>
    </section>
</template>
