<template>
    <div class="checkbox">

        <!-- Control -->
        <div class="w-full flex items-center justify-between">

            <!-- Hidden -->
            <input :id="name"
                   :name="name"
                   type="hidden"
                   :value="positive.includes(modelValue) ? 1 : 0">

            <!-- Label -->
            <label class="text-gray-600/75 text-13px font-medium mr-5 uppercase tracking-wide pt-1px">
                {{ label }}
            </label>

            <!-- Field -->
            <button :dusk="name"
                    :id="`btn-${name}`"
                    @click.prevent="change(positive.includes(modelValue) ? 0 : 1)"
                    class="field relative transition-all duration-200 cursor-pointer w-15 rounded-pill h-[31px]
                           after:bg-white after:absolute after:transition-all after:duration-200
                           after:top-3px after:left-3px after:h-25px after:w-25px after:rounded-pill"
                    :class="positive.includes(modelValue) ? 'active after:left-[32px] bg-emerald-600/80' : 'bg-gray-400/65'">
            </button>

        </div>

        <!-- Error -->
        <v-error :message="message"></v-error>

    </div>
</template>

<script>
    import ErrorComponent from './error.vue';
    import InteractsWithField from '@/mixins/InteractsWithField';

    export default
    {
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
         * Define the data model.
         *
         */
        data() { return {
            positive : ['1', 'true', 'yes', 'on', 1, true],
        }},

        /**
         * Define the public properties.
         *
         */
        props : {
            'modelValue' : { type : [String, Number, Boolean], default : '' },
        },
    }
</script>