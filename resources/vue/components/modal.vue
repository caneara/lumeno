<template>
	<div :id="id"
		 :class="hideable ? 'hideable' : ''"
         class="modal fixed top-0 left-0 overflow-x-hidden overflow-y-auto w-full h-full z-1001 transition duration-200 hidden">

		<!-- Background -->
		<div ref="background"
			 @click="closeable ? close() : null"
             class="bg-gray-200 z-1000 opacity-0 fixed inset-0 transition duration-200">
		</div>

		<!-- Content -->
        <div class="flex min-h-screen items-center py-14">

            <!-- Container -->
            <div ref="container"
                 :class="headless ? 'md:max-w-600px lg:max-w-800px xl:max-w-1000px' : 'max-w-600px'"
                 class="relative z-1001 mx-auto transition duration-200 md:rounded-lg md:scale-110">

                <!-- Panel -->
                <div class="bg-white/75 md:rounded-lg"
                     :class="headless ? '' : 'border-y md:border-x border-gray-400/80'">

                    <!-- Slot -->
                    <div :class="headless ? '' : 'p-10 md:p-20'">
                        <slot></slot>
                    </div>

                </div>

            </div>

        </div>

        <!-- Close -->
        <i ref="close"
           @click="close()"
           v-if="closeable"
           dusk="close-modal"
           title="Close the popup"
           class="fas fa-times text-gray-400 hover:text-gray-900 transition duration-200 cursor-pointer text-25px opacity-0 absolute z-1001 top-0 right-0 mr-18px mt-4">
        </i>

	</div>
</template>

<script>
	export default
    {
        /**
         * Define the events.
         *
         */
        emits : ['closed'],

		/**
		 * Define the public properties.
		 *
		 */
		props: {
			'id'        : { type : String,  default : '' },
			'visible'   : { type : Boolean, default : false },
			'headless'  : { type : Boolean, default : false },
			'hideable'  : { type : Boolean, default : false },
			'closeable' : { type : Boolean, default : true },
		},

        /**
         * Define the watch methods.
         *
         */
        watch :
        {
            /**
             * Watch the 'visible' property.
             *
             */
            visible : function(current, previous)
            {
                return current ? this.open() : this.close();
            }
        },

		/**
		 * Execute actions when the component is mounted to the DOM.
		 *
		 */
		mounted()
		{
            events.on(`show-${this.id}`, () => this.open());
            events.on(`hide-${this.id}`, () => this.close());

			if (this.visible) {
                this.open();
            }
		},

        /**
         * Execute actions when the component is unmounted from the DOM.
         *
         */
        unmounted()
        {
            clearEventListener(`show-${this.id}`);
            clearEventListener(`hide-${this.id}`);
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
				setTimeout(() => this.$emit('closed'), 650);
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
		}
	}
</script>