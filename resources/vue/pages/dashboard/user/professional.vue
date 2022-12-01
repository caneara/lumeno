<template>
    <div>

        <!-- Text -->
        <p class="mb-10">
            If you're a designer, developer, engineer or technician, then this is for
            you. Your next step, is to set up your account, and then create a profile,
            which consists of your résumé, as well as a portfolio of projects &amp; articles.
        </p>

        <!-- Checklist -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2 gap-6 mb-10">

            <!-- Items -->
            <div v-for="item in checklist"
                 @click="redirect(item.route)"
                 class="flex border border-dashed border-gray-400 hover:bg-sky-50 transition duration-300 rounded-md cursor-pointer px-4 pt-6 pb-5">

                <!-- Icon -->
                <i :class="item.icon"
                   class="fa-fw fas text-24px relative top-2px lg:top-10px xl:top-2px ml-6px">
                </i>

                <!-- Content -->
                <div class="ml-5">

                    <!-- Title -->
                    <h5 class="font-sans font-medium text-17px text-gray-700 mb-2 lg:mb-1 xl:mb-2">
                        {{ item.title }}
                    </h5>

                    <!-- Summary -->
                    <p class="text-15px text-gray-600 mb-0">
                        {{ item.summary }}
                    </p>

                </div>

            </div>

        </div>

        <!-- Text -->
        <p class="mb-10">
            If you're feeling a little overwhelmed, then why not check out the help
            guide to learn more about each section. If you're more of a visual learner,
            then consider watching the demo videos instead.
        </p>

        <!-- Actions -->
        <div class="flex flex-col md:flex-row justify-center">

            <!-- Read -->
            <div @click="redirect(['guide', 'profile'])"
                 class="bg-green-600/5 border border-dashed border-gray-500/50 hover:border-green-600 transition duration-300 rounded-md cursor-pointer px-6 py-3 md:mr-4 mb-4 md:mb-0">

                <!-- Content -->
                <h5 class="font-medium text-16px text-emerald-700 relative top-1px mb-0">

                    <!-- Icon -->
                    <i class="fa-fw fas fa-book text-gray-500/80 -ml-2 mr-1"></i>

                    <!-- Text -->
                    <span>
                        Read the guide
                    </span>

                </h5>

            </div>

            <!-- Watch -->
            <div @click="window.open('https://www.youtube.com/watch?v=iB1mLgN0MNE&list=PLNQVO8rB62MUduBD8ae7FL8zFFrbEhDjB')"
                 class="bg-sky-600/5 border border-dashed border-gray-500/50 hover:border-sky-600 transition duration-300 rounded-md cursor-pointer px-6 py-3">

                <!-- Content -->
                <h5 class="font-medium text-16px text-sky-700 relative top-1px mb-0">

                    <!-- Icon -->
                    <i class="fa-fw fas fa-video text-gray-500/80 -ml-2 mr-1"></i>

                    <!-- Text -->
                    <span>
                        Watch the videos
                    </span>

                </h5>

            </div>

        </div>

    </div>
</template>

<script>
    export default
    {
        /**
         * Define the data model.
         *
         */
        data() { return {
            checklist : [
                {
                    icon    : 'fa-user text-emerald-600/80',
                    title   : 'Complete your account',
                    summary : 'Add your personal photo, location, financial expectations and time commitment.',
                    route   : 'account.edit',
                }, {
                    icon    : 'fa-hammer text-yellow-600/80',
                    title   : 'Build up your profile',
                    summary : 'Add your experience level with tools, your education and employment history.',
                    route   : 'skills',
                }, {
                    icon    : 'fa-cube text-sky-600/80',
                    title   : 'Create a project',
                    summary : 'Add something that you are working on at the moment, such as a SaaS.',
                    route   : 'projects',
                }, {
                    icon    : 'fa-newspaper text-purple-600/80',
                    title   : 'Write an article',
                    summary : 'Add content that other professionals and employers can review.',
                    route   : 'articles',
                },
            ],
        }},
    }
</script>