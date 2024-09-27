
    <div class="card flex justify-center">
        <div class="flex flex-wrap gap-4">
            <div class="flex items-center">
                <RadioButton v-model="ingredient" inputId="ingredient1" name="pizza" value="Cheese" />
                <label for="ingredient1" class="ml-2">Cheese</label>
            </div>
            <div class="flex items-center">
                <RadioButton v-model="ingredient" inputId="ingredient2" name="pizza" value="Mushroom" />
                <label for="ingredient2" class="ml-2">Mushroom</label>
            </div>
            <div class="flex items-center">
                <RadioButton v-model="ingredient" inputId="ingredient3" name="pizza" value="Pepper" />
                <label for="ingredient3" class="ml-2">Pepper</label>
            </div>
            <div class="flex items-center">
                <RadioButton v-model="ingredient" inputId="ingredient4" name="pizza" value="Onion" />
                <label for="ingredient4" class="ml-2">Onion</label>
            </div>
        </div>
    </div>

<script setup>
import { ref } from 'vue';

const ingredient = ref('');
</script>




<template>
  <div>
    <span>{{ displayedText }}</span><span v-if="showCursor">|</span>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const texts = ["Welcome to our website!", "Explore our features!", "Join us today!"];
const typingSpeed = 100; // Speed in ms
const pauseBetweenTexts = 1500; // Pause between texts in ms
const displayedText = ref("");
const showCursor = ref(true);

const typeWriterEffect = (text, callback) => {
  let index = 0;
  const interval = setInterval(() => {
    if (index < text.length) {
      displayedText.value += text[index];
      index++;
    } else {
      clearInterval(interval);
      setTimeout(callback, pauseBetweenTexts);
    }
  }, typingSpeed);
};

const startTyping = () => {
  let currentTextIndex = 0;

  const typeNextText = () => {
    displayedText.value = "";
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
</script>

<style scoped>
/* Optional: Customize the cursor blink */
span {
  font-family: monospace;
}
</style>
































<script setup>
import { ref } from 'vue';
import AdvancedSearch from '../Components/AdvancedSearch.vue';

const showAdvancedSearchDialog = ref(false);

</script>

<template>
    <section class="flex w-full pt-4 pb-8 wrapper md:py-24 xl:gap-x-16">
        <!-- left -->
        <div class="w-full space-y-10 md:w-11/12 lg:w-8/12">
            <h1 class="text-neutral-800">
                #1 marketplace to buy and sell
                <span class="text-primary-400">Online businesses</span>
            </h1>
            <p class="w-full text-sm md:w-9/12 md:text-lg text-neutral-500">
                Buy an online business, become an acquisition entrepreneur, and invest in digital real estate.
            </p>
            <div class="w-full space-y-4 md:w-11/12">
                <div class="flex w-full gap-2 overflow-auto md:w-fit scrollbar-hide">
                    <span class="flex items-center justify-center px-4 py-2 text-sm border border-black rounded-full shrink-0">For sale</span>
                    <span class="flex items-center justify-center px-4 py-2 text-sm rounded-full text-neutral-400 shrink-0">Auction</span>
                    <span class="flex items-center justify-center px-4 py-2 text-sm rounded-full text-neutral-400 shrink-0">For lease</span>
                    <span class="flex items-center justify-center px-4 py-2 text-sm rounded-full text-neutral-400 shrink-0">Invest</span>
                </div>
                <div class="w-full flex gap-x-3 px-3 py-2 rounded-full border hover:border-primary-400 hover:ring-4 ring-primary-200 mb-2">
                    <select class="flex-grow outline-none">
                        <option value="">All Categories</option>
                        <option value="Nigeria">E-commerce</option>
                        <option value="Nigeria">SaaS</option>
                        <option value="Nigeria">Health and Wellness</option>
                        <option value="Nigeria">Travel and Tourism</option>
                        <option value="Nigeria">Food and Beverage</option>
                        <option value="Nigeria">Real Estate</option>
                        <option value="Nigeria">Renewable Energy</option>
                        <option value="Nigeria">Automobile</option>
                        <option value="Nigeria">Entertainment and Media</option>
                        <option value="Nigeria">Social Networking</option>
                        <option value="Nigeria">Beauty and Personal Care</option>
                        <option value="Nigeria">Event Management</option>
                        <option value="Nigeria">Others</option>
                    </select>

                    <input class="w-20 pl-2 border-l outline-none md:flex-grow" type="text" placeholder="Search">

                    <button class="font-semibold btn text-neutral-400 md:bg-primary-500 md:text-primary-200">
                        <span class="hidden md:block">Search</span>
                        <i class="bx bx-search md:hidden"></i>
                    </button>
                </div>
                <div class="flex justify-end w-full">
<button @click="showAdvancedSearchDialog = true" class="btn mb-4">Advanced search</button>
            <AdvancedSearch :user="user" :visible="showAdvancedSearchDialog" @update:visible="showAdvancedSearchDialog = $event"/>

            
                </div>
            </div>
        </div>

        <!-- right -->
        <div class="items-center justify-end hidden w-full lg:w-4/12 xl:w-6/12 lg:flex">
            <div class="w-full xl:w-9/12 rotate-[20deg] relative -top-10 xl:-top-20 -left-4 z-[2]">
                <img class="object-contain w-full pointer-events-none" src="/images/heroImage.png" alt="image">
            </div>
        </div>
    </section>
</template>
