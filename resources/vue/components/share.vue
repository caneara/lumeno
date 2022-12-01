<template>
    <v-modal :visible="true"
             @closed="remove()">

        <!-- Title -->
        <h4 class="text-center">
            Share a link with others
        </h4>

        <!-- Information -->
        <p class="text-center mb-8">
            Select one of the available platforms to share the link on.
            You can also send the link via email, or copy it to the clipboard.
        </p>

        <!-- Platforms -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

            <!-- Twitter -->
            <div @click="visit(`https://twitter.com/intent/tweet?url=${url}`)"
                 class="bg-white hover:bg-orange-100/25 transition duration-300 cursor-pointer border
                        border-gray-300 rounded-md px-6 py-3 flex items-center">

                <!-- Icon -->
                <i class="fa-fw fab fa-twitter text-18px text-sky-500 -ml-2"></i>

                <!-- Text -->
                <span class="text-15px text-gray-700 ml-2">
                    Share on Twitter
                </span>

            </div>

            <!-- Facebook -->
            <div @click="visit(`https://www.facebook.com/sharer/sharer.php?u=${url}`)"
                 class="bg-white hover:bg-orange-100/25 transition duration-300 cursor-pointer border
                        border-gray-300 rounded-md px-6 py-3 flex items-center">

                <!-- Icon -->
                <i class="fa-fw fab fa-facebook text-18px text-blue-800/80 -ml-2"></i>

                <!-- Text -->
                <span class="text-15px text-gray-700 ml-2">
                    Share on Facebook
                </span>

            </div>

            <!-- Reddit -->
            <div @click="visit(`https://reddit.com/submit?url=${url}`)"
                 class="bg-white hover:bg-orange-100/25 transition duration-300 cursor-pointer border
                        border-gray-300 rounded-md px-6 py-3 flex items-center">

                <!-- Icon -->
                <i class="fa-fw fab fa-reddit-alien text-18px text-red-700/80 -ml-2"></i>

                <!-- Text -->
                <span class="text-15px text-gray-700 ml-2">
                    Share on Reddit
                </span>

            </div>

            <!-- LinkedIn -->
            <div @click="visit(`https://www.linkedin.com/shareArticle?mini=true&url=${url}`)"
                 class="bg-white hover:bg-orange-100/25 transition duration-300 cursor-pointer border
                        border-gray-300 rounded-md px-6 py-3 flex items-center">

                <!-- Icon -->
                <i class="fa-fw fab fa-linkedin text-18px text-blue-600/80 -ml-2"></i>

                <!-- Text -->
                <span class="text-15px text-gray-700 ml-2">
                    Share on LinkedIn
                </span>

            </div>

            <!-- Email -->
            <div @click="email()"
                 class="bg-white hover:bg-orange-100/25 transition duration-300 cursor-pointer border
                        border-gray-300 rounded-md px-6 py-3 flex items-center">

                <!-- Icon -->
                <i class="fa-fw fas fa-envelope text-16px text-emerald-600/80 -ml-2 relative top-1px"></i>

                <!-- Text -->
                <span class="text-15px text-gray-700 ml-2">
                    Send via email
                </span>

            </div>

            <!-- Copy -->
            <div @click="copy()"
                 class="bg-white hover:bg-orange-100/25 transition duration-300 cursor-pointer border
                        border-gray-300 rounded-md px-6 py-3 flex items-center">

                <!-- Icon -->
                <i class="fa-fw fas fa-link text-14px text-gray-500 -ml-2 relative top-1px"></i>

                <!-- Text -->
                <span class="text-15px text-gray-700 ml-2">
                    Copy to clipboard
                </span>

            </div>

        </div>

    </v-modal>
</template>

<script>
    import ModalComponent from './modal.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-modal' : ModalComponent,
        },

        /**
         * Define the public properties.
         *
         */
        props : {
            'url' : { type : String, default : '' },
        },

		/**
		 * Define the supporting methods.
		 *
		 */
		methods:
        {
			/**
			 * Copy the url to the clipboard.
			 *
			 */
			copy()
			{
                copyToClipboard(this.url);
			},

			/**
			 * Send the url via email.
			 *
			 */
			email()
			{
                window.location.href = `mailto:?body=${this.url}`;
			},

			/**
			 * Delete the component and remove it from the DOM.
			 *
			 */
			remove()
			{
                if ([...document.body.children].includes(document.getElementById('vue-share-component'))) {
                    document.body.removeChild(document.getElementById('vue-share-component'));
                }

                window.notice_element = null;
			},

			/**
			 * Share the url on the given platform.
			 *
			 */
			visit(platform)
			{
                let popup = window.open('', '_blank', 'width=550,height=420');

                popup.opener = null;

                popup.location = platform;
			},
        }
    }
</script>