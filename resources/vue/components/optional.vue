<template>
    <span :class="[color, background, padding, margin]"
          class="optional uppercase text-9px rounded-lg relative -top-1-half-px font-sans tracking-wide leading-normal font-normal">

        <!-- Text -->
        Optional

    </span>
</template>

<script>
    export default
    {
        /**
         * Define the public properties.
         *
         */
        props : {
            'color'      : { type : String, default : 'text-gray-500' },
            'margin'     : { type : String, default : 'ml-3' },
            'padding'    : { type : String, default : 'pl-2px pr-5px py-2px' },
            'background' : { type : String, default : 'bg-gray-200/70' },
        },
    }
</script>