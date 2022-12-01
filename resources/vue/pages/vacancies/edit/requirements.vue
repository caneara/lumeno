<template>
    <v-panel :stack="true"
             class="requirements">

        <!-- Title -->
        <h6 id="title-requirements">
            Requirements
        </h6>

        <!-- Text -->
        <p>
            Manage the technical capabilities that you require for the
            position. You may include up to {{ prop('limit') }}
            requirements in total, however the talent pool will become
            smaller which each additional requirement.
        </p>

        <!-- Notice -->
        <v-alert class="mb-4"
                 :spacing="false">

            <!-- Text -->
            Lumeno sorts candidates in requirement order. It is therefore critical
            that you add your requirements in order of importance. As you would
            expect, mandatory requirements should be added before optional ones.

        </v-alert>

        <!-- List -->
        <v-list :items="requirements"
                :show="!! requirements.length"
                empty="You haven't added any requirements yet">

            <!-- Left -->
            <template v-slot:left="{ item }">
                <div>

                    <!-- Tool -->
                    <span class="block font-semibold text-15px text-gray-800/85 mb-6px">
                        {{ item.tool_name }}
                    </span>

                    <!-- Category -->
                    <span class="block text-15px text-gray-600/65 break-all">
                        {{ item.category }}
                    </span>

                </div>
            </template>

            <!-- Right -->
            <template v-slot:right="{ item }">

                <!-- Years -->
                <v-pill color="gray"
                        :light="true"
                        :text="metric(item.years, 'year')"
                        :title="`You require ${metric(item.years, 'year')} experience`">
                </v-pill>

                <!-- Optional -->
                <v-pill :light="true"
                        align="text-left"
                        class="w-100px ml-3"
                        :color="item.optional ? 'green' : 'blue'"
                        :text="item.optional ? 'Optional' : 'Mandatory'">
                </v-pill>

                <!-- Actions -->
                <div class="flex justify-end">
                    <v-menu :items="menu(item.id)"
                            :id="`context-requirements-${item.id}`"
                            image="fa-ellipsis-h relative top-1-half-px">
                    </v-menu>
                </div>

            </template>

        </v-list>

        <!-- Form -->
        <div ref="form"
             v-show="show"
             class="mt-4 requirement">

            <!-- Tool -->
            <v-lookup v="id"
                      :min="1"
                      k="name"
                      class="mb-4"
                      id="tool_id"
                      :pill="true"
                      icon="wrench"
                      count="count"
                      sub="category"
                      label="Tool name"
                      v-model="form.tool_id"
                      :query="form.tool_name"
                      :url="route('tools.search')"
                      :error="form.errors.tool_id"
                      @selected="toolSelected($event)">
            </v-lookup>

            <!-- Years -->
            <v-dropdown v="id"
                        k="name"
                        id="years"
                        class="mb-4"
                        icon="calendar-alt"
                        :items="experience"
                        v-model="form.years"
                        label="Years experience"
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
                       label="Additional information for candidates">
            </v-textbox>

            <!-- Optional -->
            <v-checkbox class="mb-8"
                        id="optional"
                        v-model="form.optional"
                        :error="form.errors.optional"
                        label="Requirement is optional">
            </v-checkbox>

            <!-- Actions -->
            <div class="flex justify-end">

                <!-- Cancel -->
                <v-button color="gray"
                          class="mr-4"
                          scheme="light"
                          label="Cancel"
                          @click="resetForm()">
                </v-button>

                <!-- Save -->
                <v-button label="Save"
                          id="save-requirement"
                          :processing="form.processing"
                          @click="form.id === '' ? addRecord() : updateRecord()">
                </v-button>

            </div>

        </div>

        <!-- Add New -->
        <v-button label="Add"
                  id="add-requirement"
                  class="flex justify-end mt-4"
                  @click="resetForm(); show = true"
                  v-show="! show && requirements.length < prop('limit')">
        </v-button>

    </v-panel>
</template>

