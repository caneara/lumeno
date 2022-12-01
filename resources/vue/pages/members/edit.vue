<template>
    <v-modal :visible="visible"
             id="edit-member-modal"
             @closed="$emit('closed')">

        <!-- Title -->
        <h4 class="text-center">
            Change member's role
        </h4>

        <!-- Information -->
        <p class="text-center mb-8">
            Select the role that you wish to assign to the
            user. In most cases, the 'manager' role is only
            for organization owners.
        </p>

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
                      @click="events.emit('hide-edit-member-modal')">
            </v-button>

            <!-- Update -->
            <v-button label="Update"
                      :processing="form.processing"
                      @click="submit(form, ['members.update', member.id], 'patch')">
            </v-button>

        </div>

    </v-modal>
</template>

<script>
    import CardComponent from '@/components/cards.vue';
    import ModalComponent from '@/components/modal.vue';
    import ButtonComponent from '@/components/button.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-button' : ButtonComponent,
            'v-cards'  : CardComponent,
            'v-modal'  : ModalComponent,
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
                role : '',
            }, 'edit'),
        }},

        /**
         * Define the public properties.
         *
         */
        props : {
            'member'  : { type : Object,  default : {} },
            'visible' : { type : Boolean, default : false },
        },

        /**
         * Execute actions when the component is instantiated.
         *
         */
        created()
        {
            this.form.role = this.member.role ?? '';

            this.form.errors.role = '';
        },
    }
</script>