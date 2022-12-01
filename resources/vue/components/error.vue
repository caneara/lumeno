<template>
    <label v-html="content"
           v-if="filled(message)"
           class="validation-error block text-red-700 text-12px font-semibold my-2 uppercase tracking-wide text-right">
    </label>
</template>

<script>
    export default
    {
        /**
         * Define the public properties.
         *
         */
        props : {
            'message' : { type : String, default : '' },
        },

        /**
         * Define the computed properties.
         *
         */
        computed :
        {
            /**
             * Eliminate any script injection and introduce line breaks.
             *
             */
            content()
            {
                return this.message.replace(/</g, '&lt;').replace(/>/g, '&gt;').replaceAll("\n", '<br />');
            },
        },

        /**
         * Define the watch methods.
         *
         */
        watch :
        {
            /**
             * Watch the 'message' data attribute.
             *
             */
            message : function(current, previous)
            {
                if (blank(current)) return;

                this.$nextTick(() => this.checkIfFirstOnPage());
            }
        },

		/**
		 * Define the supporting methods.
		 *
		 */
		methods :
        {
            /**
             * Determine whether the error is the first on the page.
             *
             */
            checkIfFirstOnPage()
            {
                if (! document.querySelector('.validation-error').isSameNode(this.$el)) return;

                setTimeout(() => this.scrollToError(), this.ensureErrorIsVisible() ? 100 : 0);
            },

			/**
			 * Hide any modals that might prevent the error from being seen.
			 *
			 */
			closeAnyModals()
			{
                document.querySelectorAll('.modal.hideable')
                    .forEach(modal => events.emit(`hide-${modal.id}`));
			},

            /**
             * Make sure that the user can see the error.
             *
             */
            ensureErrorIsVisible()
            {
                this.switchToTab();
                this.closeAnyModals();
            },

            /**
             * Adjust the viewport to see the error.
             *
             */
            scrollToError()
            {
                this.$el.scrollIntoView({
                    behavior : 'smooth',
                    block    : 'center',
                });
            },

			/**
			 * Select the tab containing the error.
			 *
			 */
			switchToTab()
			{
                let element = this.$el.closest('.tab.hidden');

                if (element) {
                    events.emit('switch-to-tab', element.dataset.tab);
                }

                return element !== null;
			},
		}
    }
</script>