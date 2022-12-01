<template>
    <v-modal :visible="visible"
             id="create-tool-modal"
             @closed="$emit('closed')">

        <!-- Title -->
        <h4 class="text-center">
            Add a missing tool
        </h4>

        <!-- Information -->
        <p class="text-center mb-9">
            You can extend the library by adding tools that
            are missing. Just be sure that you comply with
            all of the following rules.
        </p>

        <!-- Rules -->
        <div class="border-y border-gray-300 py-9 mb-10">

            <!-- Typos -->
            <div class="flex items-center mb-4">

                <!-- Icon -->
                <i class="fa-fw fas fa-spell-check text-26px text-red-700/80 ml-1"></i>

                <!-- Text -->
                <span class="text-14px text-gray-700 leading-normal ml-6">

                    <!-- Text -->
                    Do not create a new tool because of a spelling mistake
                    in an existing one. Instead, please

                    <!-- Link -->
                    <v-link :url="route('support')">
                        contact us
                    </v-link>

                    <!-- Text -->
                    so that we can fix it.

                </span>

            </div>

            <!-- Variations -->
            <div class="flex items-center mb-4">

                <!-- Icon -->
                <i class="fa-fw fas fa-code-branch text-26px text-sky-700/80 ml-1"></i>

                <!-- Text -->
                <span class="text-14px text-gray-700 leading-normal ml-6">
                    Do not create a new tool for a different version. Any
                    version experience should be included in your own profile.
                </span>

            </div>

            <!-- Relevance -->
            <div class="flex items-center mb-4">

                <!-- Icon -->
                <i class="fa-fw fas fa-star-half-alt text-26px text-yellow-600/80 ml-1"></i>

                <!-- Text -->
                <span class="text-14px text-gray-700 leading-normal ml-6">
                    Do not create a new tool if it isn't widely used e.g. something
                    only used by yourself or a very small number of people.
                </span>

            </div>

            <!-- Consistency -->
            <div class="flex items-center mb-4">

                <!-- Icon -->
                <i class="fa-fw fas fa-code text-26px text-violet-800/70 ml-1"></i>

                <!-- Text -->
                <span class="text-14px text-gray-700 leading-normal ml-6">
                    When adding frameworks, include the language in brackets
                    after the name e.g. Django (Python) or Laravel (PHP).
                </span>

            </div>

            <!-- Contact -->
            <div class="flex items-center">

                <!-- Icon -->
                <i class="fa-fw fas fa-comments text-26px text-emerald-700/80 ml-1"></i>

                <!-- Text -->
                <span class="text-14px text-gray-700 leading-normal ml-6">

                    <!-- Text -->
                    If you are in any doubt about whether you should submit
                    a tool, then please

                    <!-- Link -->
                    <v-link :url="route('support')">
                        contact us
                    </v-link>

                    <!-- Text -->
                    first so that we can advise you.

                </span>

            </div>

        </div>

        <!-- Category -->
        <v-dropdown v="id"
        			k="name"
                    class="mb-4"
        			icon="filter"
                    id="category_id"
        			label="Category"
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

        <!-- Notice -->
        <v-alert class="mb-4"
                 color="green"
                 v-if="notice"
                 :spacing="false">

            <!-- Text -->
            The tool has been created

        </v-alert>

        <!-- Actions -->
        <div class="flex flex-col-reverse md:flex-row justify-end">

            <!-- Cancel -->
            <v-button color="gray"
                      scheme="light"
                      class="md:mr-8"
                      :icon="back ? 'arrow-left' : ''"
                      :label="back ? 'Back to skill' : 'Cancel'"
                      @click="events.emit('hide-create-tool-modal')">
            </v-button>

            <!-- Add -->
            <v-button label="Add"
                      @click="submitForm()"
                      :processing="form.processing">
            </v-button>

        </div>

    </v-modal>
</template>

<script>
    import LinkComponent from '@/components/link.vue';
    import AlertComponent from '@/components/alert.vue';
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
            'v-alert'    : AlertComponent,
            'v-button'   : ButtonComponent,
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
            notice : false,

            form : createAjaxForm({
                name        : '',
                originated  : '',
                category_id : '',
            }),
        }},

        /**
         * Define the public properties.
         *
         */
        props : {
            'back'    : { type : Boolean, default : false },
            'visible' : { type : Boolean, default : false },
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Send a request to the server.
             *
             */
            submitForm()
            {
                submit(this.form, 'tools.store').then(() => {
                    this.form.clear();

                    this.notice = true;

                    setTimeout(() => this.notice = false, 2000);
                })
            }
        }
    }
</script>