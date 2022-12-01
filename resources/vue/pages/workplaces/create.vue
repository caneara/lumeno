<template>
    <v-modal :visible="visible"
             @closed="$emit('closed')"
             id="create-workplace-modal">

        <!-- Title -->
        <h4 class="text-center">
            Add a new workplace
        </h4>

        <!-- Information -->
        <p class="text-center mb-8">
            Specify the role and employer that you
            worked or are working for, then add your
            responsiblities and dates of employment.
        </p>

        <!-- Role -->
        <v-textbox id="role"
                   class="mb-4"
                   label="Role"
                   icon="briefcase"
                   v-model="form.role"
                   :error="form.errors.role">
        </v-textbox>

        <!-- Employer -->
        <v-textbox class="mb-4"
                   id="employer"
                   icon="building"
                   label="Employer"
                   v-model="form.employer"
                   :error="form.errors.employer">
        </v-textbox>

        <!-- Location -->
        <v-textbox icon="map"
                   class="mb-4"
                   id="location"
                   v-model="form.location"
                   :error="form.errors.location"
                   label="Area e.g. Dallas, Texas">
        </v-textbox>

        <!-- Summary -->
        <v-textbox :lines="5"
                   icon="tasks"
                   class="mb-4"
                   id="summary"
                   v-model="form.summary"
                   :error="form.errors.summary"
                   label="Summary of responsibilities">
        </v-textbox>

        <!-- Started At -->
        <v-date class="mb-4"
                id="started_at"
                label="Start date"
                icon="calendar-alt"
                v-model="form.started_at"
                :error="form.errors.started_at">
        </v-date>

        <!-- Finished At -->
        <v-date class="mb-4"
                id="finished_at"
                label="End date"
                :optional="true"
                icon="calendar-alt"
                v-model="form.finished_at"
                :error="form.errors.finished_at">
        </v-date>

        <!-- Actions -->
        <div class="flex flex-col-reverse md:flex-row justify-end">

            <!-- Cancel -->
            <v-button color="gray"
                      label="Cancel"
                      scheme="light"
                      class="md:mr-8"
                      @click="events.emit('hide-create-workplace-modal')">
            </v-button>

            <!-- Create -->
            <v-button label="Create"
                      :processing="form.processing"
                      @click="submit(form, 'workplaces.store')">
            </v-button>

        </div>

    </v-modal>
</template>

<script>
    import DateComponent from '@/components/date.vue';
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
            'v-button'  : ButtonComponent,
            'v-date'    : DateComponent,
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
                employer    : '',
                location    : '',
                role        : '',
                summary     : '',
                started_at  : '',
                finished_at : '',
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