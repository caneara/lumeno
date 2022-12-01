<template>
    <div class="cards">

        <!-- Cards -->
        <div v-bind="$attrs"
             class="grid gap-4">

            <!-- Card -->
            <div v-for="item in items"
                 @click="execute(item)"
                 :dusk="`card-${name}-${item.id.toString().toLowerCase()}`"
                 class="rounded-md border px-6 pt-5 pb-4 cursor-pointer transition duration-300"
                 :class="
                    item.id === modelValue
                    ? 'border-sky-500 bg-white'
                    : 'border-gray-400/75 bg-white hover:border-gray-500/100'
                 ">

                <!-- Header -->
                <div class="flex">

                    <!-- Icon -->
                    <div class="mr-4">
                        <i class="fas transition duration-300 relative"
                           :class="[item?.css, `fa-${item.icon}`, item.id === modelValue ? 'text-sky-600/70' : 'text-gray-500/70']">
                        </i>
                    </div>

                    <!-- Title -->
                    <h5 :class="item.id === modelValue ? 'text-sky-700' : 'text-gray-700/90'"
                        class="transition duration-300 tracking-normal font-sans font-semibold uppercase text-13px">
                        {{ item?.title ?? item.name }}
                    </h5>

                </div>

                <!-- Description -->
                <p class="mb-0 transition duration-300 text-15px"
                   :class="item.id === modelValue ? '' : 'text-gray-600'">
                    {{ item?.description ?? item.summary }}
                </p>

            </div>

        </div>

        <!-- Error -->
        <v-error class="-mt-2 mb-6"
                 :message="message">
        </v-error>

    </div>
</template>

<script>
    import ErrorComponent from './error.vue';
    import InteractsWithField from '@/mixins/InteractsWithField';

    export default
    {
        /**
         * Disable attribute inheritance.
         *
         */
        inheritAttrs: false,

        /**
         * Define the mixins.
         *
         */
        mixins : [
            InteractsWithField,
        ],

        /**
         * Define the components.
         *
         */
        components : {
            'v-error' : ErrorComponent,
        },

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
            'items' : { type : Array, default : [] },
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Handle a card being clicked.
             *
             */
            execute(item)
            {
                if (item.id === this.modelValue) return;

                this.change(item.id);

                this.$emit('click', item.id);
            }
        }
    }
</script>