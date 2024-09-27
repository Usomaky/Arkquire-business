<script setup>
import { Head } from "@inertiajs/vue3";
import Navbar from "../Components/Navbar.vue";
import Hero from "../Components/Hero.vue";
import Slider from "../Components/Slider.vue";
import Category from "../Components/Category.vue";
import Trustees from "../Components/Trustees.vue";
import Info from "../Components/Info.vue";
import Services from "../Components/Services.vue";
import Testimonies from "../Components/Testimonies.vue";
import Footer from "../Components/Footer.vue";
import { ref, onMounted, defineOptions, defineProps } from "vue";

import Foreground from "../Layouts/Services.vue";
defineOptions({ layout: Foreground });

const props = defineProps({
    businesses: Array,
});

import { usePage } from "@inertiajs/vue3";

// Fetch categories from the backend
const { featuredCategories } = usePage().props;
const { categories } = usePage().props;
</script>

<template>
    <Head>
        <title>Home</title>
    </Head>
    <section class="w-full">
        <Navbar />
        <div
            class="px-4 md:px-20 min-h-[70%] md:min-h-screen grid place-items-center"
        >
            <div class="text-center">
                <div class="relative grid place-items-center">
                    <img
                        class="absolute -top-[5rem] -left-[3rem]"
                        src="/images/leafff-o.png.png"
                        alt=""
                    />
                    <img src="/images/notfound-circl.png" alt="" />
                </div>
                <div>
                    <div
                        class="inline-block px-4 py-2 text-blue-500 text-xs bg-slate-200 rounded-md"
                    >
                        404 error
                    </div>
                    <h1 class="font-bold text-2xl mt-4">
                        We've lost this page
                    </h1>
                    <p class="text-xs">
                        Sorry the page you are looking for doesn't exist or has
                        been moved.
                    </p>

                    <a
                        class="text-white bg-green-500 rounded-full inline-block px-4 py-3 text-xs mt-8"
                        href="/"
                        >Go to Home</a
                    >
                </div>
            </div>
        </div>
        <footer
            class="mx-auto flex max-w-7xl border-t mt-20 flex-col md:flex-row mb-3"
        >
            <div class="md:w-1/4 flex-shrink-0 border-b md:border-r px-5 py-5">
                <h5 class="font-bold">Arkquire &copy; 2024</h5>
                <p class="text-gray text-xs text-gray-700">
                    Supporting startups, growing scaleups
                </p>
                <p class="text-gray mt-3 text-xs text-gray-700">
                    Arkquire Enterprise Ltd. <br />A Mckhavens Capital Ventures
                    Company <br />
                </p>
            </div>
            <div class="grid-col-1 grid grow md:grid-cols-4">
                <div class="p-5">
                    <h6 class="text-xs uppercase tracking-widest">Contact</h6>
                    <ul class="mt-5 flex flex-col gap-y-3">
                        <li class="text-xs text-gray-500 hover:text-gray-800">
                            <a href="tel:+2348064304137"> +2348067726461</a>
                        </li>
                        <li class="text-xs text-gray-500 hover:text-gray-800">
                            <a href="mailto:help@arquire.com">
                                help@arkquire.com</a
                            >
                        </li>
                        <li class="text-xs text-gray-500 hover:text-gray-800">
                            <a>
                                227, 3rd floor, Lennox Mall, Block 10, Plot 2 &
                                3 Admiralty Way, Lekki Phase 1, Lagos, Nigeria.
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="p-5">
                    <h6 class="text-xs uppercase tracking-widest">Company</h6>
                    <ul class="mt-5 flex flex-col gap-y-3">
                        <li class="text-xs text-gray-500 hover:text-gray-800">
                            <a href="/about"> About</a>
                        </li>
                        <li class="text-xs text-gray-500 hover:text-gray-800">
                            <a href="#"> Career</a>
                        </li>
                        <li class="text-xs text-gray-500 hover:text-gray-800">
                            <a href="/businesses">Buy Business</a>
                        </li>
                        <li class="text-xs text-gray-500 hover:text-gray-800">
                            <a href="/contact-us">Contact Us</a>
                        </li>
                        <li class="text-xs text-gray-500 hover:text-gray-800">
                            <a href="/faq">Faq</a>
                        </li>
                    </ul>
                </div>
                <div class="p-5">
                    <h6 class="text-xs uppercase tracking-widest">Socials</h6>
                    <ul class="mt-5 flex flex-col gap-y-3">
                        <li class="text-xs text-gray-500 hover:text-gray-800">
                            <a href="#"> Facebook</a>
                        </li>
                        <li class="text-xs text-gray-500 hover:text-gray-800">
                            <a href="#"> Twitter</a>
                        </li>
                        <li class="text-xs text-gray-500 hover:text-gray-800">
                            <a href="#"> Linkedin</a>
                        </li>
                    </ul>
                </div>
                <div class="p-5">
                    <h6 class="text-xs uppercase tracking-widest">Legal</h6>
                    <ul class="mt-5 flex flex-col gap-y-3">
                        <li class="text-xs text-gray-500 hover:text-gray-800">
                            <a href="#"> Privacy Policy</a>
                        </li>
                        <li class="text-xs text-gray-500 hover:text-gray-800">
                            <a href="#"> Terms and Conditions</a>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>
    </section>
</template>
