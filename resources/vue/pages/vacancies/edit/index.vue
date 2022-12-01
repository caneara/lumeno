<template>
    <v-layout>

        <!-- Content -->
        <template #content>

            <!-- Header -->
            <h4>
                Edit Vacancy
            </h4>

            <!-- Information -->
            <p class="mb-10">
                Revise a vacancy within your organization by specifying
                its role, an overall summary of job responsibilities,
                the level of commitment that will be expected, and the
                income that will be offered.
            </p>

            <!-- Sections -->
            <v-position></v-position>
            <v-type></v-type>
            <v-financial></v-financial>
            <v-location></v-location>
            <v-communication></v-communication>
            <v-restrictions></v-restrictions>
            <v-contact></v-contact>
            <v-requirements @change="toggleActionLinks()"></v-requirements>

        </template>

        <!-- Sidebar -->
        <template #sidebar>

            <!-- Text -->
            <span class="block font-medium text-12px text-gray-600/90 uppercase mb-9">
                Jump to section
            </span>

            <!-- Actions -->
            <v-actions :border="false"
                       :items="actions.jump">
            </v-actions>

            <!-- Actions -->
            <v-actions :items="actions.links"></v-actions>

        </template>

    </v-layout>
</template>

<script>
    import TypePartial from './type.vue';
    import Layout from '@/layout/index.vue';
    import ContactPartial from './contact.vue';
    import LocationPartial from './location.vue';
    import PositionPartial from './position.vue';
    import FinancialPartial from './financial.vue';
    import RequirementPartial from './requirements.vue';
    import RestrictionPartial from './restrictions.vue';
    import ButtonComponent from '@/components/button.vue';
    import ActionComponent from '@/components/actions.vue';
    import CommunicationPartial from './communication.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-actions'       : ActionComponent,
            'v-button'        : ButtonComponent,
            'v-communication' : CommunicationPartial,
            'v-contact'       : ContactPartial,
            'v-financial'     : FinancialPartial,
            'v-layout'        : Layout,
            'v-location'      : LocationPartial,
            'v-position'      : PositionPartial,
            'v-requirements'  : RequirementPartial,
            'v-restrictions'  : RestrictionPartial,
            'v-type'          : TypePartial,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            actions : {
                jump : [
                    {
                        id      : 'scroll-position',
                        show    : true,
                        icon    : 'user',
                        color   : 'text-sky-600/70',
                        title   : 'Position',
                        action  : () => document.querySelector('#title-position').scrollIntoView({ behavior : 'smooth', block : 'center' }),
                    }, {
                        id      : 'scroll-type',
                        show    : true,
                        icon    : 'briefcase',
                        color   : 'text-teal-600/70',
                        title   : 'Type',
                        action  : () => document.querySelector('#title-type').scrollIntoView({ behavior : 'smooth', block : 'center' }),
                    }, {
                        id      : 'scroll-financial',
                        show    : true,
                        icon    : 'coins',
                        color   : 'text-yellow-600/70',
                        title   : 'Financial',
                        action  : () => document.querySelector('#title-financial').scrollIntoView({ behavior : 'smooth', block : 'center' }),
                    }, {
                        id      : 'scroll-location',
                        show    : true,
                        icon    : 'map-marker-alt',
                        color   : 'text-red-800/70',
                        title   : 'Location',
                        action  : () => document.querySelector('#title-location').scrollIntoView({ behavior : 'smooth', block : 'center' }),
                    }, {
                        id      : 'scroll-communication',
                        show    : true,
                        icon    : 'language',
                        color   : 'text-indigo-700/60',
                        title   : 'Communication',
                        action  : () => document.querySelector('#title-communication').scrollIntoView({ behavior : 'smooth', block : 'center' }),
                    }, {
                        id      : 'scroll-restrictions',
                        show    : true,
                        icon    : 'filter',
                        color   : 'text-gray-600/70',
                        title   : 'Restrictions',
                        action  : () => document.querySelector('#title-restrictions').scrollIntoView({ behavior : 'smooth', block : 'center' }),
                    }, {
                        id      : 'scroll-requirements',
                        show    : true,
                        icon    : 'tools',
                        color   : 'text-emerald-700/60',
                        title   : 'Requirements',
                        action  : () => document.querySelector('#title-requirements').scrollIntoView({ behavior : 'smooth', block : 'center' }),
                    },
                ],
                links : [
                    {
                        id      : 'back-to-index',
                        show    : true,
                        icon    : 'arrow-left',
                        color   : 'text-gray-700/70',
                        title   : 'View vacancies',
                        summary : 'Back to main directory',
                        action  : () => redirect('vacancies'),
                    }, {
                        id      : 'show-vacancy',
                        show    : !! prop('requirements').length,
                        icon    : 'user-friends',
                        color   : 'text-sky-600/70',
                        title   : 'Find candidates',
                        summary : 'Invite matching workers',
                        action  : () => redirect(['vacancies.show', prop('vacancy.id')]),
                    }, {
                        id      : 'archive-vacancy',
                        show    : true,
                        icon    : 'box-archive',
                        color   : 'text-emerald-600/70',
                        title   : 'Archive vacancy',
                        summary : 'Disable further invitations',
                        action  : () => confirmAction('This will archive the vacancy / make it read only.', () => submit(
                            createInertiaForm(), ['vacancies.archive', prop('vacancy.id')], 'patch')
                        ),
                    }, {
                        id      : 'delete-vacancy',
                        show    : true,
                        icon    : 'trash-alt',
                        color   : 'text-rose-600/70',
                        title   : 'Delete vacancy',
                        summary : 'Remove the vacancy',
                        action  : () => confirmAction('This will delete the vacancy.', () => submit(
                            createInertiaForm(), ['vacancies.delete', prop('vacancy.id')], 'delete')
                        ),
                    },
                ],
            },
        }},

        /**
         * Execute actions when the component is instantiated.
         *
         */
        created()
        {
            session.form = createInertiaForm({
                role            : prop('vacancy.role'),
                summary         : prop('vacancy.summary'),
                commitment      : prop('vacancy.commitment'),
                months          : prop('vacancy.months'),
                currency        : prop('vacancy.currency'),
                remuneration    : prop('vacancy.remuneration'),
                area            : prop('vacancy.area'),
                country         : prop('vacancy.country'),
                coordinates     : prop('vacancy.coordinates'),
                first_language  : prop('vacancy.first_language'),
                second_language : prop('vacancy.second_language'),
                third_language  : prop('vacancy.third_language'),
                remote          : prop('vacancy.remote'),
                emigrate        : prop('vacancy.emigrate'),
                degree          : prop('vacancy.degree'),
                email           : prop('vacancy.email'),
                phone           : prop('vacancy.phone'),
                website         : prop('vacancy.website'),
            }, 'vacancy');
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Update whether one or more action links are visible.
             *
             */
            toggleActionLinks()
            {
                let show = !! prop('requirements').length;

                this.actions.links.find(link => link.id === 'show-vacancy').show = show;
            }
        }
    }
</script>