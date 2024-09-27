<script setup></script>

<template>
    <section class="w-full font-body px-4 xl:px-32 pb-14">
        <div
            class="py-16 px-6 lg:px-32 rounded-2xl shadow-xl shadow-primary-200 bg-primary-400 relative"
        >
            <div class="w-full md:w-7/12 lg:w-5/12">
                <h2
                    class="font-display text-5xl font-semibold text- md:text-6xl"
                >
                    Ready to get started?
                </h2>
                <p class="mt-6">
                    Create an account and instantly start accepting payments,
                    selling your beautiful products online and building
                    financial tools.
                </p>
                <button
                    class="mt-8 group inline-flex items-center gap-2 text-sm md:text-base text-black"
                >
                    <span><a href="/about">Learn more</a></span>
                    <span
                        class="relative transition-all duration-300 ease-in-out group-hover:translate-x-3"
                        >→</span
                    >
                </button>
            </div>
            <div
                class="mt-10 lg:absolute top-0 right-0 w-full lg:w-[40rem] h-auto"
            >
                <img
                    src="/images/reach_out.png"
                    class="w-full h-auto"
                    alt="reach out"
                />
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
        <!-- <div class="pt-12 pb-6 flex flex-col md:flex-row md:justify-between border-b border-neutral-200">
            <figure class="inline-block w-20 text-lg font-bold text-black mb-6 md:mb-0">Arkquire</figure>
            <ul class="flex md:items-center gap-y-4 gap-x-8 mb-6 md:mb-0">
                <li><a href="#" class="text-neutral-400 hover:text-neutral-800 text-sm">About</a></li>
                <li><a href="#" class="text-neutral-400 hover:text-neutral-800 text-sm">Career</a></li>
                <li><a href="#" class="text-neutral-400 hover:text-neutral-800 text-sm">Buy business</a></li>
                <li><a href="/faq" class="text-neutral-400 hover:text-neutral-800 text-sm">Faq</a></li>
            </ul>
            <ul class="flex md:items-center gap-y-4 gap-x-8">
                <li><a href="#" class="text-neutral-400 hover:text-neutral-800 text-sm">Twitter</a></li>
                <li><a href="#" class="text-neutral-400 hover:text-neutral-800 text-sm">Facebook</a></li>
                <li><a href="#" class="text-neutral-400 hover:text-neutral-800 text-sm">Linkedin</a></li>
            </ul>
        </div>
        <div class="pt-6 flex flex-col md:flex-row md:justify-between">
            <p class="md:mb-0 mb-6 text-neutral-600">© Arkquire 2023</p>
            <ul class="flex md:items-center gap-y-4 gap-x-8">
                <li><a href="#" class="text-neutral-400 hover:text-neutral-800 text-sm">Privacy policy</a></li>
                <li><a href="#" class="text-neutral-400 hover:text-neutral-800 text-sm">Terms and conditions</a></li>
            </ul>
        </div> -->
    </section>
</template>
