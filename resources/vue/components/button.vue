<template>
    <div class="button">

        <!-- Classic -->
        <button ref="btn"
                class="hidden">
        </button>

        <!-- Control -->
        <div ref="button"
             :dusk="name"
             :style="theme"
             :id="`btn-${name}`"
             @mouseover="hover = true"
             @mouseout="hover = false"
             @click="classic ? $refs.btn.click() : execute()"
             class="control flex items-center justify-center relative rounded transition-all min-h-[35px]"
             :class="[
                color,
                disabled ? 'opacity-20' : '',
                scheme === 'light' ? 'duration-100' : 'duration-300',
                processing ? 'transition-none cursor-wait opacity-60' : (disabled ? 'cursor-not-allowed' : 'cursor-pointer'),
             ]">

            <!-- Label -->
            <span :class="[processing ? 'text-transparent hidden' : '', scheme === 'light' ? 'duration-100' : 'px-5']"
                  class="label text-14px font-semibold uppercase transition-all block relative top-half-px whitespace-nowrap select-none">

                <!-- Icon -->
                <i :class="[set, `fa-${icon}`]"
                   v-if="icon && align === 'left'"
                   class="mr-3 opacity-50 relative">
                </i>

                <!-- Text -->
                {{ label }}

                <!-- Icon -->
                <i :class="[set, `fa-${icon}`]"
                   v-if="icon && align === 'right'"
                   class="ml-3 opacity-90 relative">
                </i>

            </span>

            <!-- Animation -->
            <span :class="processing ? 'block' : 'hidden'"
                  style="animation: spin 750ms infinite linear"
                  class="h-15px w-15px rounded-full border-2 border-r-transparent border-t-transparent"
                  :style="scheme === 'heavy' ? 'border-left-color: #FFFFFF; border-bottom-color: #FFFFFF'
                                             : `border-left-color: #${schemes[scheme]['default']};
                                                border-bottom-color: #${schemes[scheme]['default']}`">
            </span>

        </div>

    </div>
</template>

<script>
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
         * Define the data model.
         *
         */
        data() { return {
            hover   : false,
            schemes : {
                heavy : {
                    blue   : { default : '#3283CF', hover : '#0369A1', text : '#FFFFFF', border : null },
                    red    : { default : '#D73636', hover : '#B32D2D', text : '#FFFFFF', border : null },
                    orange : { default : '#DF9558', hover : '#BF7538', text : '#FFFFFF', border : null },
                    green  : { default : '#15803D', hover : '#0D662F', text : '#FFFFFF', border : null },
                    purple : { default : '#9378D2', hover : '#7358B2', text : '#FFFFFF', border : null },
                    teal   : { default : '#4C9A9B', hover : '#2C7A7B', text : '#FFFFFF', border : null },
                    gray   : { default : '#8599AA', hover : '#65798A', text : '#FFFFFF', border : null },
                },
                light : {
                    blue   : { default : '#0284C7',   hover : '#0369A1', border : null },
                    red    : { default : '#C8594F',   hover : '#A8392F', border : null },
                    orange : { default : '#DF9558',   hover : '#BF7538', border : null },
                    green  : { default : '#548C58',   hover : '#346C38', border : null },
                    purple : { default : '#9378D2',   hover : '#7358B2', border : null },
                    teal   : { default : '#4C9A9B',   hover : '#2C7A7B', border : null },
                    gray   : { default : '#8599AA',   hover : '#65798A', border : null },
                    white  : { default : '#E2E8F0CC', hover : '#FFFFFF', border : null },
                }
            }
        }},

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
            'id'         : { type : String,  default : '' },
            'set'        : { type : String,  default : 'fas' },
            'icon'       : { type : String,  default : '' },
            'align'      : { type : String,  default : 'left' },
            'color'      : { type : String,  default : 'blue' },
            'scheme'     : { type : String,  default : 'heavy' },
            'classic'    : { type : Boolean, default : false },
            'disabled'   : { type : Boolean, default : false },
            'processing' : { type : Boolean, default : false },
        },

        /**
         * Define the computed properties.
         *
         */
        computed :
        {
            /**
             * Determine the appropriate styles for the component.
             *
             */
            theme()
            {
                let scheme = this.schemes[this.scheme][this.color];

                let width = this.scheme === 'light'
                          ? 'margin-left: 5px; margin-right: 5px'
                          : 'min-width: 110px';

                let border = scheme.border ? `;border:solid 1px ${scheme.border}` : '';

                if (this.scheme === 'light') {
                    return this.processing
                         ? `;color:${scheme.default};${width}${border}`
                         : `;color:${this.hover ? scheme.hover : scheme.default};${width}${border}`;
                }

                return this.processing
                     ? `;background-color:${scheme.hover};color:${scheme.default};${width}${border}`
                     : `;background-color:${this.hover ? scheme.hover : scheme.default};color:${this.hover ? '#FFFFFF' : scheme.text};${width}${border}`;
            }
        },

        /**
         * Define the watch methods.
         *
         */
        watch :
        {
            /**
             * Watch the 'processing' data attribute.
             *
             */
            processing : function(current, previous)
            {
                this.$refs.button.style.width = current ? `${this.$refs.button.offsetWidth}px` : '';
            }
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Handle the button being clicked.
             *
             */
            execute()
            {
                if (! this.disabled && ! this.processing) {
                    this.$emit('click');
                }
            }
        }
    }
</script>