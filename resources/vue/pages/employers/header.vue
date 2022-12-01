<template>
    <header class="w-full relative pb-6">

        <!-- Container -->
        <div class="flex justify-between container pt-6">

            <!-- Product -->
            <div class="flex items-center cursor-pointer"
                 @click="redirect(isGuest() ? 'home' : 'dashboard.user')">

                <!-- Logo -->
                <img alt="Logo"
                     class="h-22px mr-3"
                     :src="asset('img/logo.svg')">

                <!-- Name -->
                <img alt="Name"
                     class="h-13px mt-1px"
                     :src="asset('img/name.svg')">

            </div>

            <!-- Links -->
            <div class="flex items-center">

                <!-- Login -->
                <v-link v-if="isGuest()"
                        :url="route('login')"
                        class="text-13px text-gray-400/70 hover:text-gray-200 uppercase">

                    <!-- Text -->
                    Sign in

                </v-link>

                <!-- Account -->
                <v-link v-if="isAuthenticated()"
                        :url="route('dashboard.user')"
                        class="text-13px text-gray-400/70 hover:text-gray-200 uppercase">

                    <!-- Text -->
                    Dashboard

                </v-link>

            </div>

        </div>

        <!-- Notification -->
        <v-notification></v-notification>

    </header>
</template>

<script>
    import LinkComponent from '@/components/link.vue';
    import NotificationComponent from '@/components/notification.vue';
    import InteractsWithAuthentication from '@/mixins/InteractsWithAuthentication';

    export default
    {
        /**
         * Define the mixins.
         *
         */
        mixins : [
            InteractsWithAuthentication,
        ],

        /**
         * Define the components.
         *
         */
        components : {
            'v-link'         : LinkComponent,
            'v-notification' : NotificationComponent,
        },
    }
</script>