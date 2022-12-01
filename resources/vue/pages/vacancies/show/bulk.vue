<template>
    <v-modal :visible="visible"
             @closed="$emit('closed')"
             id="bulk-invitations-modal">

        <!-- Title -->
        <h4 class="text-center">
            Send many invitations
        </h4>

        <!-- Information -->
        <p class="text-center mb-4">
            Lumeno offers the option to contact the top 100 matching
            people that have yet to be invited to apply for the vacancy.
        </p>

        <!-- Information -->
        <p class="text-center mb-8">
            This process is performed in a single operation
            and can be repeated to contact the next 100, and
            so on. If you would like to contact less than
            100 people, then adjust the limit below.
        </p>

        <!-- Notice -->
        <v-alert class="mb-4"
                 color="blue"
                 :spacing="false">

            <!-- Text -->
            If you want to reach a single person, select the 'send
            invitation' option in their associated context menu.

        </v-alert>

        <!-- Limit -->
        <v-textbox id="limit"
                   class="mb-4"
                   icon="envelope"
                   v-model="form.limit"
                   :error="form.errors.limit"
                   label="Maximum number to contact">
        </v-textbox>

        <!-- Actions -->
        <div class="flex flex-col-reverse md:flex-row justify-end">

            <!-- Cancel -->
            <v-button color="gray"
                      label="Cancel"
                      scheme="light"
                      class="md:mr-8"
                      @click="events.emit('hide-bulk-invitations-modal')">
            </v-button>

            <!-- Send -->
            <v-button label="Send"
                      :processing="form.processing"
                      @click="confirmAction('This will send multiple invitations.', () => submit(form, ['invitations.bulk', prop('vacancy.id')]))">
            </v-button>

        </div>

    </v-modal>
</template>

<script>
    import AlertComponent from '@/components/alert.vue';
    import ModalComponent from '@/components/modal.vue';
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
            'v-modal'   : ModalComponent,
            'v-textbox' : TextBoxComponent,
        },

        /**
         * Define the events.
         *
         */
        emits : ['closed'],

        /**
         * Define the data model.
         *
         */
        data() { return {
            form : createInertiaForm({
                limit : 100,
            }, 'many'),
        }},

        /**
         * Define the public properties.
         *
         */
        props : {
            'visible' : { type : Boolean, default : false },
        },
    }
</script>