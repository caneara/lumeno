<template>
	<div class="confirm fixed top-0 left-0 overflow-x-hidden overflow-y-auto w-full h-full z-1001 transition duration-200 hidden">

		<!-- Background -->
		<div ref="background"
			 @click="close()"
             class="bg-gray-200 z-1000 opacity-0 fixed inset-0 transition duration-200">
		</div>

		<!-- Content -->
        <div class="flex min-h-screen items-center">

            <!-- Container -->
            <div ref="container"
                 class="max-w-600px relative z-1001 mx-auto transition duration-200 md:rounded-lg md:scale-110">

                <!-- Panel -->
                <div class="bg-white/75 border-y md:border-x border-gray-400/80 md:rounded-lg">

                    <!-- Slot -->
                    <div class="p-10 md:p-20">

                        <!-- Title -->
                        <h4>
                            Certain about this?
                        </h4>

                        <!-- Information -->
                        <p class="mb-6">
                            Are you sure you wish to proceed? Note that in
                            most cases, this action is not reversible. If
                            you need help, contact support.
                        </p>

                        <!-- Notice -->
                        <v-alert class="mb-7"
                                 v-if="message"
                                 :spacing="false">

                            <!-- Message -->
                            {{ message }}

                        </v-alert>

                        <!-- Buttons -->
                        <div class="flex justify-end">

                            <!-- No -->
                            <v-button color="gray"
                                      label="Cancel"
                                      scheme="light"
                                      id="confirm-no"
                                      @click="close()">
                            </v-button>

                            <!-- Yes -->
                            <v-button class="ml-6"
                                      @click="yes()"
                                      label="Continue"
                                      id="confirm-yes">
                            </v-button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Close -->
        <i ref="close"
           @click="close()"
           dusk="close-modal"
           title="Close the popup"
           class="fas fa-times text-gray-400 hover:text-gray-900 transition duration-200 cursor-pointer text-25px opacity-0 absolute z-1001 top-0 right-0 mr-18px mt-4">
        </i>

	</div>
</template>

<script>
    import AlertComponent from './alert.vue';
    import ButtonComponent from './button.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-alert'  : AlertComponent,
            'v-button' : ButtonComponent,
        },

        /**
         * Define the public properties.
         *
         */
        props : {
            'message' : { type : String, default : '' },
        },

		/**
		 * Execute actions when the component is mounted to the DOM.
		 *
		 */
		mounted()
		{
            this.open();
		},

		/**
		 * Define the supporting methods.
		 *
		 */
		methods:
        {
			/**
			 * Close the modal window.
			 *
			 */
			close()
			{
				document.body.style.overflow = 'auto';

				this.$refs.container.style.opacity   = 0;
                this.$refs.container.style.transform = 'scale(1.1)';

				setTimeout(() => this.$refs.close.style.opacity = 0, 100);
				setTimeout(() => this.$refs.background.style.opacity = 0, 100);
				setTimeout(() => this.$el.classList.add('hidden'), 600);
				setTimeout(() => this.remove(), 650);
			},

			/**
			 * Open the modal window.
			 *
			 */
			open()
			{
				document.body.style.overflow = 'hidden';

				this.$el.classList.remove('hidden');

				this.$refs.container.style.opacity   = 0;
				this.$refs.container.style.transform = '';

				setTimeout(() => this.$el.scrollTop = 0, 50);
                setTimeout(() => this.$refs.close.style.opacity = 1, 50);
                setTimeout(() => this.$refs.background.style.opacity = 1, 50);
				setTimeout(() => this.$refs.container.style.opacity = 1, 50);
				setTimeout(() => this.$refs.container.style.transform = 'scale(1)', 50);
			},

			/**
			 * Delete the component and remove it from the DOM.
			 *
			 */
			remove()
			{
                if ([...document.body.children].includes(document.getElementById('vue-confirm-component'))) {
                    document.body.removeChild(document.getElementById('vue-confirm-component'));
                }

                window.confirm_action  = null;
                window.confirm_element = null;
			},

            /**
             * Accept the confirmation prompt.
             *
             */
            yes()
            {
                window.confirm_action();

                this.close();
            }
		}
	}
</script>