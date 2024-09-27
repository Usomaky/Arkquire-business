<script setup>
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AdvancedSearch from '../Components/AdvancedSearch.vue';

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


// Initialize the values from the query parameters
const urlParams = new URLSearchParams(window.location.search);
const initialCategory = urlParams.get('category') || '';
const initialSearch = urlParams.get('search') || '';

const selectedCategory = ref(initialCategory);
const searchQuery = ref(initialSearch);



// Search Functionality
// const searchQuery = ref('');
// const selectedCategory = ref('');

// Manage the active transaction type state
const activeTransactionType = ref('auction'); // default value

// Handle transaction type change
// const handleTransactionTypeChange = (type) => {
//     activeTransactionType.value = type;
// };



const props = defineProps({
    businesses: Array,
     categories: Array,
});

const searchBusinesses = () => {
    const form = useForm({
        search: searchQuery.value,
        category: selectedCategory.value,
        // activeTransactionType: activeTransactionType.value,

    
    });

    form.get("/businesses/search", {
        preserveState: true,
    });
};
</script>

<style scoped>

.cursor-style {
  font-family: monospace;
}
</style>


<template>
    <section
        class="w-full min-h-[30vh] md:min-h-[20vh] lg:min-h-[30vh] wrapper flex flex-col items-center justify-center"
    >
        <h3
            class="h-48-bs w-full md:w-9/12 lg:w-8/12 font-head text-4xl font-semibold md:text-5xl text-neutral-800 text-center mb-6"
        >
            #1 marketplace to buy and sell
        
    <span class="text-primary-400">{{ displayedText }}</span><span class="cursor-style text-primary-400">|</span>

        </h3>
        <div
            class= "f-ed w-full w-edit md:w-6/12 flex gap-x-3 px-3 py-2 rounded-full border hover:border-primary-400 hover:ring-4 ring-primary-200 mb-2"
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
                class="f-ed w-20 md:flex-grow outline-none border-l pl-1 sm:pl-2"
                type="text"
                v-model="searchQuery"
                placeholder="Search"
            />

            <button
              @click="searchBusinesses"
                class="btn btn-ed text-neutral-400 md:bg-primary-500 md:text-primary-200 font-semibold"
            >
                <span class="hidden md:block">Search</span>
                <i class="bx bx-search md:hidden"></i>
            </button>
        </div>
        <div class="w-full md:w-6/12 flex justify-end mb-2">
            <button @click="showAdvancedSearchDialog = true" class="btn mb-4">Advanced search</button>
            <AdvancedSearch :user="user" :visible="showAdvancedSearchDialog" @update:visible="showAdvancedSearchDialog = $event"/>

        </div>
    </section>
</template>
