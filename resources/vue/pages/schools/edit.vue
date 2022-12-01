<template>
    <v-modal :visible="visible"
             id="edit-school-modal"
             @closed="$emit('closed')">

        <!-- Title -->
        <h4 class="text-center">
            Edit an existing school
        </h4>

        <!-- Information -->
        <p class="text-center mb-8">
            Revise your course or qualification, as well as the institution
            where you undertook study, and your dates of attendance.
        </p>

        <!-- Course -->
        <v-textbox icon="edit"
                   id="course"
                   class="mb-4"
                   label="Course"
                   v-model="form.course"
                   :error="form.errors.course">
        </v-textbox>

        <!-- Qualification -->
        <v-dropdown v="id"
        			k="name"
                    class="mb-4"
                    id="qualification"
        			icon="graduation-cap"
        			label="Qualification"
                    v-model="form.qualification"
                    :error="form.errors.qualification"
        			:items="$page.props.qualifications">
        </v-dropdown>

        <!-- Name -->
        <v-textbox id="name"
                   class="mb-4"
                   icon="university"
                   v-model="form.name"
                   :error="form.errors.name"
                   label="Academic institution">
        </v-textbox>

        <!-- Location -->
        <v-textbox icon="map"
                   class="mb-4"
                   id="location"
                   v-model="form.location"
                   :error="form.errors.location"
                   label="Area e.g. Dallas, Texas">
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
                      @click="events.emit('hide-edit-school-modal')">
            </v-button>

            <!-- Update -->
            <v-button label="Update"
                      :processing="form.processing"
                      @click="submit(form, ['schools.update', school.id], 'patch')">
            </v-button>

        </div>

    </v-modal>
</template>

<script>
    import DateComponent from '@/components/date.vue';
    import ModalComponent from '@/components/modal.vue';
    import ButtonComponent from '@/components/button.vue';
    import TextBoxComponent from '@/components/textbox.vue';
    import DropDownComponent from '@/components/dropdown.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-button'   : ButtonComponent,
            'v-date'     : DateComponent,
            'v-dropdown' : DropDownComponent,
            'v-modal'    : ModalComponent,
            'v-textbox'  : TextBoxComponent,
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
                name          : '',
                course        : '',
                location      : '',
                started_at    : '',
                finished_at   : '',
                qualification : '',
            }, 'edit'),
        }},

        /**
         * Define the public properties.
         *
         */
        props : {
            'school'  : { type : Object,  default : {} },
            'visible' : { type : Boolean, default : false },
        },

        /**
         * Execute actions when the component is instantiated.
         *
         */
        created()
        {
            this.form.name          = this.school.name ?? '';
            this.form.course        = this.school.course ?? '';
            this.form.location      = this.school.location ?? '';
            this.form.started_at    = this.school.started_at ?? '';
            this.form.finished_at   = this.school.finished_at ?? '';
            this.form.qualification = this.school.qualification ?? '';

            this.form.errors.name          = '';
            this.form.errors.course        = '';
            this.form.errors.location      = '';
            this.form.errors.started_at    = '';
            this.form.errors.finished_at   = '';
            this.form.errors.qualification = '';
        },
    }
</script>