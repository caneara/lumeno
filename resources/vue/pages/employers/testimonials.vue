<template>
    <div class="border-t border-gray-200 flex justify-center items-center py-16 md:py-30 lg:py-40">

        <!-- Testimonials -->
        <div class="grid grid-cols-1 gap-6"
             :class="testimonials.length === 1 ? '' : 'md:grid-cols-2'">

            <!-- Testimonial -->
            <div :key="testimonial.id"
                 v-for="testimonial in testimonials"
                 class="flex flex-col justify-center items-center">

                <!-- Stars -->
                <div class="flex">
                    <i v-for="n in 5"
                       class="fas fa-star text-20px text-yellow-500 mx-1 mb-8">
                    </i>
                </div>

                <!-- Quote -->
                <h3 class="max-w-[525px] font-medium text-22px md:text-24px text-center leading-snug px-6 md:px-2 mb-12">
                    “{{ testimonial.quote }}”
                </h3>

                <!-- Avatar -->
                <img alt="Avatar"
                     class="h-70px w-70px rounded-full mb-4"
                     :src="asset(`img/avatar-${testimonial.avatar}.jpg`)">

                <!-- Author -->
                <h6 class="text-sky-700 text-19px mb-0">
                    {{ testimonial.author }}
                </h6>

                <!-- Position -->
                <p class="text-gray-600 -mb-2">
                    {{ testimonial.position }}
                </p>

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
            testimonials : [
                {
                    id       : 1,
                    quote    : 'This is an absolute game changer. No longer do I need to waste time with job boards.',
                    author   : 'John Doe',
                    position : 'CEO of Acme Inc',
                    avatar   : 'matt',
                },
            ],
        }},
    }
</script>