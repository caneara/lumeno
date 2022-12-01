<template>
    <v-panel :stack="true">

        <!-- Title -->
        <h6>
            Tasks
        </h6>

        <!-- Text -->
        <p class="mb-7">

            <!-- Text -->
            Continue building up your organization by undertaking one of the tasks below. If
            you need help, then

            <!-- Link -->
            <v-link :action="() => window.open(route('guide', { page : 'organization' }))">
                consult the guide
            </v-link>

            <!-- Text -->
            for more information. Video tutorials are also available for each of the tasks.

        </p>

        <!-- Checklist -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2 gap-6">

            <!-- Items -->
            <div v-for="item in checklist"
                 @click="redirect(item.route)"
                 class="flex border border-dashed border-gray-400 hover:bg-sky-50 transition duration-300 rounded-md cursor-pointer px-4 pt-6 pb-5">

                <!-- Icon -->
                <i :class="item.icon"
                   class="fa-fw fas text-24px relative top-2px lg:top-10px xl:top-2px ml-6px">
                </i>

                <!-- Content -->
                <div class="ml-5">

                    <!-- Title -->
                    <h5 class="font-sans font-medium text-17px text-gray-700 mb-2 lg:mb-1 xl:mb-2">
                        {{ item.title }}
                    </h5>

                    <!-- Summary -->
                    <p class="text-15px text-gray-600 mb-0">
                        {{ item.summary }}
                    </p>

                </div>

            </div>

        </div>

    </v-panel>
</template>

<script>
    import LinkComponent from '@/components/link.vue';
    import PanelComponent from '@/components/panel.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-link'  : LinkComponent,
            'v-panel' : PanelComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            checklist : [
                {
                    icon    : 'fa-user-friends text-sky-600/80',
                    title   : 'Add team members',
                    summary : 'Expand your organization by inviting other Lumeno users to join you.',
                    route   : 'members',
                }, {
                    icon    : 'fa-id-card-alt text-purple-600/80',
                    title   : 'List your vacancies',
                    summary : 'Create vacancy listings and invite IT professionals to apply for them.',
                    route   : 'vacancies',
                },
            ],
        }},
    }
</script>