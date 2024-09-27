<script setup>
import { ref } from "vue";
import Button from "primevue/button";
import Login from "./Auth/Login.vue";
import Register from "./Auth/Register.vue";

const loginVisible = ref(false);
const registerVisible = ref(false);

</script>

<template>
    <!-- Topbar -->
    <nav
        class="flex items-center justify-between w-full py-5 border-t-8 wrapper border-primary-400 font-body"
    >
        <div class="w-24 md:w-32">
            <img class="w-full" src="/images/arkquire_logo_3.png" alt="logo" />
        </div>

      

        <section class="flex items-center">
            <!-- <button
                v-if="$page.props.auth?.user"
                v-ripple
                class="flex items-center gap-2 p-2 rounded-lg outline-none p-ripple hover:bg-primary-100"
            >
                <i v-badge class="text-2xl bx bx-bell p-overlay-badge"></i>
            </button> -->

            <!-- <div
                v-if="$page.props.auth?.user"
                class="w-0 h-6 mx-4 border-l"
            ></div> -->

            <div class="flex items-center gap-4">
                <button
                    class="font-semibold btn bg-primary-500 text-primary-200"
                > <a href="/contact-us"> Contact Us </a>
                    
                </button>
                <button
                    
                    class="font-semibold btn text-primary-500"
                ><a href="/faq"> FAQs</a>
                   
                </button>
            </div>
        </section>
    </nav>
    <Login v-model:visible="loginVisible" />
    <Register v-model:visible="registerVisible" />
</template>
