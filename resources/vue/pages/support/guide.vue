<template>
    <v-panel :border="false">

        <!-- Left -->
        <template #left>

            <!-- Title -->
            <h5 class="text-18px font-semibold text-sky-700">
                Product Guide
            </h5>

            <!-- Information -->
            <p class="w-full xl:w-3/4 mb-0">
                Read the user manual, or view video tutorials
                explaining how to use Lumeno's features.
            </p>

        </template>

        <!-- Right -->
        <template #right>

            <!-- Products -->
            <div @click="redirect('guide')"
                 class="flex justify-between items-center bg-sky-100/70 hover:bg-sky-100 transition duration-300 rounded-lg cursor-pointer px-8 pt-6 pb-5">

                <!-- Product -->
                <div class="flex md:flex-col lg:flex-row items-center">

                    <!-- Icon -->
                    <i class="md:hidden lg:inline fas fa-book-open text-[38px] text-sky-600/80 relative -top-1px mr-7"></i>

                    <!-- Summary -->
                    <div class="mr-5">

                        <!-- Title -->
                        <h6 class="font-inter text-gray-800 tracking-normal mb-0 md:mb-4 lg:mb-0">
                            Get Started
                        </h6>

                        <!-- Description -->
                        <p class="hidden md:inline mb-0">
                            Learn everything there is to know about Lumeno.
                        </p>

                    </div>

                </div>

                <!-- Arrow -->
                <div class="md:hidden lg:block md:ml-5">
                    <i class="fas fa-arrow-right text-20px text-gray-500"></i>
                </div>

            </div>

        </template>

    </v-panel>
</template>

<script>
    import PanelComponent from '@/components/panel.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-panel' : PanelComponent,
        },
    }
</script>