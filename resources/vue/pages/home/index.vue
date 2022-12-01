<template>
    <main class="HomePage">

        <!-- Sections -->
        <v-hero></v-hero>
        <v-explained></v-explained>
        <v-resume></v-resume>
        <v-projects></v-projects>
        <v-articles></v-articles>
        <v-invitations></v-invitations>
        <v-action></v-action>

    </main>
</template>

<script>
    import HeroPartial from './hero.vue';
    import ActionPartial from './action.vue';
    import ResumePartial from './resume.vue';
    import ArticlePartial from './articles.vue';
    import ProjectPartial from './projects.vue';
    import ExplainedPartial from './explained.vue';
    import InvitationPartial from './invitations.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-action'      : ActionPartial,
            'v-articles'    : ArticlePartial,
            'v-explained'   : ExplainedPartial,
            'v-hero'        : HeroPartial,
            'v-invitations' : InvitationPartial,
            'v-projects'    : ProjectPartial,
            'v-resume'      : ResumePartial,
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