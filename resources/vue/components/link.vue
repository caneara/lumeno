<template>
    <span>

        <!-- External -->
        <a :rel="rel"
           :href="url"
           :title="title"
           :target="target"
           :class="$attrs?.class ?? ''"
           v-if="! inertia && blank(action)">

            <!-- Slot -->
            <slot></slot>

        </a>

        <!-- Internal -->
        <a :href="url"
           :title="title"
           @click.prevent="visit($event)"
           v-if="inertia && blank(action)"
           class="transition duration-300 cursor-pointer"
           :class="$attrs?.class ?? 'text-sky-600 hover:text-rose-700'">

            <!-- Slot -->
            <slot></slot>

        </a>

        <!-- Action -->
        <span :dusk="id"
              :title="title"
              v-if="filled(action)"
              @click="action($event)"
              class="transition duration-300 cursor-pointer"
              :class="$attrs?.class ?? 'text-sky-600 hover:text-rose-700'">

            <!-- Slot -->
            <slot></slot>

        </span>

    </span>
</template>

<script>
    export default
    {
        /**
         * Disable attribute inheritance.
         *
         */
        inheritAttrs : false,

        /**
         * Define the public properties.
         *
         */
        props : {
            'id'      : { type : String,   default : '' },
            'rel'     : { type : String,   default : 'noreferer noopener' },
            'url'     : { type : String,   default : '' },
            'title'   : { type : String,   default : '' },
            'action'  : { type : Function, default : null },
            'scroll'  : { type : Boolean,  default : false },
            'target'  : { type : String,   default : '_blank' },
            'inertia' : { type : Boolean,  default : true },
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Handle the link being clicked.
             *
             */
            visit(event)
            {
                if (event.altKey || event.ctrlKey || event.shiftKey || event.metaKey) {
                    return window.open(this.url, '_blank');
                }

                this.$inertia.get(this.url, {}, {
                    replace        : false,
                    preserveState  : false,
                    preserveScroll : this.scroll,
                    only           : [],
                    headers        : {},
                    errorBag       : null,
                    forceFormData  : false,
                });
            }
        }
    }
</script>