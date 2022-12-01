<template>
    <v-panel>

        <!-- Left -->
        <template #left>

            <!-- Title -->
            <h5 class="text-18px font-semibold text-sky-700">
                Contact Us
            </h5>

            <!-- Information -->
            <p class="w-full xl:w-3/4 mb-0">
                We're eager to hear from you&hellip; if you have
                an issue or need help, please get in touch.
            </p>

        </template>

        <!-- Right -->
        <template #right>
            <div class="grid grid-cols-1 lg:grid-cols-2">

                <!-- Corporate -->
                <div class="mt-3 lg:mt-0">

                    <!-- Subtitle -->
                    <h6 class="font-inter text-16px text-black tracking-normal">
                        Corporate Affairs
                    </h6>

                    <!-- Information -->
                    <p class="w-full xl:w-5/6 mb-4">
                        Business, legal or press inquiries
                        that require an official response.
                    </p>

                    <!-- Links -->
                    <div class="flex">

                        <!-- Link -->
                        <v-link class="text-12px text-sky-600 hover:text-rose-700 uppercase mr-6"
                                :action="() => window.location.href = `mailto:${prop('mail.corporate')}`">

                            <!-- Icon -->
                            <i class="fas fa-envelope text-14px text-gray-400 relative top-1px mr-2"></i>

                            <!-- Text -->
                            Send email

                        </v-link>

                    </div>

                </div>

                <!-- Support -->
                <div class="mt-12 lg:mt-0">

                    <!-- Subtitle -->
                    <h6 class="font-inter text-16px text-black tracking-normal">
                        Support Team
                    </h6>

                    <!-- Information -->
                    <p class="w-full xl:w-5/6 mb-4">
                        For all other inquiries regarding the
                        site, your account, billing etc.
                    </p>

                    <!-- Links -->
                    <div class="flex">

                        <!-- Link -->
                        <v-link class="text-12px text-sky-600 hover:text-rose-700 uppercase mr-6"
                                :action="() => window.location.href = `mailto:${prop('mail.support')}`">

                            <!-- Icon -->
                            <i class="fas fa-envelope text-14px text-gray-400 relative top-1px mr-2"></i>

                            <!-- Text -->
                            Send email

                        </v-link>

                    </div>

                </div>

            </div>
        </template>

    </v-panel>
</template>

<script>
    import LinkComponent from '@/components/link.vue';
    import PanelComponent from '@/components/panel.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-link'  : LinkComponent,
            'v-panel' : PanelComponent,
        },
    }
</script>