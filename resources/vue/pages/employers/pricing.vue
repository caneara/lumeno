<template>
    <div id="pricing"
         class="bg-sky-50 border-t border-gray-200">

        <!-- Container -->
        <div class="flex flex-col justify-center items-center container pt-20 pb-19 md:py-30 lg:py-36 xl:py-40">

            <!-- Subliminal -->
            <span class="font-bold text-12px text-emerald-500/75 text-center lg:text-left tracking-widest uppercase opacity-80 mb-6px">
                Affordable
            </span>

            <!-- Teaser -->
            <h2 class="text-27px xl:text-30px text-black text-center">
                Easy and inexpensive pricing
            </h2>

            <!-- Supplemental -->
            <p class="text-19px md:text-20px text-gray-700/85 text-center max-w-600px mb-12 md:mb-20">
                Lumeno starts with a simple pay-as-you-go
                pricing system and with no monthly charge.
                You pay based on how many professionals
                you send invites to. If you're sending
                a lot, then review our other plans.
            </p>

            <!-- Plans -->
            <div class="w-3/4 md:w-auto lg:w-3/4 xl:w-2/3 grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-4">

                <!-- Plan -->
                <div :key="plan.name"
                     v-for="(plan, index) in prop('plans')"
                     :class="index === 1 ? 'md:scale-110' : 'md:scale-90'">

                    <!-- Bar -->
                    <div class="w-full h-1"
                         :class="bars[plan.name]">
                    </div>

                    <!-- Content -->
                    <div class="border-l border-r border-gray-400/75">

                        <!-- Header -->
                        <div class="bg-white flex flex-col justify-center items-center p-6">

                            <!-- Name -->
                            <h3 class="font-semibold text-20px mb-1px">
                                {{ plan.name }}
                            </h3>

                            <!-- Usage Fee -->
                            <h5 class="font-sans font-normal text-16px text-gray-600 tracking-normal mb-0">
                                ${{ number(plan.prices.usage) }} per invite
                            </h5>

                        </div>

                        <!-- Base Fee -->
                        <div class="bg-gray-100 border-t border-b border-gray-300 flex flex-col justify-center items-center px-6 py-5">

                            <!-- Monthly -->
                            <h5 class="font-sans font-normal text-15px text-gray-600 tracking-normal mb-1">
                                {{ plan.prices.monthly === 0 ? 'No Monthly Charge' : `$${number(plan.prices.monthly)} per month` }}
                            </h5>

                            <!-- Yearly -->
                            <h5 class="font-sans font-normal text-13px text-gray-500 tracking-normal mb-0">

                                <!-- Text -->
                                {{ plan.prices.yearly === 0 ? 'No Yearly Charge' : `$${number(plan.prices.yearly)} per year` }}

                                <!-- Incentive -->
                                <span v-if="plan.prices.yearly"
                                      class="bg-red-600/70 text-10px text-white uppercase rounded pl-2px pr-1 py-2px ml-2">

                                    <!-- Text -->
                                    Save 20%

                                </span>

                            </h5>

                        </div>

                        <!-- Features -->
                        <div class="bg-white flex flex-col justify-center items-center px-6 py-8">

                            <!-- Feature -->
                            <div :key="feature"
                                v-for="feature in features"
                                class="flex items-center mb-10px last-of-type:mb-0">

                                <!-- Tick -->
                                <div class="bg-emerald-500 rounded-full px-1 mr-2">
                                    <i class="fas fa-check text-white text-9px relative -top-2px"></i>
                                </div>

                                <!-- Text -->
                                <span class="text-14px text-gray-600 relative top-half-px">
                                    {{ feature }}
                                </span>

                            </div>

                        </div>

                    </div>

                    <!-- Action -->
                    <div @click="redirect(['spark.portal', { type : 'organization' }])"
                         class="bg-violet-600 hover:bg-violet-800 font-semibold text-12px text-white text-center rounded-b-md cursor-pointer uppercase transition duration-300 px-12 pt-3 pb-11px">

                        <!-- Text -->
                        Get Started

                    </div>

                </div>

            </div>

            <!-- VAT Notice -->
            <span class="block text-13px text-gray-500 text-center tracking-wide mt-10 md:mt-16">
                All prices are exclusive of VAT or sales tax.
            </span>

            <!-- Plan Recommendations -->
            <span class="block max-w-550px text-13px text-gray-500 text-center leading-normal tracking-wide mt-3">
                The gold plan is recommended when you are sending 10,000 or more
                invites a year. The platinum plan is recommended when you are
                sending 20,000 or more invites a year.
            </span>

        </div>

    </div>
</template>

<script>
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
         * Define the data model.
         *
         */
        data() { return {
            bars : {
                'Silver Plan'   : 'bg-silver-300',
                'Gold Plan'     : 'bg-yellow-500',
                'Platinum Plan' : 'bg-sky-500',
            },
            features : [
                'Unlimited invitations',
                'Unlimited vacancies',
                'Unlimited team sizes',
            ]
        }},
    }
</script>