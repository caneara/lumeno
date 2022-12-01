<template>
    <v-modal :visible="visible"
             id="add-member-modal"
             @closed="$emit('closed')">

        <!-- Title -->
        <h4 class="text-center">
            Add a new member
        </h4>

        <!-- Information -->
        <p class="text-center mb-8">
            Provide the email address of a Lumeno account
            holder, then select the role that you wish them
            to have in the organization.
        </p>

        <!-- Notice -->
        <v-alert class="mb-4"
                 :spacing="false">

            <!-- Text -->
            If the user does not have a Lumeno account, then
            they will be invited to join. Upon doing so, they
            will be added to your organization's membership.

        </v-alert>

        <!-- Email Address -->
        <v-textbox id="email"
                   fill="email"
                   class="mb-4"
                   icon="envelope"
                   v-model="form.email"
                   label="Email address"
                   :error="form.errors.email">
        </v-textbox>

        <!-- Role -->
        <v-cards id="role"
                 v-model="form.role"
                 :items="prop('roles')"
                 :error="form.errors.role"
                 class="md:grid-cols-2 mb-4">
        </v-cards>

        <!-- Actions -->
        <div class="flex flex-col-reverse md:flex-row justify-end">

            <!-- Cancel -->
            <v-button color="gray"
                      label="Cancel"
                      scheme="light"
                      class="md:mr-8"
                      @click="events.emit('hide-add-member-modal')">
            </v-button>

            <!-- Create -->
            <v-button label="Create"
                      :processing="form.processing"
                      @click="submit(form, 'members.store')">
            </v-button>

        </div>

    </v-modal>
</template>

<script>
    import CardComponent from '@/components/cards.vue';
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
            'v-cards'   : CardComponent,
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
                role  : '',
                email : '',
            }, 'create'),
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