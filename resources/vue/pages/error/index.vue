<template>
    <main class="flex flex justify-center items-center min-h-screen bg-gray-200 md:p-12 lg:p-14">
        <article class="bg-white/75 border-y md:border-x border-gray-400/80 max-w-600px md:rounded-lg p-10 md:p-14">

            <!-- Logo -->
            <img alt="Logo"
                 class="h-35px mx-auto mb-8"
                 :src="asset('img/logo.svg')">

            <!-- Header -->
            <h4 class="text-center">
                {{ prop('code') }} - {{ errors[prop('code')].title }}
            </h4>

            <!-- Description -->
            <p class="text-center mb-4">
                {{ errors[prop('code')].description }}
            </p>

            <!-- Details -->
            <div v-html="details[prop('code')]"
                 v-if="details[prop('code')] ?? false"
                 class="bg-orange-100/55 border-t-3 border-yellow-600/45 rounded-b leading-normal p-6 my-8">
            </div>

            <!-- Links -->
            <div class="text-12px text-center uppercase mb-3">

                <!-- Home -->
                <a :href="route('home')">
                    Home
                </a>

                <!-- Separator -->
                <span class="text-12px text-gray-500 mx-2">
                    |
                </span>

                <!-- Support -->
                <a :href="route('support')">
                    Support
                </a>

                <!-- Separator -->
                <span class="text-12px text-gray-500 mx-2">
                    |
                </span>

                <!-- Legal -->
                <a :href="route('legal')">
                    Legal
                </a>

                <!-- Separator -->
                <span class="text-12px text-gray-500 mx-2">
                    |
                </span>

                <!-- Dashboard -->
                <a :href="route('dashboard.user')">
                    Dashboard
                </a>

            </div>

            <!-- Copyright -->
            <div class="text-9px text-gray-500/80 text-center uppercase">
                &copy; {{ new Date().getFullYear() }} Caneara. All rights reserved.
            </div>

        </article>
    </main>
</template>

<script>
    export default
    {
        /**
         * Define the data model.
         *
         */
        data() { return {
            errors : {
                302 : { title : 'Unexpected Redirect',   description: `The server encounted an unexpected redirect to another page.` },
                401 : { title : 'Unauthorized',          description: `You are not authorized to perform this action.` },
                402 : { title : 'Billing Issue',         description: `You are not able to proceed due to an outstanding payment, or lack of a subscription. Please advise the owner of the organization.` },
                403 : { title : 'Forbidden',             description: `An error was encountered while attempting to access this page.` },
                404 : { title : 'Not Found',             description: `The page you were trying to access could not be found.` },
                405 : { title : 'Not Allowed',           description: `The chosen request method is not supported for the requested resource.` },
                408 : { title : 'Request Timeout',       description: `The server timed out while waiting for a response from an external site. Please try again, or contact us.` },
                419 : { title : 'Page Expired',          description: `The security token for the page has expired. Please refresh the page and try again.` },
                422 : { title : 'Unprocessable Request', description: `The server was unable to process your request. Please try again.` },
                429 : { title : 'Too Many Requests',     description: `Too many requests have been sent. Please wait a few minutes.` },
                500 : { title : 'Server Issue',          description: `The server encountered an unknown error and was unfortunately unable to recover from it. Please try again, or contact us.` },
            },

            details : {
                403 : `
                        Common reasons why this may occur include reaching a limit e.g. the
                        maximum number of skills you can add to your profile. It may also be
                        caused by the absence of data e.g. a vacancy having no requirements.

                        <br /><br />

                        It is recommended that you visit the main page for the resource in
                        question e.g. 'Skills' and check to see if you've hit your limits,
                        or whether any required data is missing.

                        <br /><br />

                        Alternatively, you might not be authorized to have access to the
                        requested resource e.g. the billing portal.
                      `,
            }
        }},

        /**
         * Execute actions when the component is instantiated.
         *
         */
        created()
        {
            document.title = 'Lumeno - Error';
        },
    }
</script>