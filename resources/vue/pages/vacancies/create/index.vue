<template>
    <v-layout>

        <!-- Content -->
        <template #content>

            <!-- Header -->
            <h4>
                Create Vacancy
            </h4>

            <!-- Information -->
            <p class="mb-10">
                Add a new vacancy to your organization by specifying
                its role, an overall summary of job responsibilities,
                the level of commitment that will be expected, and the
                income that will be offered.
            </p>

            <!-- Notice -->
            <v-alert class="mb-4"
                     :remove="true"
                     :spacing="false"
                     id="vacancies_read_guide_before_creation">

                <!-- Text -->
                Before creating a vacancy, it is strongly recommended that you first

                <!-- Link -->
                <v-link :action="() => window.open(`${route('guide', { page : 'vacancies' })}`)">
                    review the vacancy guide,
                </v-link>

                <!-- Text -->
                as Lumeno has several vacancy rules in place which, if violated, may
                result in your organization being banned.

            </v-alert>

            <!-- Sections -->
            <v-position></v-position>
            <v-type></v-type>
            <v-financial></v-financial>
            <v-location></v-location>
            <v-communication></v-communication>
            <v-restrictions></v-restrictions>
            <v-contact></v-contact>

            <!-- Divider -->
            <div class="border-t border-gray-300 pt-11 md:pt-15 lg:pt-17 xl:pt-20 mt-12 md:mt-15 lg:mt-17 xl:mt-20"></div>

            <!-- Notice -->
            <v-alert class="mb-4"
                     color="blue"
                     :spacing="false">

                <!-- Text -->
                Next, you will need to add the technical requirements for the vacancy.
                Once that is complete, you will be able to search for and invite suitable
                candidates to apply for the position.

            </v-alert>

            <!-- Create -->
            <v-button label="Continue"
                      @click="modal = true"
                      class="flex justify-end">
            </v-button>

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

        <!-- Other -->
        <template #other>

            <!-- Rules Modal -->
            <v-rules :visible="modal"
                     :hideable="true"
                     @closed="modal = false">
            </v-rules>

        </template>

    </v-layout>
</template>

<script>
    import TypePartial from './type.vue';
    import RulesPartial from './rules.vue';
    import Layout from '@/layout/index.vue';
    import ContactPartial from './contact.vue';
    import LocationPartial from './location.vue';
    import PositionPartial from './position.vue';
    import FinancialPartial from './financial.vue';
    import LinkComponent from '@/components/link.vue';
    import RestrictionPartial from './restrictions.vue';
    import AlertComponent from '@/components/alert.vue';
    import ButtonComponent from '@/components/button.vue';
    import ActionComponent from '@/components/actions.vue';
    import CommunicationPartial from './communication.vue';
    import InteractsWithPersonalization from '@/mixins/InteractsWithPersonalization';

    export default
    {
        /**
         * Define the mixins.
         *
         */
        mixins : [
            InteractsWithPersonalization,
        ],

        /**
         * Define the components.
         *
         */
        components : {
            'v-actions'       : ActionComponent,
            'v-alert'         : AlertComponent,
            'v-button'        : ButtonComponent,
            'v-communication' : CommunicationPartial,
            'v-contact'       : ContactPartial,
            'v-financial'     : FinancialPartial,
            'v-layout'        : Layout,
            'v-link'          : LinkComponent,
            'v-location'      : LocationPartial,
            'v-position'      : PositionPartial,
            'v-restrictions'  : RestrictionPartial,
            'v-rules'         : RulesPartial,
            'v-type'          : TypePartial,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            modal : false,

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
                role            : '',
                summary         : '',
                commitment      : '',
                months          : '',
                currency        : this.getUserCurrencyID(),
                remuneration    : '',
                area            : '',
                country         : this.getUserCountryID(),
                coordinates     : '',
                first_language  : this.getUserLanguageID(),
                second_language : '',
                third_language  : '',
                remote          : false,
                emigrate        : false,
                degree          : false,
                email           : prop('organization.email'),
                phone           : prop('organization.phone'),
                website         : prop('organization.website'),
            }, 'vacancy');
        },
    }
</script>