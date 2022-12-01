<template>
    <v-panel :stack="true">

        <!-- Title -->
        <h6 id="title-position">
            Position
        </h6>

        <!-- Text -->
        <p class="mb-4">
            Provide the role title and an overall
            summary of what the position entails.
        </p>

        <!-- Notice -->
        <v-alert class="mb-4"
                 :spacing="false">

            <!-- Text -->
            Unlike traditional websites that host job vacancies, you
            should not include the technical requirements in this section.
            You will be able to add your technical requirements for the
            vacancy on the next page.

        </v-alert>

        <!-- Role -->
        <v-textbox id="role"
                   icon="user"
                   class="mb-4"
                   label="Role"
                   v-model="session.form.role"
                   :error="session.form.errors.role">
        </v-textbox>

        <!-- Summary -->
        <v-textbox :lines="10"
                   id="summary"
                   label="Summary"
                   icon="briefcase"
                   v-model="session.form.summary"
                   :error="session.form.errors.summary">
        </v-textbox>

    </v-panel>
</template>

<script>
    import AlertComponent from '@/components/alert.vue';
    import PanelComponent from '@/components/panel.vue';
    import TextBoxComponent from '@/components/textbox.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-alert'   : AlertComponent,
            'v-panel'   : PanelComponent,
            'v-textbox' : TextBoxComponent,
        },
    }
</script>