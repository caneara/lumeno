<template>
    <div @click="redirect('tools')"
         class="flex justify-center items-center border rounded cursor-pointer mb-12 lg:mb-16"
         :class="prop('tools.unapproved') ? 'bg-red-100/60 border-red-700/20' : 'bg-green-600/10 border-emerald-700/20'">

        <!-- Container -->
        <div class="container">
            <div class="py-6">

                <!-- Icon -->
                <i class="fas fa-check mr-3"
                   :class="prop('tools.unapproved') ? 'fa-exclamation-triangle text-red-600' : 'fa-check-circle text-emerald-600'"></i>

                <!-- Status -->
                <span class="font-medium text-17px"
                      :class="prop('tools.unapproved') ? 'text-red-800' : 'text-emerald-800'">

                    <!-- Text -->
                    {{ prop('tools.unapproved', 0) }} {{ singularOrPlural(prop('tools.unapproved'), 'tool') }} awaiting review.

                </span>

            </div>
        </div>

    </div>
</template>

<script>
    import InteractsWithFormatting from '@/mixins/InteractsWithFormatting';

    export default
    {
        /**
         * Define the mixins.
         *
         */
        mixins : [
            InteractsWithFormatting,
        ],
    }
</script>
