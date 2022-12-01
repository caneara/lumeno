<template>
    <div>

        <!-- Summary -->
        <p class="text-gray-700 mb-12">
            Lumeno does not use the job board "model". Instead,
            employers are able to reach you directly if (and
            only if) their vacancy matches your requirements.
            As a result, you keep your account for the length
            of your career and you move jobs when the right
            invite comes along&hellip; we know, it's very
            different! Let's see how it works in practice&hellip;
        </p>

        <!-- Diagram -->
        <div class="w-full bg-gray-100/30 border border-dashed border-gray-400 rounded-lg xl:pt-8 xl:pb-6">
            <div class="w-full flex flex-col items-center scale-95">

                <!-- Top Diagram -->
                <div class="w-full flex flex-wrap xl:flex-nowrap items-center gap-6">

                    <!-- Steps -->
                    <div v-for="item in top"
                         class="flex items-center"
                         :class="item.content ? 'w-full xl:w-1/3' : ''">

                        <!-- Arrow -->
                        <i v-if="! item.content"
                           class="fas fa-arrow-right text-20px text-gray-500/60 hidden xl:inline">
                        </i>

                        <!-- Content -->
                        <div v-if="item.content"
                             class="w-full flex flex-col items-center">

                            <!-- Circle -->
                            <div :class="item.circle"
                                 class="h-70px w-70px flex justify-center items-center rounded-full mb-8">

                                <!-- Icon -->
                                <i :class="item.icon"
                                   class="fas text-26px">
                                </i>

                            </div>

                            <!-- Title -->
                            <h4 class="font-medium text-18px mb-3">
                                {{ item.title }}
                            </h4>

                            <!-- Summary -->
                            <span class="text-gray-700 text-center leading-normal px-6 lg:px-4 xl:px-6">
                                {{ item.summary }}
                            </span>

                        </div>

                    </div>

                </div>

                <!-- Divider -->
                <div class="w-full flex my-3 lg:my-10">

                    <!-- Filler -->
                    <div class="w-1/3"></div>
                    <div><i class="fas fa-arrow-down text-20px opacity-0 select-none"></i></div>
                    <div class="w-1/3"></div>
                    <div><i class="fas fa-arrow-down text-20px opacity-0 select-none"></i></div>

                    <!-- Arrow -->
                    <div class="w-1/3 flex justify-center items-center pl-9">
                        <i class="fas fa-arrow-down text-20px text-gray-500/60 hidden xl:inline"></i>
                    </div>

                </div>

                <!-- Middle Diagram -->
                <div class="w-full flex flex-wrap xl:flex-nowrap items-center gap-6">

                    <!-- Steps -->
                    <div v-for="item in middle"
                         class="flex items-center"
                         :class="item.content ? 'w-full xl:w-1/3' : ''">

                        <!-- Arrow -->
                        <i v-if="! item.content"
                           class="fas fa-arrow-left text-20px text-gray-500/60 hidden xl:inline">
                        </i>

                        <!-- Content -->
                        <div v-if="item.content"
                             class="w-full flex flex-col items-center">

                            <!-- Circle -->
                            <div :class="item.circle"
                                 class="h-70px w-70px flex justify-center items-center rounded-full mb-8">

                                <!-- Icon -->
                                <i :class="item.icon"
                                    class="fas text-26px">
                                </i>

                            </div>

                            <!-- Title -->
                            <h4 class="font-medium text-18px mb-3">
                                {{ item.title }}
                            </h4>

                            <!-- Summary -->
                            <span class="text-gray-700 text-center leading-normal px-6 lg:px-4 xl:px-6">
                                {{ item.summary }}
                            </span>

                        </div>

                    </div>

                </div>

                <!-- Divider -->
                <div class="w-full flex my-3 lg:my-10">

                    <!-- Arrow -->
                    <div class="w-1/3 flex justify-center items-center pr-9">
                        <i class="fas fa-arrow-down text-20px text-gray-500/60 hidden xl:inline"></i>
                    </div>

                    <!-- Filler -->
                    <div class="w-1/3"></div>
                    <div><i class="fas fa-arrow-down text-20px opacity-0 select-none"></i></div>
                    <div class="w-1/3"></div>
                    <div><i class="fas fa-arrow-down text-20px opacity-0 select-none"></i></div>

                </div>

                <!-- Bottom Diagram -->
                <div class="w-full flex flex-wrap xl:flex-nowrap items-center gap-6">

                    <!-- Steps -->
                    <div v-for="item in bottom"
                         class="flex items-center"
                         :class="item.content ? 'w-full xl:w-1/3' : ''">

                        <!-- Arrow -->
                        <i v-if="! item.content"
                           class="fas fa-arrow-right text-20px text-gray-500/60 hidden xl:inline">
                        </i>

                        <!-- Content -->
                        <div v-if="item.content"
                             class="w-full flex flex-col items-center">

                            <!-- Circle -->
                            <div :class="item.circle"
                                 class="h-70px w-70px flex justify-center items-center rounded-full mb-8">

                                <!-- Icon -->
                                <i :class="item.icon"
                                   class="fas text-26px">
                                </i>

                            </div>

                            <!-- Title -->
                            <h4 class="font-medium text-18px mb-3">
                                {{ item.title }}
                            </h4>

                            <!-- Summary -->
                            <span class="text-gray-700 text-center leading-normal px-6 lg:px-4 xl:px-6">
                                {{ item.summary }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>
</template>

<script>
    import LinkComponent from '@/components/link.vue';

    export default
    {
        /**
         * Define the components.
         *
         */
        components : {
            'v-link' : LinkComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            top : [
                {
                    content : true,
                    circle  : 'bg-emerald-500/15',
                    icon    : 'fa-right-to-bracket text-emerald-600',
                    title   : 'Sign Up',
                    summary : 'Create an account and add your basic details such as name and email.',
                }, {
                    content : false,
                }, {
                    content : true,
                    circle  : 'bg-sky-500/15',
                    icon    : 'fa-user text-sky-600',
                    title   : 'Create Profile',
                    summary : 'Add your tech skills, location, min salary, time commitment etc.',
                }, {
                    content : false,
                }, {
                    content : true,
                    circle  : 'bg-purple-500/15',
                    icon    : 'fa-cubes text-purple-600',
                    title   : 'Add Projects',
                    summary : 'List your past & present work e.g. apps, open-source & tech research.',
                },
            ],
            middle : [
                {
                    content : true,
                    circle  : 'bg-orange-500/15',
                    icon    : 'fa-building text-orange-600',
                    title   : 'Jobs Created',
                    summary : 'Employers define their needs for a new vacancy and run a search.',
                }, {
                    content : false,
                }, {
                    content : true,
                    circle  : 'bg-gray-500/15',
                    icon    : 'fa-mug-hot text-gray-600',
                    title   : 'Relax & Wait',
                    summary : 'Your job is done, you just update your profile when necessary.',
                }, {
                    content : false,
                }, {
                    content : true,
                    circle  : 'bg-yellow-500/15',
                    icon    : 'fa-newspaper text-yellow-600',
                    title   : 'Upload Articles',
                    summary : 'Write tech content that shows your knowledge and understanding.',
                },
            ],
            bottom : [
                {
                    content : true,
                    circle  : 'bg-pink-500/15',
                    icon    : 'fa-search text-pink-600',
                    title   : 'Search Results',
                    summary : "If your needs align with the employer's vacancy, your profile is shown.",
                }, {
                    content : false,
                }, {
                    content : true,
                    circle  : 'bg-indigo-500/15',
                    icon    : 'fa-envelope-open-text text-indigo-600',
                    title   : 'Receive Invite',
                    summary : 'Employer reviews your profile and sends you an email with the details.',
                }, {
                    content : false,
                }, {
                    content : true,
                    circle  : 'bg-emerald-500/15',
                    icon    : 'fa-paper-plane text-emerald-600',
                    title   : 'Review Offer',
                    summary : 'You examine the vacancy and reply if interested in the job.',
                },
            ],
        }},
    }
</script>