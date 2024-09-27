<script setup>
import { Head } from "@inertiajs/vue3";
import Navbar from "../Components/Navbar.vue";
import Abouthero from "../Components/Abouthero.vue";
import Ourmission from "../Components/Ourmission.vue";
import Visionstatement from "../Components/Visionstatement.vue";
import Footer from "../Components/Footer.vue";

import Foreground from "../Layouts/Services.vue";
import Ourteam from "../Components/Ourteam.vue";
defineOptions({ layout: Foreground });
</script>

<template>
    <Head>
        <title>About</title>
    </Head>
    <section class="w-full">
        <Navbar />
        <Abouthero />
        <Ourmission />
        <Visionstatement />
        <Ourteam />
        <Footer />
    </section>
</template>
