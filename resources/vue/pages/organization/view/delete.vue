<template>
    <v-modal :visible="visible"
             @closed="$emit('closed')"
             id="delete-organization-modal">

        <!-- Title -->
        <h4 class="text-center">
            Delete your organization
        </h4>

        <!-- Information -->
        <p class="text-center mb-8">
            To remove your organization, its members,
            vacancies, and all other related data, enter
            its name, then click the delete button.
        </p>

        <!-- Notice -->
        <v-alert class="mb-4"
                 :spacing="false">

            <!-- Text -->
            This action cannot be reversed. Once all your data has
            been deleted, it will not be possible to recover it.

        </v-alert>

        <!-- Name -->
        <v-textbox class="mb-4"
                   icon="building"
                   id="organization"
                   v-model="form.name"
                   label="Organization name"
                   :error="form.errors.name">
        </v-textbox>

        <!-- Actions -->
        <div class="flex flex-col-reverse md:flex-row justify-end">

            <!-- Cancel -->
            <v-button color="gray"
                      label="Cancel"
                      scheme="light"
                      class="md:mr-8"
                      @click="events.emit('hide-delete-organization-modal')">
            </v-button>

            <!-- Delete -->
            <v-button color="red"
                      label="Delete"
                      :processing="form.processing"
                      :disabled="form.name !== prop('organization.name')"
                      @click="submit(form, 'organization.delete', 'delete')">
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
                name : '',
            }, 'delete'),
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