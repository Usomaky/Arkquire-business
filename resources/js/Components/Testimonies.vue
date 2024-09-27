<script setup>
import { ref } from 'vue';

const testimonials = ref([
    {
        quote: "Arkquire provides an excellent service! It is incredibly user-friendly, and the customer service is top-notch.",
        name: "Tom Jonas",
        title: "CEO, Events and Lifestyle",
        img: "/images/testimonials_2.svg"
    },
    {
        quote: "Arkquire offers a fantastic service! It is so easy to use and the customer support is the best around.",
        name: "Ellen Joshua",
        title: "CEO, Event Elevate",
        img: "/images/testimonials.svg"
    },
    // Add more testimonials here as needed
]);

const currentIndex = ref(0);

const nextTestimonial = () => {
    currentIndex.value = (currentIndex.value + 1) % testimonials.value.length;
};

const prevTestimonial = () => {
    currentIndex.value = (currentIndex.value - 1 + testimonials.value.length) % testimonials.value.length;
};
</script>

<template>
    <section class="w-full wrapper py-24 grid grid-cols-1 lg:grid-cols-3 gap-x-10 gap-y-8">
        <div>
            <p class="text-xs tracking-widest text-black mb-2 uppercase">Testimonies</p>
            <h2 class="w-full font-Fraunces text-5xl font-semibold text-black md:text-7xl">
                Kind words from our <span class="text-primary-400">esteemed</span> clients and partners
            </h2>
        </div>
        <div class="bg-primary-400 h-[40rem] hidden lg:flex rounded-3xl justify-center items-center">
        <img :src="testimonials[currentIndex].img" class=" w-11/12 h-auto" alt="testimonials">
                       
        </div>
        <div class="bg-black rounded-3xl flex flex-col p-6 py-10 shadow-2xl shadow-neutral-600">
            <div class="w-full">
                <div>
                    <q class="text-2xl md:text-3xl text-white">
                        {{ testimonials[currentIndex].quote }}
                    </q>
                    <div class="mt-8 flex items-center gap-x-6">
                        <img :src="testimonials[currentIndex].img" class="w-12 h-12 rounded-full object-cover object-center bg-white border border-primary-400 ring-4 ring-primary-300 ring-opacity-60" alt="">
                        <div>
                            <h4 class="text-primary-400 text-lg">{{ testimonials[currentIndex].name }}</h4>
                            <p class="text-sm text-neutral-400">{{ testimonials[currentIndex].title }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full mt-auto flex justify-end items-center gap-x-5">
                <button @click="prevTestimonial" class="py-2 px-4 text-center rounded-full transition-all duration-500 ease-in-out border border-primary-400 text-primary-400 hover:border-primary-500 hover:text-primary-500">←</button>
                <button @click="nextTestimonial" class="py-2 px-4 text-center rounded-full transition-all duration-500 ease-in-out border border-primary-400 text-primary-400 hover:border-primary-500 hover:text-primary-500">→</button>
            </div>
        </div>
    </section>
</template>
