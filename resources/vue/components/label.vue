<template>
    <label class="label absolute select-none pointer-events-none cursor-text"
           :class="[small ? 'small' : '', value ? (small ? 'hidden' : 'populated') : focus && transition ? (small ? 'hidden' : 'populated') : 'unpopulated']">

        <!-- Small -->
        <span class="ml-10px"
              v-if="blank(icon) && small">

            <!-- Text -->
            {{ label }}

        </span>

        <!-- Normal -->
        <span v-else>

            <!-- Icon -->
            <i class="fa-fw text-14px text-gray-500/60"
               :class="[icon.includes(' ') ? `fa-${icon}` : `fa-${icon} fas`, small ? 'mr-2px' : 'mr-2']">
            </i>

            <!-- Text -->
            {{ label }}

            <!-- Optional -->
            <v-optional v-if="optional"></v-optional>

        </span>

    </label>
</template>

<script>
    import OptionalComponent from './optional.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-optional' : OptionalComponent,
        },

        /**
         * Define the public properties.
         *
         */
        props : {
            'icon'       : { type : String,  default : '' },
            'focus'      : { type : Boolean, default : false },
            'label'      : { type : String,  default : 'Component' },
            'small'      : { type : Boolean, default : false },
            'value'      : { type : Boolean, default : false },
            'optional'   : { type : Boolean, default : false },
            'transition' : { type : Boolean, default : true },
        },
    }
</script>