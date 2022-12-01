<template>
    <main class="EmployerPage">

        <!-- Sections -->
        <v-hero></v-hero>
        <v-vacancies></v-vacancies>
        <v-profiles></v-profiles>
        <v-invitations></v-invitations>
        <v-demo></v-demo>
        <v-filters></v-filters>
        <v-pricing></v-pricing>
        <!-- <v-testimonials></v-testimonials> -->
        <v-action></v-action>

    </main>
</template>

<script>
    import DemoPartial from './demo.vue';
    import HeroPartial from './hero.vue';
    import ActionPartial from './action.vue';
    import PricingPartial from './pricing.vue';
    import FiltersPartial from './filters.vue';
    import ProfilePartial from './profiles.vue';
    import VacancyPartial from './vacancies.vue';
    import InvitationPartial from './invitations.vue';
    import TestimonialPartial from './testimonials.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-action'       : ActionPartial,
            'v-demo'         : DemoPartial,
            'v-filters'      : FiltersPartial,
            'v-hero'         : HeroPartial,
            'v-invitations'  : InvitationPartial,
            'v-pricing'      : PricingPartial,
            'v-profiles'     : ProfilePartial,
            'v-testimonials' : TestimonialPartial,
            'v-vacancies'    : VacancyPartial,
        },

        /**
         * Execute actions when the component is created.
         *
         */
        created()
        {
            document.querySelector('title').innerHTML = prop('title');
        },
    }
</script>