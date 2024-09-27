<script setup>
import { Head } from '@inertiajs/vue3';
import Navbar from '../Components/Navbar.vue';
import Forgotpasswordhero from '../Components/Forgotpasswordhero.vue';
import Forgotpasswordnavbar from '../Components/Forgotpasswordnavbar.vue'


import Foreground from '../Layouts/Services.vue';
defineOptions({ layout: Foreground });
</script>

<template>
    <Head>
        <title>Forgot Password</title>
    </Head>
    <section class="w-full">
        <Forgotpasswordnavbar/>
        <Forgotpasswordhero/>
    </section>
</template>
