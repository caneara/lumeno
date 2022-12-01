<template>
    <div class="actions"
         :class="border ? 'border-t border-gray-300/70 pt-9 mt-9' : ''"
         v-show="filled(items) && filled(items.filter(item => typeof item.show === 'boolean' ? item.show : item['show']()))">

        <!-- Actions -->
        <div :key="item?.id ?? ''"
             v-for="item in items"
             @click="execute(item)"
             :dusk="`action-${item.id}`"
             :class="item?.type === 'separator' ? '' : 'cursor-pointer group'"
             v-show="typeof item.show === 'boolean' ? item.show : item['show']()">

            <!-- Separator -->
            <span v-if="item?.type === 'separator'"
                  class="block border-t border-gray-300/70 font-medium text-12px text-gray-600/90 uppercase my-9">
            </span>

            <!-- Action -->
            <div class="mb-7 flex items-center"
                 v-if="item?.type !== 'separator'">

                <!-- Icon -->
                <i class="fas fa-fw -ml-6px text-15px opacity-80"
                   :class="[item?.color ?? 'text-gray-400', `fa-${item.icon}`]">
                </i>

                <!-- Details -->
                <div class="ml-3">

                    <!-- Title -->
                    <span class="block text-15px font-semibold text-gray-800">
                        {{ typeof item.title === 'string' ? item.title : item['title']() }}
                    </span>

                    <!-- Summary -->
                    <span v-if="filled(item.summary)"
                          class="text-13px text-gray-600 block mt-6px">

                        <!-- Text -->
                        {{ typeof item.summary === 'string' ? item.summary : item['summary']() }}

                    </span>

                </div>

            </div>

        </div>

    </div>
</template>

<script>
    export default
    {
        /**
         * Define the events.
         *
         */
        emits : ['click'],

        /**
         * Define the public properties.
         *
         */
        props : {
            'items'  : { type : Array,   default : [] },
            'border' : { type : Boolean, default : true },
        },

		/**
		 * Define the supporting methods.
		 *
		 */
		methods:
        {
	    	/**
	    	 * Handle the action being clicked.
	    	 *
	    	 */
	    	execute(item)
	    	{
                events.emit('close-sidebar');

                this.$emit('click', item['action']());
	    	},
        },
    }
</script>