<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Metrics -->
        <div v-for="metric in metrics"
             class="bg-sky-50/80 border border-gray-300 rounded-md px-6 py-5">

            <!-- Name -->
            <h6 class="font-sans text-13px text-teal-700 tracking-normal uppercase">
                {{ metric.name }}
            </h6>

            <!-- Value -->
            <h4 class="font-normal text-22px mb-0">
                {{ round(metric.value) }}
            </h4>

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

        /**
         * Define the data model.
         *
         */
        data() { return {
            metrics : [
                {
                    name  : 'Users',
                    value : prop('metrics.users', 0),
                }, {
                    name  : 'Organizations',
                    value : prop('metrics.organizations', 0),
                }, {
                    name  : 'Subscriptions',
                    value : prop('metrics.subscriptions', 0),
                }, {
                    name  : 'Vacancies',
                    value : prop('metrics.vacancies', 0),
                }, {
                    name  : 'Tools',
                    value : prop('tools.approved', 0) + prop('tools.unapproved', 0),
                },
            ]
        }},
    }
</script>