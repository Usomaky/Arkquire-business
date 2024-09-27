

<script setup>
// import { Link, router } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import { useForm } from '@inertiajs/vue3';
import AdvancedSearch from "../Components/AdvancedSearch.vue";

const showAdvancedSearchDialog = ref(false);

const texts = ["Businesses", "Online Businesses", "Startups"];
const typingSpeed = 100; // Speed in ms for typing
const deletingSpeed = 50; // Speed in ms for deleting
const pauseBetweenTexts = 1500; // Pause between texts in ms
const displayedText = ref("");
const showCursor = ref(true);

const typeWriterEffect = (text, callback) => {
    let index = 0;

    const type = () => {
        if (index < text.length) {
            displayedText.value += text[index];
            index++;
            setTimeout(type, typingSpeed);
        } else {
            setTimeout(() => deleteText(text, callback), pauseBetweenTexts);
        }
    };

    const deleteText = (text, callback) => {
        if (index > 0) {
            displayedText.value = text.substring(0, index - 1);
            index--;
            setTimeout(() => deleteText(text, callback), deletingSpeed);
        } else {
            callback();
        }
    };

    type();
};

const startTyping = () => {
    let currentTextIndex = 0;

    const typeNextText = () => {
        typeWriterEffect(texts[currentTextIndex], () => {
            currentTextIndex = (currentTextIndex + 1) % texts.length;
            typeNextText();
        });
    };

    typeNextText();
};

// Blink the cursor
const cursorBlink = () => {
    setInterval(() => {
        showCursor.value = !showCursor.value;
    }, 500);
};

onMounted(() => {
    startTyping();
    cursorBlink();
});

// Search Functionality
const searchQuery = ref('');
const selectedCategory = ref('');

// Manage the active transaction type state
const activeTransactionType = ref('auction'); // default value

// Handle transaction type change
const handleTransactionTypeChange = (type) => {
    activeTransactionType.value = type;
};



const props = defineProps({
    businesses: Array,
     categories: Array,
});

const searchBusinesses = () => {
    const form = useForm({
        search: searchQuery.value,
        category: selectedCategory.value,
        activeTransactionType: activeTransactionType.value,

    
    });

   form.get("/businesses/search", {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        onSuccess: () => {
            // Update the URL with both the search query and selected category as query parameters
            const url = new URL(window.location.href);
            url.searchParams.set('category', selectedCategory.value);
            url.searchParams.set('search', searchQuery.value);
            window.history.replaceState({}, '', url);
        },
    });
};


</script>

<style scoped>
.cursor-style {
    font-family: monospace;
}
</style>

<template>
    <section class="flex w-full pt-4 pb-8 wrapper md:py-24 xl:gap-x-16">
        <!-- left -->
        <div class="w-full md:w-11/12 lg:w-8/12">
            <h1 class="text-neutral-800 h-48-ed">
                #1 marketplace to buy and sell

                <span class="text-primary-400">{{ displayedText }}</span
                    ><span class="cursor-style text-primary-400">|</span>
            </h1>
            <p class="w-full text-sm md:w-9/12 md:text-lg text-neutral-500">
                Buy an online business, become an acquisition entrepreneur, and
                invest in digital real estate.
            </p>
            <div class="w-full mt-5 md:w-11/12">
                <div class="flex w-full gap-2 overflow-auto md:w-fit scrollbar-hide">
                    <input
                class="eradio"
                type="radio"
                id="auction"
                name="transaction-type"
                value="auction"
                v-model="activeTransactionType"
                @change="handleTransactionTypeChange('auction')"
                />
                
                <label
                class="radio-editt flex items-center justify-center px-4 py-2 text-sm rounded-full text-neutral-400 shrink-0"
                for="auction"
                >
                <span class="text-green-1">Auction</span>
                </label>
                  <input
                  class="eradio"
                  type="radio"
                  id="sale"
                  name="transaction-type"
                  value="sale"
                        v-model="activeTransactionType"
                        @change="handleTransactionTypeChange('sale')"
                    />

                    <label
                        class="radio-editt flex items-center justify-center px-4 py-2 text-sm rounded-full text-neutral-400 shrink-0"
                        for="sale"
                    >
                        <span class="text-green-1">For Sale</span>
                    </label>

                    <input
                         class="eradio"
                         type="radio"
                         id="invest"
                         name="transaction-type"
                         value="investment"
                         v-model="activeTransactionType"
                         @change="handleTransactionTypeChange('investment')"
                     />
                   
                     <label
                         class="radio-editt flex items-center justify-center px-4 py-2 text-sm rounded-full text-neutral-400 shrink-0"
                         for="invest"
                     >
                         <span class="text-green-1">Invest</span>
                     </label>
                    <input
                        class="eradio"
                        type="radio"
                        id="lease"
                        name="transaction-type"
                        value="lease"
                        v-model="activeTransactionType"
                        @change="handleTransactionTypeChange('lease')"
                        />
                        <label
                    class="radio-editt flex items-center justify-center px-4 py-2 text-sm rounded-full text-neutral-400 shrink-0"
                    for="lease"
                    >
                        <span class="text-green-1">For lease</span>
                    </label>

                </div>
                <div
                    class="w-full mt-2-ed flex gap-x-3 px-3 py-2 rounded-full border hover:border-primary-400 hover:ring-4 ring-primary-200 mb-2"
                >
  <select v-model="selectedCategory" class="flex-grow outline-none">
                        <option value="">All Categories</option>
                        <option 
                            v-for="category in categories" 
                            :key="category.id" 
                            :value="category.id">
                            {{ category.category_name }}
                        </option>
                    </select>

                    <input
                        class="w-20 pl-2 border-l outline-none md:flex-grow"
                        type="text"
                        v-model="searchQuery"
                        placeholder="Search"
                    />

                    <button
                        @click="searchBusinesses"
                        class="font-semibold btn text-neutral-400 md:bg-primary-500 md:text-primary-200"
                    >
                        <span class="hidden md:block">Search</span>
                        <i class="bx bx-search md:hidden"></i>
                    </button>
                </div>
                <div class="flex justify-end w-full">
                    <button
                        @click="showAdvancedSearchDialog = true"
                        class="btn mb-4"
                    >
                        Advanced search
                    </button>
                    <AdvancedSearch
                        :user="user"
                        :visible="showAdvancedSearchDialog"
                        @update:visible="showAdvancedSearchDialog = $event"
                    />
                </div>
            </div>
        </div>

        <!-- right -->
        <div
            class="items-center justify-end hidden w-full lg:w-4/12 xl:w-6/12 lg:flex"
        >
            <div
                class="w-full xl:w-9/12 rotate-[20deg] relative -top-10 xl:-top-[4rem] -left-4 z-[2]"
            >
                <img
                    class="object-contain w-full pointer-events-none"
                    src="/images/heroImage.png"
                    alt="image"
                />
            </div>
        </div>
    </section>
</template>

