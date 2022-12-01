<template>
    <div @click="redirect(url)"
         class="statistic mb-6 flex items-center"
         :class="url ? 'cursor-pointer group' : ''">

        <!-- Icon -->
        <i v-if="filled(icon)"
           class="fa-fw text-15px mr-3 -ml-6px"
           :class="[color, icon.includes(' ') ? `fa-${icon}` : `fa-${icon} fas`]">
        </i>

        <!-- Image -->
        <img :src="graphic"
             v-if="filled(graphic)"
             @error="graphic = fallback"
             class="rounded w-20px mr-17px" />

        <!-- Text -->
        <span class="text-15px font-medium text-gray-700 group-hover:text-sky-700 transition duration-300">
            {{ text }}
        </span>

    </div>
</template>

<script>
    export default
    {
        /**
         * Define the data model.
         *
         */
        data() { return {
            graphic : this.image,
        }},

        /**
         * Define the public properties.
         *
         */
        props : {
            'url'      : { type : String, default : '' },
            'icon'     : { type : String, default : '' },
            'text'     : { type : String, default : '' },
            'color'    : { type : String, default : 'text-gray-500' },
            'image'    : { type : String, default : '' },
            'fallback' : { type : String, default : '' },
        },
    }
</script>