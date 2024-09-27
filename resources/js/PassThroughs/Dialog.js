import { reactive } from "vue";

export const dialogStyles = reactive({
    header: {
        class: [
            "px-4 py-3 md:px-6 md:py-5",
            "border-t-8 border-primary-400"
        ]
    },
    content: {
        class: ["p-4 md:px-6 md:py-5"]
    },
    footer: {
        class: ["px-4 py-3 md:px-6 md:pt-2 md:pb-4"]
    },
});
