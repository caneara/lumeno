<template>
    <div v-if="visible"
         :class="[border ? spacing : '', border ? 'border border-dashed border-gray-400/75' : '']"
         class="bg-gray-100/30 flex flex-col justify-center items-center rounded p-8 pt-10 md:pt-14 md:pb-12">

        <!-- Icon -->
        <img class="h-100px mb-6"
             :src="asset('img/placeholder.svg')">

        <!-- Title -->
        <h4 v-if="title"
            class="font-medium text-18px mb-2">

            <!-- Text -->
            {{ title }}

        </h4>

        <!-- Message -->
        <span class="text-15px text-gray-600 text-center leading-normal max-w-450px">

            <!-- Text -->
            {{ message }}

            <!-- Slot -->
            <slot></slot>

        </span>

        <!-- Action -->
        <v-button color="blue"
                  scheme="light"
                  class="mt-4 -mb-3"
                  v-if="filled(action)"
                  @click="action['command']()"
                  :label="action?.text ?? 'Add One Now'">
        </v-button>

    </div>
</template>

<script>
    import ButtonComponent from './button.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-button' : ButtonComponent,
        },

		/**
		 * Define the public properties.
		 *
		 */
		props : {
			'icon'    : { type : String,  default : 'file' },
			'title'   : { type : String,  default : 'Nothing to show' },
            'action'  : { type : Object,  default : {} },
			'border'  : { type : Boolean, default : true },
			'message' : { type : String,  default : 'There are no items to display' },
			'spacing' : { type : String,  default : 'mb-4' },
			'visible' : { type : Boolean, default : false },
		},
    }
</script>