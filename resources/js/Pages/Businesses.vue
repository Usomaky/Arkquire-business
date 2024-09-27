<script setup>
import { ref, computed, defineOptions, defineProps } from 'vue';
import { Head } from '@inertiajs/vue3';
import Navbar from '../Components/Navbar.vue';
import Footer from '../Components/Footer.vue';
import Header from '../Components/Header.vue';
import Auction from '../Components/Business/Auction.vue';
import Categories from '../Components/Business/Categories.vue';
import Sale from '../Components/Business/Sale.vue';
import Investment from '../Components/Business/Investment.vue';
import Lease from '../Components/Business/Lease.vue';
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import { usePage } from '@inertiajs/vue3';

import Services from '../Layouts/Services.vue';
defineOptions({ layout: Services });

const props = defineProps({
    auction: Object,
    sale: Object,
    lease: Object,
    investment: Object,
    activeTransactionType: String, 
}); 
// declared in parent, used on parent directly

// Map transaction type to TabView indices
const transactionTypeToTabIndex = {
    auction: 0,
    sale: 1,
    investment: 2,
    lease: 3
};

// Compute the initial active tab based on the received prop
const activeTab = computed(() => transactionTypeToTabIndex[props.activeTransactionType] || 0);

const { categories } = usePage().props;
const { popularCategories } = usePage().props; // declared in parent, used in child
</script>

<template>
    <Head>
        <title>Businesses</title>
    </Head>
    <section class="w-full relative">
        <Navbar/>
        <Header   :categories="categories"/>
        <div class="card">
            <TabView :activeIndex="activeTab">
                <TabPanel header="Auction">
                    <Auction :businesses="auction"/>
                </TabPanel>
                <TabPanel header="Sale">
                    <Sale :businesses="sale"/>
                </TabPanel>
                <TabPanel header="Investment">
                    <Investment :businesses="investment"/>
                </TabPanel>
                <TabPanel header="Lease">
                    <Lease :businesses="lease"/>
                </TabPanel>
            </TabView>
        </div>
        <Categories    :popularCategories="popularCategories" />
        <Footer/>
    </section>
</template>
