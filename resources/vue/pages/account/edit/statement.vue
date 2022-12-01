<template>
    <v-panel :stack="true">

        <!-- Title -->
        <h6>
            Cover Letter
        </h6>

        <!-- Text -->
        <p class="mb-4">
            Add a few personal touches to entice
            companies and recruiters.
        </p>

        <!-- Tip -->
        <p class="text-14px text-gray-600/90">
            While traditional résumés place a heavy emphasis on statements,
            IT workers tend to be chosen more for their technical skills.
            As a result, there's no need to go wild in this section. Instead,
            keep it brief and avoid anything generic.
        </p>

        <!-- Notice -->
        <v-alert class="mb-4"
                 :spacing="false">

            <!-- Text -->
            This section will appear on your public profile, so do not
            include any contact information.

        </v-alert>

        <!-- Statement -->
        <v-textbox icon="edit"
                   :lines="12"
                   class="mb-4"
                   id="statement"
                   label="Personal statement"
                   v-model="session.forms.account.statement"
                   :error="session.forms.account.errors.statement">
        </v-textbox>

        <!-- Update -->
        <v-button label="Update"
                  class="md:flex justify-end"
                  :processing="session.forms.account.processing"
                  @click="submit(session.forms.account, 'account.update', 'patch', { preserveScroll : true })">
        </v-button>

    </v-panel>
</template>

<script>
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
            'v-panel'   : PanelComponent,
            'v-textbox' : TextBoxComponent,
        },
    }
</script>