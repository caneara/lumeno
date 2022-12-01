<template>
    <div>

        <!-- Container -->
        <div v-if="show"
             :class="simple ? 'mt-7' : 'flex flex-col items-center border-t border-gray-300/70 pt-5 mt-9'">

            <!-- EthicalAds -->
            <div :id="id"
                 class="flat"
                 :data-ea-type="type"
                 data-ea-manual="true"
                 data-ea-publisher="lumenodev"
                 :data-ea-keywords="keywords ? keywords.join('|') : null">
            </div>

        </div>

        <!-- Blocked -->
        <div v-if="blocked"
             class="bg-gray-100 flex flex-col items-center rounded-md p-8 mt-6">

            <!-- Icon -->
            <i class="fas fa-ban text-33px text-red-700 mb-6"></i>

            <!-- Title -->
            <h4 class="text-15px text-center mb-3">
                Looks like ads are blocked
            </h4>

            <!-- Summary -->
            <p class="text-13px text-center mb-0">

                <!-- Text -->
                Lumeno uses

                <!-- Link -->
                <v-link :inertia="false"
                        url="https://www.ethicalads.io">

                    <!-- Text -->
                    EthicalAds,

                </v-link>

                <!-- Text -->
                which are relevant, clean, static and free
                of trackers. We therefore kindly ask that
                you whitelist the site.

            </p>

        </div>

    </div>
</template>

<script>
    import LinkComponent from './link.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-link' : LinkComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            show    : false,
            blocked : false,
        }},

        /**
         * Define the public properties.
         *
         */
        props : {
            'id'       : { type : String,  default : null },
            'type'     : { type : String,  default : 'image' },
            'simple'   : { type : Boolean, default : false },
            'target'   : { type : String,  default : '' },
            'keywords' : { type : Array,   default : null },
        },

		/**
		 * Execute actions when the component is mounted to the DOM.
		 *
		 */
		mounted()
		{
            if (this.eligible()) {
                this.display();
            }
		},

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Determine if the adverts are being blocked.
             *
             */
            blocking()
            {
                this.blocked = window.ethicalads === undefined ||
                               document.querySelector('.ea-placement') === null ||
                               document.querySelector('.flat.loaded') === null;
            },

            /**
             * Determine whether an advert should be displayed.
             *
             */
            eligible()
            {
                if (dusk()) {
                    return false;
                }

                if (session.ads === true) {
                    return false;
                }

                if (prop('subscribed', false)) {
                    return false;
                }

                if (this.target === 'mobile' && window.innerWidth < 1024) {
                    return true;
                }

                if (this.target === 'desktop' && window.innerWidth >= 1024) {
                    return true;
                }

                return false;
            },

            /**
             * Render and show an advert to the user.
             *
             */
            display()
            {
                this.show = true;

                session.ads = true;

                loadScript('https://media.ethicalads.io/media/client/ethicalads.min.js');

                when(() => this.ready(), () => window.ethicalads.load());

                setTimeout(() => this.blocking(), 5000);
            },

            /**
             * Determine whether the component is ready to display an advert.
             *
             */
            ready()
            {
                return window.ethicalads &&
                    document.querySelector('[data-ea-publisher="lumenodev"]');
            },
        }
    }
</script>