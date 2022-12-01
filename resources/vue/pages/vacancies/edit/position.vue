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
            Do not include the technical requirements in this section.
            Instead, use the

            <!-- Link -->
            <v-link :action="() => window.document.querySelector('#title-requirements').scrollIntoView({ behavior : 'smooth', block : 'center' })">
                dedicated section
            </v-link>

            <!-- Text -->
            of the form.

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
                   class="mb-4"
                   id="summary"
                   label="Summary"
                   icon="briefcase"
                   v-model="session.form.summary"
                   :error="session.form.errors.summary">
        </v-textbox>

        <!-- Update -->
        <v-button label="Update"
                  class="flex justify-end"
                  :processing="session.form.processing"
                  @click="submit(session.form, ['vacancies.update', prop('vacancy.id')], 'patch')">
        </v-button>

    </v-panel>
</template>

<script>
    import LinkComponent from '@/components/link.vue';
    import AlertComponent from '@/components/alert.vue';
    import PanelComponent from '@/components/panel.vue';
    import ButtonComponent from '@/components/button.vue';
    import TextBoxComponent from '@/components/textbox.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-alert'   : AlertComponent,
            'v-button'  : ButtonComponent,
            'v-link'    : LinkComponent,
            'v-panel'   : PanelComponent,
            'v-textbox' : TextBoxComponent,
        },
    }
</script>