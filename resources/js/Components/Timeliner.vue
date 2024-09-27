<script>
export default {
    props:{
        orientation: {
            type: String,
            default: "horizontal"
        },
        timelines: {
            type: Array,
            required: true
        },
        current: {
            type: Number,
            default: 0
        }
    },
    data(){
        return {}
    }
}
</script>

<template>
    <div :class="orientation === 'horizontal' ? 'flex-row' : 'flex-col'" class="flex">
        <section v-for="(timeline, key) in timelines" :key="key"
            class="flex items-end">
            <div :class="orientation === 'horizontal' ? 'flex-row' : 'flex-col'" class="flex items-center">
                <div v-if="key !== 0"
                    :class="current === key ? 'border-slate-500' : key < current ? 'border-primary-500' : 'border-slate-400', orientation === 'horizontal' ? 'w-5 h-[0px]' : 'w-[0px] h-5'"
                    class="m-1 border border-dashed"
                    >
                </div>
                <div :class="current === key ? 'border-slate-600 text-slate-600' : key < current ? 'border-primary-500 text-primary-500' : 'border-slate-400 text-slate-400'"
                    class="relative z-0 flex items-center justify-center w-10 h-10 border rounded-full lg:w-8 lg:h-8">
                    <span v-if="timeline?.label" class="text-xs">{{ timeline?.label }}</span>
                    <span v-else class="text-sm"><i class='text-xl bx bx-check'></i></span>
                    <i v-if="current > key && timeline?.label" class='absolute z-10 text-xl bx bxs-check-circle text-primary-500 -right-3 -bottom-2'></i>
                </div>
            </div>
            <span :class="current === key ? 'text-slate-700' : key < current ? 'text-primary-500' : 'text-slate-400', orientation === 'horizontal' ? 'hidden' : 'block'"
                class="mb-3 ml-4 text-sm">
                {{ timeline?.description }}
            </span>
        </section>
    </div>
</template>
