<script>
import { Link } from '@inertiajs/vue3';
export default{
    components:{
        Link
    },
    props:{
        links: Array,
    },
    data(){
        return{
        }
    },
    methods:{
        // Method to check and get URL query parameters
        getQueryParameters() {
            const queryString = window.location.search;
            const params = new URLSearchParams(queryString);

            // Create an object to store the key-value pairs of query parameters
            const queryParams = {};

            for (const [key, value] of params.entries()) {
                queryParams[key] = value;
            }

            return queryParams;
        },
        addQueryParametersToUrl(url, params) {
            const urlObj = new URL(url);

            // Get the existing query parameters from the URL
            const existingParams = urlObj.searchParams;

            // Add new query parameters to the URL
            params.forEach(param => {
                existingParams.set(param.name, param.value);
            });

            // Update the search property of the URL object
            urlObj.search = existingParams.toString();

            return urlObj.href;
        },
        newLink(intendedlink){
            const filters = this.getQueryParameters();
            // remove page from filters
            if('page' in filters){
                delete filters['page'];
            }
            // append filters to intended link
            return this.addQueryParametersToUrl(intendedlink, Object.entries(filters).map(([name, value]) => ({ name, value })));
        }
    },
    mounted(){
        // console.log(this.links);
    }
}
</script>

<style scoped>
.paginate-button{
    @apply w-10 h-10 text-xs font-medium font-body flex-shrink-0 flex justify-center items-center
}
</style>

<template>
    <section class="flex justify-end gap-1 w-fit">
        <div class="paginate-button" v-for="(link,index) in links" :key="index">
            <Link :href="link?.url ? newLink(link?.url) : '#'" :class="link.active ? 'bg-primary-500 text-white border-0' : 'bg-[#f9f9f9] hover:bg-slate-100 border'" class="flex items-center justify-center w-full h-full rounded" preserve-state>
                <i v-if="link.label?.includes('Previous')" class="text-xl bx bx-chevron-left text-slate-600"></i>
                <i v-else-if="link.label?.includes('Next')" class="text-xl bx bx-chevron-right text-slate-600"></i>
                <span v-else :class="link.active ? 'text-white' : 'text-slate-600'">{{ link?.label }}</span>
                <!-- {{link.label?.includes('Previous') ? '<' : link?.label?.includes('Next') ? '>' : link?.label}} -->
            </Link>
        </div>
    </section>
</template>
