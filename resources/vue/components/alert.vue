<template>
    <div v-if="show"
         class="alert"
         :class="[spacing ? 'mb-7' : '', minimal ? 'flex' : '']">

        <!-- Background -->
        <div class="bg-white relative rounded-lg">
            <div class="leading-normal text-gray-800 flex items-start"
                 :class="[
                    font,
                    scheme[color],
                    border ? 'border rounded-md' : 'rounded-md',
                    minimal ? 'pl-1 pr-3 pt-2 pb-9px' : 'pl-12px pr-8 pt-4 pb-15px'
                 ]">

                <!-- Icon -->
                <i @click="hide()"
                   :title="remove ? 'Hide notice' : ''"
                   class="fas fa-fw opacity-75 relative transition duration-300"
                   :class="[remove ? 'fa-times top-5px text-gray-600 hover:text-gray-800 cursor-pointer' : icon[color], minimal ? 'mr-2px' : 'mr-2']">
                </i>

                <!-- Content -->
                <div class="block leading-relaxed">
                    <slot></slot>
                </div>

            </div>
        </div>

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
            show   : this.visible,
            scheme : {
                red    : 'bg-red-100/60 border-red-600/70',
                blue   : 'bg-sky-200/30 border-sky-600/70',
                green  : 'bg-green-600/10 border-emerald-600/70',
                orange : 'bg-orange-100/55 border-yellow-600/45',
            },
            icon : {
                green  : 'fa-check-circle text-emerald-600 top-5px',
                red    : 'fa-times-circle text-red-600 top-5px',
                blue   : 'fa-info-circle text-sky-600 top-5px',
                orange : 'fa-exclamation-triangle text-yellow-600 top-5px',
            },
        }},

        /**
         * Define the public properties.
         *
         */
        props : {
            'id'      : { type : String,  default : 'id' },
            'color'   : { type : String,  default : 'orange' },
            'font'    : { type : String,  default : 'text-15px' },
            'border'  : { type : Boolean, default : true },
            'remove'  : { type : Boolean, default : false },
            'spacing' : { type : Boolean, default : true },
            'minimal' : { type : Boolean, default : false },
            'visible' : { type : Boolean, default : true },
        },

        /**
         * Execute actions when the component is instantiated.
         *
         */
        created()
        {
            if (filled(window.localStorage.getItem(`hide_alert_${this.id}`))) {
                this.show = false;
            }
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Hide the alert on demand.
             *
             */
            hide()
            {
                if (! this.remove) return;

                this.show = false;

                window.localStorage.setItem(`hide_alert_${this.id}`, 1);
            }
        }
    }
</script>