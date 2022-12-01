<template>
    <div>
        <span :title="title"
              class="uppercase rounded-lg font-semibold inline-block relative md:top-1px select-none cursor-default tracking-relaxed whitespace-nowrap"
              :class="[align, colors[light ? 'light' : 'heavy'][color], small ? 'text-10px px-5px py-2px' : 'text-12px px-10px py-4px', $attrs?.class ?? '']">

            <!-- Icon -->
            <i v-if="filled(icon)"
               class="fas mr-2 opacity-60"
               :class="[`fa-${icon}`, filled(tint) ? tint : colors['light'][color]]">
            </i>

            <!-- Value -->
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
            colors : {
                heavy : {
                    gray   : 'bg-gray-500/10 text-gray-700/90',
                    red    : 'bg-red-500/15 text-red-800/90',
                    blue   : 'bg-sky-500/15 text-sky-700/90',
                    green  : 'bg-emerald-500/15 text-emerald-700/90',
                    orange : 'bg-orange-500/15 text-yellow-700/90',
                    yellow : 'bg-yellow-500/15 text-yellow-700/90',
                    purple : 'bg-purple-500/15 text-purple-900/70',
                },
                light : {
                    gray   : 'text-gray-600',
                    red    : 'text-red-700',
                    blue   : 'text-sky-600',
                    green  : 'text-emerald-600',
                    orange : 'text-amber-600',
                    yellow : 'text-yellow-700',
                    purple : 'text-purple-700',
                }
            }
        }},

        /**
         * Define the public properties.
         *
         */
        props : {
            'icon'  : { type : String,           default : '' },
            'text'  : { type : [String, Number], default : '' },
            'tint'  : { type : String,           default : '' },
            'align' : { type : String,           default : 'text-center' },
            'color' : { type : String,           default : 'none' },
            'light' : { type : Boolean,          default : false },
            'small' : { type : Boolean,          default : false },
            'title' : { type : String,           default : null },
        },
    }
</script>