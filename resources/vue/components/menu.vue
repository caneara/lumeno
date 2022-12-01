<template>
    <div class="menu items-center ml-6 md:ml-8 flex relative">

        <!-- Link -->
        <div ref="trigger"
             @click="open = ! open"
             :dusk="`menu-${id.toLowerCase()}`"
             class="trigger uppercase relative select-none cursor-pointer text-13px top-1px
                    text-gray-500 hover:text-gray-800 transition duration-300 whitespace-nowrap">

            <!-- Icon -->
            <i title="Options"
               class="trigger-item icon fas fa-ellipsis-h text-17px">
            </i>

        </div>

        <!-- Drawer -->
        <div class="drawer bg-white absolute flex flex-col transition-all duration-300 py-2 rounded border border-gray-400/80"
             :class="[
                open ? 'opacity-100 scale-100 pointer-events-auto z-20' : 'opacity-0 scale-90 pointer-events-none z-minus-1',
                position,
             ]">

            <!-- Slot -->
            <div v-for="item in (items.filter(item => item.show).length ? items : blank)">

                <!-- Link -->
                <a :dusk="item.id"
                   v-if="item.show && item.type === 'link'"
                   @click.stop="open = false; item['action']()"
                   class="option text-15px select-none block whitespace-nowrap cursor-pointer
                          py-2 pl-5 pr-8 text-gray-700/85 hover:text-gray-700 hover:bg-gray-200/75">

                    <!-- Content -->
                    <span>

                        <!-- Icon -->
                        <i v-if="filled(item.icon)"
                           class="fa-fw text-14px mr-1 relative text-gray-500/50"
                           :class="item.icon.includes(' ') ? `fa-${item.icon}` : `fa-${item.icon} fas`">
                        </i>

                        <!-- Text -->
                        {{ item.label }}

                    </span>

                </a>

                <!-- Separator -->
                <div class="my-2 border-t border-gray-300"
                     v-if="item.show && item.type === 'separator'">
                </div>

                <!-- Blank -->
                <div v-if="item.show && item.type === 'blank'"
                     class="option text-13px select-none block whitespace-nowrap cursor-pointer uppercase pt-2 pb-5px px-6 text-gray-600/65">
                    No Options Available
                </div>

            </div>

        </div>

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
         * Define the data model.
         *
         */
        data() { return {
            open     : false,
            position : '',
            blank    : [{ type : 'blank', show : true }],
        }},

        /**
         * Define the public properties.
         *
         */
        props : {
            'id'      : { type : String,  default : 'Options' },
            'items'   : { type : Array,   default : [] },
            'context' : { type : Boolean, default : true },
            'padding' : { type : Boolean, default : false },
        },

        /**
         * Execute actions when the component is mounted to the DOM.
         *
         */
        mounted()
        {
            this.setOrientation();

            window.events.on(`show-menu-${this.id}`, () => this.open = true);
        },

        /**
         * Execute actions when the component is unmounted from the DOM.
         *
         */
        unmounted()
        {
            clearEventListener(`show-menu-${this.id}`);
        },

        /**
         * Define the watch methods.
         *
         */
        watch :
        {
            /**
             * Watch the 'items' data attribute.
             *
             */
            items : function(current, previous)
            {
                this.setOrientation();
            }
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Close or hide the component.
             *
             */
            closeComponent()
            {
                this.open = false;
            },

            /**
             * Determine if the component is open or visible.
             *
             */
            isComponentOpen()
            {
                return this.open;
            },

            /**
             * Determine if the menu is too close to the bottom of the page to display all its contents.
             *
             */
            nearBottom()
            {
                let height = this.items.length * 30;

                let vertical = this.$refs.trigger.getBoundingClientRect().bottom + (window.pageYOffset || document.body.scrollTop);

                return ((document.body.scrollHeight - vertical) - height) <= 10;
            },

            /**
             * Determine if the menu is too close to the left of the page to display all its contents.
             *
             */
            nearLeft()
            {
                let horizontal = this.$refs.trigger.getBoundingClientRect().left + (window.pageXOffset || document.body.scrollLeft);

                return horizontal <= 150;
            },

            /**
             * Set the position of the menu.
             *
             */
            setOrientation()
            {
                if (! this.context) return;

                if (this.nearLeft() && this.nearBottom()) {
                    return this.position = 'origin-bottom-left left-0 bottom-8';
                } else if (this.nearLeft()) {
                    return this.position = 'origin-top-left left-0 top-8';
                } else if (this.nearBottom()) {
                    return this.position = 'origin-bottom-right -right-3 bottom-8';
                } else {
                    return this.position = 'origin-top-right -right-3 top-8';
                }
            },
        }
    }
</script>