<template>
    <v-modal :visible="visible"
             id="edit-skill-modal"
             @closed="$emit('closed')">

        <!-- Title -->
        <h4 class="text-center">
            Edit an existing skill
        </h4>

        <!-- Information -->
        <p class="text-center mb-8">
            Revise your experience level with the tool,
            then provide any supporting information e.g.
            familarity with certain versions.
        </p>

        <!-- Tool -->
        <v-sticker id="tool"
                   class="mb-4"
                   label="Tool"
                   :text="form.name">
        </v-sticker>

        <!-- Years -->
        <v-dropdown v="id"
        			k="name"
                    id="years"
                    class="mb-4"
        			label="Experience"
        			icon="calendar-alt"
        			:items="experience"
                    v-model="form.years"
                    :error="form.errors.years">
        </v-dropdown>

        <!-- Summary -->
        <v-textbox :lines="3"
                   icon="edit"
                   class="mb-4"
                   id="summary"
                   :optional="true"
                   v-model="form.summary"
                   :error="form.errors.summary"
                   label="Summary e.g. versions">
        </v-textbox>

        <!-- Actions -->
        <div class="flex flex-col-reverse md:flex-row justify-end">

            <!-- Cancel -->
            <v-button color="gray"
                      label="Cancel"
                      scheme="light"
                      class="md:mr-8"
                      @click="events.emit('hide-edit-skill-modal')">
            </v-button>

            <!-- Update -->
            <v-button label="Update"
                      :processing="form.processing"
                      @click="submit(form, ['skills.update', skill.id], 'patch')">
            </v-button>

        </div>

    </v-modal>
</template>

<script>
    import ModalComponent from '@/components/modal.vue';
    import ButtonComponent from '@/components/button.vue';
    import StickerComponent from '@/components/sticker.vue';
    import TextBoxComponent from '@/components/textbox.vue';
    import DropDownComponent from '@/components/dropdown.vue';
    import InteractsWithFormatting from '@/mixins/InteractsWithFormatting';

    export default
    {
        /**
         * Define the mixins.
         *
         */
        mixins : [
            InteractsWithFormatting,
        ],

        /**
         * Define the components.
         *
         */
        components : {
            'v-button'   : ButtonComponent,
            'v-dropdown' : DropDownComponent,
            'v-modal'    : ModalComponent,
            'v-sticker'  : StickerComponent,
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
                name    : '',
                years   : '',
                summary : '',
            }, 'edit'),

            experience : prop('experience').slice(0, this.yearsOld(this.skill.originated)),
        }},

        /**
         * Define the public properties.
         *
         */
        props : {
            'skill'   : { type : Object,  default : {} },
            'visible' : { type : Boolean, default : false },
        },

        /**
         * Execute actions when the component is instantiated.
         *
         */
        created()
        {
            this.form.name    = this.skill.name ?? '';
            this.form.years   = this.skill.years ?? '';
            this.form.summary = this.skill.summary ?? '';

            this.form.errors.name    = '';
            this.form.errors.years   = '';
            this.form.errors.summary = '';
        },
    }
</script>