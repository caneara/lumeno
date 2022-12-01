<template>
    <v-modal :visible="visible"
             id="edit-tool-modal"
             @closed="$emit('closed')">

        <!-- Title -->
        <h4 class="text-center">
            Edit an existing tool
        </h4>

        <!-- Information -->
        <p class="text-center mb-8">
            Revise the tool's name, category and status.
            Changes resulting in the creation of
            duplicates will not be merged.
        </p>

        <!-- Category -->
        <v-dropdown v="id"
        			k="name"
                    class="mb-4"
        			icon="filter"
        			label="Category"
                    id="category_id"
                    v-model="form.category_id"
        			:items="prop('categories')"
                    :error="form.errors.category_id">
        </v-dropdown>

        <!-- Name -->
        <v-textbox id="name"
                   label="Name"
                   class="mb-4"
                   icon="wrench"
                   v-model="form.name"
                   :error="form.errors.name">
        </v-textbox>

        <!-- Originated -->
        <v-textbox class="mb-4"
                   id="originated"
                   icon="calendar-alt"
                   v-model="form.originated"
                   label="Year created e.g. 2007"
                   :error="form.errors.originated">
        </v-textbox>

        <!-- Approved -->
        <v-checkbox id="approved"
                    class="mb-4"
                    label="Approved"
                    v-model="form.approved"
                    :error="form.errors.approved">
        </v-checkbox>

        <!-- Actions -->
        <div class="flex flex-col-reverse md:flex-row justify-end">

            <!-- Cancel -->
            <v-button color="gray"
                      label="Cancel"
                      scheme="light"
                      class="md:mr-8"
                      @click="events.emit('hide-edit-tool-modal')">
            </v-button>

            <!-- Update -->
            <v-button label="Update"
                      :processing="form.processing"
                      @click="submit(form, ['tools.update', tool.id], 'patch')">
            </v-button>

        </div>

    </v-modal>
</template>

<script>
    import LinkComponent from '@/components/link.vue';
    import ModalComponent from '@/components/modal.vue';
    import ButtonComponent from '@/components/button.vue';
    import TextBoxComponent from '@/components/textbox.vue';
    import DropDownComponent from '@/components/dropdown.vue';
    import CheckBoxComponent from '@/components/checkbox.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-button'   : ButtonComponent,
            'v-checkbox' : CheckBoxComponent,
            'v-dropdown' : DropDownComponent,
            'v-link'     : LinkComponent,
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
                name        : '',
                approved    : '',
                originated  : '',
                category_id : '',
            }, 'edit'),
        }},

        /**
         * Define the public properties.
         *
         */
        props : {
            'tool'    : { type : Object,  default : {} },
            'visible' : { type : Boolean, default : false },
        },

        /**
         * Execute actions when the component is instantiated.
         *
         */
        created()
        {
            this.form.name        = this.tool.name ?? '';
            this.form.approved    = this.tool.approved ?? false;
            this.form.originated  = this.tool.originated ?? '';
            this.form.category_id = this.tool.category_id ?? '';

            this.form.errors.name        = '';
            this.form.errors.approved    = '';
            this.form.errors.originated  = '';
            this.form.errors.category_id = '';
        },
    }
</script>