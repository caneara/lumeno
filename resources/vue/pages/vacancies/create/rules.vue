<template>
    <v-modal :visible="visible"
             id="accept-rules-modal"
             @closed="$emit('closed')">

        <!-- Title -->
        <h4 class="text-center">
            Keeping the platform positive
        </h4>

        <!-- Information -->
        <p class="text-center mb-8">
            Lumeno is a safe, honest, respectful and inclusive platform.
            To keep it that way, your vacancy must comply with our rules.
        </p>

        <!-- Rules -->
        <div class="border-y border-gray-300 py-9 mb-10">

            <!-- Accurate -->
            <div class="flex items-center mb-4">

                <!-- Icon -->
                <i class="fa-fw fas fa-file-signature text-26px text-sky-700/70 ml-1"></i>

                <!-- Text -->
                <span class="text-15px text-gray-700 leading-normal ml-6">
                    All supplied content must be accurate, truthful, and fully
                    reflect the realities of the available position.
                </span>

            </div>

            <!-- Third Party -->
            <div class="flex items-center mb-4">

                <!-- Icon -->
                <i class="fa-fw fas fa-users text-26px text-teal-800/60 ml-1"></i>

                <!-- Text -->
                <span class="text-15px text-gray-700 leading-normal ml-6">
                    If you are recruiting for a third-party, you confirm that
                    you have verified that all the vacancy particulars are correct.
                </span>

            </div>

            <!-- Consistency -->
            <div class="flex items-center mb-4">

                <!-- Icon -->
                <i class="fa-fw far fa-face-frown-open text-26px text-yellow-600/80 ml-1"></i>

                <!-- Text -->
                <span class="text-15px text-gray-700 leading-normal ml-6">
                    Do not use parts of the form or external links to contradict
                    other parts of the form e.g. adding salary brackets.
                </span>

            </div>

            <!-- Offense -->
            <div class="flex items-center mb-4">

                <!-- Icon -->
                <i class="fa-fw fas fa-person-harassing text-26px text-purple-800/60 ml-1"></i>

                <!-- Text -->
                <span class="text-15px text-gray-700 leading-normal ml-6">
                    Do not include any content, or external links to content that
                    is derogatory, unlawful, or generally offensive.
                </span>

            </div>

            <!-- Deletion -->
            <div class="flex items-center mb-4">

                <!-- Icon -->
                <i class="fa-fw fas fa-ban text-26px text-red-700/70 ml-1"></i>

                <!-- Text -->
                <span class="text-15px text-gray-700 leading-normal ml-6">
                    Violating the rules will result in your organization being
                    banned. Once banned, you are not eligible for refunds.
                </span>

            </div>

            <!-- Contact -->
            <div class="flex items-center">

                <!-- Icon -->
                <i class="fa-fw far fa-comments text-26px text-emerald-700/70 ml-1"></i>

                <!-- Text -->
                <span class="text-15px text-gray-700 leading-normal ml-6">

                    <!-- Text -->
                    If you are in any doubt about your vacancy complying with
                    the rules, then please

                    <!-- Link -->
                    <v-link :url="route('support')">
                        contact us
                    </v-link>

                    <!-- Text -->
                    first.

                </span>

            </div>

        </div>

        <!-- Footer -->
        <div class="md:flex justify-between items-center">

            <!-- Agree -->
            <div class="flex justify-end">
                <v-checkbox id="accept"
                            v-model="accept"
                            label="Accept rules"
                            class="w-full md:w-[180px] mb-4 md:mb-0">
                </v-checkbox>
            </div>

            <!-- Actions -->
            <div class="flex flex-col-reverse md:flex-row justify-end">

                <!-- Cancel -->
                <v-button color="gray"
                          label="Cancel"
                          scheme="light"
                          class="md:mr-8"
                          @click="events.emit('hide-accept-rules-modal')">
                </v-button>

                <!-- Create -->
                <v-button label="Create"
                          :disabled="! accept"
                          :processing="session.form.processing"
                          @click="submit(session.form, 'vacancies.store')">
                </v-button>

            </div>

        </div>

    </v-modal>
</template>

<script>
    import LinkComponent from '@/components/link.vue';
    import ModalComponent from '@/components/modal.vue';
    import ButtonComponent from '@/components/button.vue';
    import CheckBoxComponent from '@/components/checkbox.vue';
    import PasswordComponent from '@/components/password.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-button'   : ButtonComponent,
            'v-checkbox' : CheckBoxComponent,
            'v-link'     : LinkComponent,
            'v-modal'    : ModalComponent,
            'v-password' : PasswordComponent,
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
            accept : false,
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