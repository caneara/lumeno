<template>
    <v-modal :visible="visible"
             id="create-skill-modal"
             @closed="$emit('closed')">

        <!-- Title -->
        <h4 class="text-center">
            Add a new skill
        </h4>

        <!-- Information -->
        <p class="text-center mb-8">
            Search for a tool, then set your experience level.
            You may also include supporting information, such
            as version familiarity.
        </p>

        <!-- Tool -->
        <v-lookup v="id"
                  k="name"
                  :min="1"
                  id="tool_id"
                  :pill="true"
                  class="mb-4"
                  count="count"
                  icon="search"
                  sub="category"
                  label="Tool name"
                  v-model="form.tool_id"
                  :error="form.errors.tool_id"
                  :url="route('tools.search')"
                  @selected="restrictYearsExperience($event)">
        </v-lookup>

        <!-- Notice -->
        <v-alert class="mb-4"
                 color="blue"
                 :spacing="false">

            <!-- Text -->
            Are we missing a tool?

            <!-- Link -->
            <v-link :action="() => events.emit('open-create-tool-modal')">
                Add it to the library.
            </v-link>

        </v-alert>

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

        <!-- Notice -->
        <v-alert class="mb-4"
                 :remove="true"
                 :spacing="false"
                 id="skills_tool_hierarchy">

            <!-- Text -->
            Before adding any skills to your profile, please
            review the tool hierarchy section of the

            <!-- Link -->
            <v-link :action="() => window.open(`${route('guide', { page : 'skills' })}#markdown-tool-hierarchy`)">
                user guide.
            </v-link>

        </v-alert>

        <!-- Actions -->
        <div class="flex flex-col-reverse md:flex-row justify-end">

            <!-- Cancel -->
            <v-button color="gray"
                      label="Cancel"
                      scheme="light"
                      class="md:mr-8"
                      @click="events.emit('hide-create-skill-modal')">
            </v-button>

            <!-- Create -->
            <v-button label="Create"
                      :processing="form.processing"
                      @click="submit(form, 'skills.store')">
            </v-button>

        </div>

    </v-modal>
</template>

<script>
    import LinkComponent from '@/components/link.vue';
    import AlertComponent from '@/components/alert.vue';
    import ModalComponent from '@/components/modal.vue';
    import LookUpComponent from '@/components/lookup.vue';
    import ButtonComponent from '@/components/button.vue';
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
            'v-alert'    : AlertComponent,
            'v-button'   : ButtonComponent,
            'v-dropdown' : DropDownComponent,
            'v-link'     : LinkComponent,
            'v-lookup'   : LookUpComponent,
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
                years   : '',
                summary : '',
                tool_id : '',
            }, 'create'),

            experience : prop('experience'),
        }},

        /**
         * Define the public properties.
         *
         */
        props : {
            'visible' : { type : Boolean, default : false },
        },

		/**
		 * Define the supporting methods.
		 *
		 */
		methods :
        {
            /**
             * Limit the number of possible years experience to the age of the tool.
             *
             */
            restrictYearsExperience(tool)
            {
                this.form.years = '';

                if (blank(tool)) return this.experience = prop('experience');

                let years = this.yearsOld(tool.originated);

                this.experience = prop('experience').slice(0, years);
            },
        }
    }
</script>