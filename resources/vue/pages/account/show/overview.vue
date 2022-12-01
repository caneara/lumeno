<template>
    <div class="flex items-start mb-10 md:mb-7 lg:mb-8 xl:mb-12">

        <!-- Avatar -->
        <v-image type="user"
                 :source="prop('account')"
                 class="w-75px h-75px min-w-75px min-h-75px max-w-75px max-h-75px md:w-[165px] md:h-[165px] md:min-w-[165px] md:min-h-[165px] md:max-w-[165px] md:max-h-[165px] rounded-full">
        </v-image>

        <!-- Summary -->
        <div class="ml-6 md:ml-9">

            <!-- Name -->
            <h4 class="mb-2px">
                {{ prop('account.name') }}
            </h4>

            <!-- Handle -->
            <span class="block text-15px text-gray-500 mb-6">
                @{{ prop('account.handle') }}
            </span>

            <!-- Area -->
            <span title="Location"
                  class="block text-15px text-gray-700 mb-2"
                  v-if="isAuthenticated() && prop('account.area')">

                <!-- Icon -->
                <i class="fa-fw fas fa-map-marker-alt text-13px text-red-700/70 -ml-9px mr-1"></i>

                <!-- Text -->
                {{ prop('account.area') }}

            </span>

            <!-- Country -->
            <span title="Country"
                  v-if="prop('account.country')"
                  class="block text-15px text-gray-700 mb-2">

                <!-- Icon -->
                <span class="flag text-14px mr-3">
                    {{ prop('countries').find(item => item.id === prop('account.country')).flag }}
                </span>

                <!-- Name -->
                <span class="country">
                    {{ prop('countries').find(item => item.id === prop('account.country')).name }} /
                </span>

                <!-- Time Zone -->
                {{ prop('time_zones').find(item => item.id === prop('account.time_zone')).short }}

            </span>

            <!-- Languages -->
            <span title="Languages"
                  v-if="prop('languages')"
                  class="block text-15px text-gray-700 mb-6">

                <!-- Icon -->
                <i class="fa-fw fas fa-language text-13px text-emerald-600/70 -ml-9px mr-1"></i>

                <!-- Text -->
                {{ prop('languages') }}

            </span>

            <!-- Online Presence -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2">

                <!-- Website -->
                <span title="Website"
                      v-if="prop('account.website')"
                      class="block text-15px text-gray-700">

                    <!-- Icon -->
                    <i class="fa-fw fas fa-globe text-13px text-orange-600/70 -ml-9px mr-1"></i>

                    <!-- Text -->
                    <v-link title="Website"
                            :inertia="false"
                            :url="prop('account.website')">

                        <!-- Text -->
                        {{ website }}

                    </v-link>

                </span>

                <!-- Github -->
                <span title="Github"
                      v-if="prop('account.github')"
                      class="block text-15px text-gray-700">

                    <!-- Icon -->
                    <i class="fab fa-fw fa-github text-13px text-gray-600/70 -ml-9px mr-1"></i>

                    <!-- Text -->
                    <v-link title="Github"
                            :inertia="false"
                            :url="`https://github.com/${prop('account.github')}`">

                        <!-- Text -->
                        {{ prop('account.github') }}

                    </v-link>

                </span>

                <!-- Twitter -->
                <span title="Twitter"
                      v-if="prop('account.twitter')"
                      class="block text-15px text-gray-700">

                    <!-- Icon -->
                    <i class="fab fa-fw fa-twitter text-13px text-sky-600/70 -ml-9px mr-1"></i>

                    <!-- Text -->
                    <v-link title="Twitter"
                            :inertia="false"
                            :url="`https://twitter.com/${prop('account.twitter')}`">

                        <!-- Text -->
                        {{ prop('account.twitter') }}

                    </v-link>

                </span>

                <!-- LinkedIn -->
                <span title="LinkedIn"
                      v-if="prop('account.linkedin')"
                      class="block text-15px text-gray-700">

                    <!-- Icon -->
                    <i class="fab fa-fw fa-linkedin text-13px text-blue-800/70 -ml-9px mr-1"></i>

                    <!-- Text -->
                    <v-link :inertia="false"
                            title="LinkedIn"
                            :url="`https://www.linkedin.com/in/${prop('account.linkedin')}`">

                        <!-- Text -->
                        {{ prop('account.linkedin') }}

                    </v-link>

                </span>

                <!-- Discord -->
                <span title="Discord"
                      v-if="prop('account.discord')"
                      class="block text-15px text-gray-700">

                    <!-- Icon -->
                    <i class="fab fa-fw fa-discord text-13px text-purple-800/70 -ml-9px mr-1"></i>

                    <!-- Link -->
                    <span @click="copyToClipboard(prop('account.discord'))"
                          class="text-sky-600 hover:text-rose-700 transition duration-300 cursor-pointer">

                        <!-- Text -->
                        {{ prop('account.discord') }}

                    </span>

                </span>

                <!-- YouTube -->
                <span title="YouTube"
                      v-if="prop('account.youtube')"
                      class="block text-15px text-gray-700">

                    <!-- Icon -->
                    <i class="fa-fw fas fa-play-circle text-13px text-rose-600/80 -ml-9px mr-1"></i>

                    <!-- Text -->
                    <v-link title="YouTube"
                            :inertia="false"
                            :url="`https://youtube.com/c/${prop('account.youtube')}`">

                        <!-- Text -->
                        {{ prop('account.youtube') }}

                    </v-link>

                </span>

                <!-- Facebook -->
                <span title="Facebook"
                      v-if="prop('account.facebook')"
                      class="block text-15px text-gray-700">

                    <!-- Icon -->
                    <i class="fab fa-fw fa-facebook text-13px text-sky-600/80 -ml-9px mr-1"></i>

                    <!-- Text -->
                    <v-link :inertia="false"
                            title="Facebook"
                            :url="`https://www.facebook.com/${prop('account.facebook')}`">

                        <!-- Text -->
                        {{ prop('account.facebook') }}

                    </v-link>

                </span>

                <!-- Instagram -->
                <span title="Instagram"
                      v-if="prop('account.instagram')"
                      class="block text-15px text-gray-700">

                    <!-- Icon -->
                    <i class="fab fa-fw fa-instagram text-13px text-purple-600/70 -ml-9px mr-1"></i>

                    <!-- Text -->
                    <v-link :inertia="false"
                            title="Instagram"
                            :url="`https://www.instagram.com/${prop('account.instagram')}`">

                        <!-- Text -->
                        {{ prop('account.instagram') }}

                    </v-link>

                </span>

            </div>

        </div>

    </div>
</template>

<script>
    import LinkComponent from '@/components/link.vue';
    import ImageComponent from '@/components/image.vue';
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
            'v-image' : ImageComponent,
            'v-link'  : LinkComponent,
        },

        /**
         * Define the computed properties.
         *
         */
        computed :
        {
            /**
             * Retrieve a shortened form of the user's website.
             *
             */
            website()
            {
                try {
                    return new URL(prop('account.website')).host.replace('www.', '');
                } catch(ex) {
                    return '';
                }
            },
        }
    }
</script>