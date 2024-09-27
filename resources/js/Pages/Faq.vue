<script setup>
import { Head } from "@inertiajs/vue3";
import Navbar from '../Components/Navbar.vue';
// import Faqbody from '../Components/Faqbody.vue';
import Footer from "../Components/Footer.vue";
import Accordion from "primevue/accordion";
import AccordionTab from "primevue/accordiontab";

import Foreground from "../Layouts/Services.vue";
defineOptions({ layout: Foreground });

const props = defineProps({
    faqData: Array,
});
</script>

<template>
    <Head>
        <title>Faq</title>
    </Head>
    <section class="w-full">
        <Navbar />

        <section class="mt-8 px-5 mb-[4rem] w-full font-body xl:px-32 pb-14">
            <div class="flex flex-col md:flex-row justify-between gap-[3rem]">
                <div class="flex flex-col justify-between">
                    <div class="text-center md:text-left">
                        <h1 class="text-3xl">Frequently Asked Questions</h1>
                        <p>
                            Find answers to common inquiries from our valued
                            users
                        </p>
                    </div>
                    <div
                        class="hidden md:block relative -top-[1rem] right-[10.5rem]"
                    >
                        <img class="" src="/images/contact_leaf.png" alt="" />
                    </div>
                </div>
                <div class="flex flex-col justify-between w-7/12">
                    <div class="card w-full">
                        <Accordion
                            :activeIndex="0"
                            expandIcon="pi pi-angle-up"
                            collapseIcon="pi pi-angle-down"
                        >
                            <AccordionTab
                                v-for="(item, index) in faqData"
                                :key="index"
                                :header="item.faq_header"
                            >
                                <p class="m-0">
                                    {{ item.faq_content }}
                                </p>
                            </AccordionTab>
                        </Accordion>
                    </div>
                </div>
            </div>
        </section>
        <!-- <Faqbody/> -->

        <Footer />
    </section>
</template>
