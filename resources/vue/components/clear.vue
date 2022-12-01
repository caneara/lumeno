<template>
    <span v-if="! dusk()"
          style="transition: all 0.4s ease, background-color 0s"
          class="clear block absolute right-0 top-0 bg-inherit rounded-r w-[47px]"
          :class="[small ? 'h-[33px]' : 'h-50px', (focus && value) || (hover && value) ? 'opacity-100 pointer-events-auto z-2' : 'opacity-0 pointer-events-none']">

        <!-- Icon -->
        <i title="Clear this field"
           @click.stop="$emit('clear')"
           :class="small ? 'top-10px right-12px text-15px' : 'top-19px right-17px'"
           class="fas fa-times absolute text-gray-400 hover:text-gray-600 cursor-pointer transition duration-400">
        </i>

    </span>
</template>

<script>
    export default
    {
        /**
         * Define the events.
         *
         */
        emits : ['clear'],

        /**
         * Define the public properties.
         *
         */
        props : {
            'hover' : { type : Boolean, default : false },
            'focus' : { type : Boolean, default : false },
            'small' : { type : Boolean, default : false },
            'value' : { type : Boolean, default : false },
        }
    }
</script>