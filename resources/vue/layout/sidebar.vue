<template>
    <div v-if="open"
         class="sidebar w-full md:w-350px bg-white md:border-l border-gray-300 overflow-y-auto
                fixed z-10 top-[103px] bottom-0 right-0 p-6 md:p-10">

        <!-- Slot -->
        <slot></slot>

    </div>
</template>

<script>
    import InteractsWithOutside from '@/mixins/InteractsWithOutside';

    export default
    {
        /**
         * Define the mixins.
         *
         */
        mixins : [
            InteractsWithOutside,
        ],

        /**
         * Define the events.
         *
         */
        emits : ['closed'],

        /**
         * Define the public properties.
         *
         */
        props : {
            'open' : { type : Boolean, default : false },
        },

		/**
		 * Execute actions when the component is mounted to the DOM.
		 *
		 */
		mounted()
		{
            events.on('close-sidebar', () => this.closeComponent());
		},

        /**
         * Execute actions when the component is unmounted from the DOM.
         *
         */
        unmounted()
        {
            clearEventListener('close-sidebar');
        },

		/**
		 * Define the supporting methods.
		 *
		 */
		methods:
        {
	    	/**
	    	 * Hide the component.
	    	 *
	    	 */
	    	closeComponent()
	    	{
                this.$emit('closed');
	    	},

	    	/**
	    	 * Determine if the component is open or visible.
	    	 *
	    	 */
	    	isComponentOpen()
	    	{
                return this.open;
	    	},
        },
    }
</script>