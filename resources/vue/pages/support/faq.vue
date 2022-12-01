<template>
    <v-panel>

        <!-- Left -->
        <template #left>

            <!-- Title -->
            <h5 class="text-18px font-semibold text-sky-700">
                Frequently Asked Questions
            </h5>

            <!-- Information -->
            <p class="w-full xl:w-3/4 mb-0">
                The most common questions we receive are
                listed here, together with their answers.
            </p>

        </template>

        <!-- Right -->
        <template #right>

            <!-- Indicator -->
            <p v-if="blank(questions)">
                Loading FAQs...
            </p>

            <!-- Questions -->
            <div v-for="question in questions"
                 :class="question.id === questions.length ? 'mb-0' : 'mb-6'">

                <!-- Question -->
                <h6 @click="view(question.id)"
                    :class="question.id === questions.length ? (question.open ? 'mb-3' : '-mb-2 md:mb-0') : 'mb-3'"
                    class="flex items-center justify-between font-inter font-medium text-16px text-gray-800/90 cursor-pointer tracking-slight select-none">

                    <!-- Text -->
                    {{ question.title }}

                    <!-- Icon -->
                    <i :class="question.open ? 'fa-chevron-down' : 'fa-chevron-right'"
                       class="fas text-15px text-gray-500 transition duration-300 pl-6">
                    </i>

                </h6>

                <!-- Answer -->
                <p v-show="question.open"
                   v-html="question.answer"
                   class="w-full md:w-11/12 text-gray-700/90 leading-relaxed"
                   :class="question.id === questions.length ? 'mb-0' : 'mb-10'">
                </p>

            </div>

        </template>

    </v-panel>
</template>

<script>
    import PanelComponent from '@/components/panel.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-panel' : PanelComponent,
        },

		/**
		 * Define the data model.
		 *
		 */
		data() { return {
			questions : [
                {
                    'id'     : 1,
                    'open'   : false,
                    'title'  : "Where can I view the privacy policy?",
                    'answer' : "Our privacy policy is included within the <a href=\"/legal\">legal</a> page of the site."
                },
                {
                    'id'     : 2,
                    'open'   : false,
                    'title'  : "How are payments and billing handled by Lumeno?",
                    'answer' : "We use a trusted payment provider and merchant of record service called <a target=\"_blank\" href=\"https://www.paddle.com\">Paddle</a> to handle all billing activities, as well as VAT and sales tax. Paddle is PCI-compliant and follows all financial regulations."
                },
                {
                    'id'     : 3,
                    'open'   : false,
                    'title'  : "How do I request that a feature be added to Lumeno?",
                    'answer' : "In these instances, sending an email is best. Please outline in detail why you feel your suggestion would have value to you and other users."
                },
                {
                    'id'     : 4,
                    'open'   : false,
                    'title'  : "Do you support payment types besides credit & debit cards?",
                    'answer' : "Yes. In addition to credit and debit cards, you may also pay using PayPal, Apple Pay, Google Pay and iDEAL."
                }
            ],
		}},

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Display the given question and answer.
             *
             */
            view(id)
            {
                this.questions.forEach(question => question.open = false);

                this.questions.find(item => item.id === id).open = true;
            },
        }
    }
</script>