<script>
    import ListComponent from '@/components/list.vue';
    import MenuComponent from '@/components/menu.vue';
    import PillComponent from '@/components/pill.vue';
    import AlertComponent from '@/components/alert.vue';
    import PanelComponent from '@/components/panel.vue';
    import ButtonComponent from '@/components/button.vue';
    import LookUpComponent from '@/components/lookup.vue';
    import TextBoxComponent from '@/components/textbox.vue';
    import CheckBoxComponent from '@/components/checkbox.vue';
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
            'v-checkbox' : CheckBoxComponent,
            'v-dropdown' : DropDownComponent,
            'v-list'     : ListComponent,
            'v-lookup'   : LookUpComponent,
            'v-menu'     : MenuComponent,
            'v-panel'    : PanelComponent,
            'v-pill'     : PillComponent,
            'v-textbox'  : TextBoxComponent,
        },

        /**
         * Define the events.
         *
         */
        emits : ['change'],

		/**
		 * Define the data model.
		 *
		 */
		data() { return {
            show : false,

            experience : prop('experience'),

            requirements : prop('requirements'),

            form : createAjaxForm({
                id         : '',
                years      : '',
                summary    : '',
                category   : '',
                tool_id    : '',
                tool_name  : '',
                originated : '',
                optional   : false,
            }),
        }},

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Store a new requirement.
             *
             */
            addRecord()
            {
                submit(this.form, ['requirements.store', prop('vacancy.id')]).then(response => {
                    this.requirements.push({
                        id         : response.data.id,
                        years      : this.form.years,
                        category   : this.form.category,
                        optional   : this.form.optional,
                        summary    : this.form.summary,
                        tool_id    : this.form.tool_id,
                        tool_name  : this.form.tool_name,
                        originated : this.form.originated,
                    });

                    this.resetForm();

                    this.$emit('change');
                });
            },

            /**
             * Remove the given requirement.
             *
             */
            deleteRecord(id)
            {
                this.resetForm();

                submit(this.form, ['requirements.delete', id], 'delete').then(() => {
                    this.requirements = this.requirements.filter(item => id !== item.id);

                    this.$emit('change');
                });
            },

            /**
             * Prepare the form to edit the given requirement.
             *
             */
            editRecord(id)
            {
                this.resetForm();

                let record = this.requirements.find(item => id === item.id);

                this.form.id         = record.id;
                this.form.years      = record.years;
                this.form.summary    = record.summary;
                this.form.category   = record.category;
                this.form.optional   = record.optional;
                this.form.tool_id    = record.tool_id;
                this.form.tool_name  = record.tool_name;
                this.form.originated = record.originated;

                this.restrictYearsExperience({ originated : this.form.originated });

                this.show = true;

                setTimeout(() => this.$refs.form.scrollIntoView(true), 100);
            },

            /**
             * Retrieve the menu options for the given requirement.
             *
             */
            menu(id)
            {
                return [
                    {
                        type   : 'link',
                        id     : `context-requirements-${id}-edit`,
                        label  : 'Edit',
                        icon   : 'edit',
                        show   : true,
                        action : () => this.editRecord(id),
                    }, {
                        type   : 'separator',
                        show   : true,
                    }, {
                        type   : 'link',
                        id     : `context-requirements-${id}-delete`,
                        label  : 'Delete',
                        icon   : 'trash-alt',
                        show   : true,
                        action : () => this.deleteRecord(id),
                    },
                ];
            },

            /**
             * Reset the form used to add or edit a requirement.
             *
             */
            resetForm()
            {
                this.show = false;

                this.form.clear();

                this.form.optional = false;

                this.experience = prop('experience');
            },

            /**
             * Limit the number of possible years experience to the age of the tool.
             *
             */
            restrictYearsExperience(tool)
            {
                if (blank(tool)) return this.experience = prop('experience');

                let years = this.yearsOld(tool.originated);

                this.experience = prop('experience').slice(0, years);
            },

            /**
             * Handle the selection of a tool.
             *
             */
            toolSelected(tool)
            {
                this.form.years      = '';
                this.form.tool_name  = tool?.name ?? '';
                this.form.category   = tool?.category ?? ''
                this.form.originated = tool?.originated ?? ''

                this.restrictYearsExperience(tool);
            },

            /**
             * Update the given requirement.
             *
             */
            updateRecord()
            {
                let index = this.requirements.findIndex(item => item.id === this.form.id);

                submit(this.form, ['requirements.update', this.form.id], 'patch').then(() => {
                    this.requirements[index].years      = this.form.years;
                    this.requirements[index].summary    = this.form.summary;
                    this.requirements[index].optional   = this.form.optional;
                    this.requirements[index].category   = this.form.category;
                    this.requirements[index].tool_id    = this.form.tool_id;
                    this.requirements[index].tool_name  = this.form.tool_name;
                    this.requirements[index].originated = this.form.originated;

                    this.resetForm();

                    this.$emit('change');
                });
            },
        }
    }
</script>