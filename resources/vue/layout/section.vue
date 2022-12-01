<template>
    <section class="flex flex-1 flex-wrap"
             :class="[
                invert ? 'bg-gray-200' : 'bg-white',
                padding ? `${dialog ? '' : 'py-6'} md:py-12 xl:py-14` : '',
             ]">

        <!-- Dialog -->
        <article v-if="dialog"
                 class="bg-white md:bg-transparent flex flex-col flex-1 justify-center items-center md:p-12 lg:p-14">

            <!-- Slot -->
            <div class="bg-white/75 md:border border-gray-400/80 max-w-600px md:rounded-lg p-10 md:p-20">
                <slot></slot>
            </div>

        </article>

        <!-- Container -->
        <div v-if="! dialog"
             class="lg:flex lg:justify-between flex-1 container h-full">

            <!-- Default -->
            <article class="flex-expand hide-when-empty">
                <slot></slot>
            </article>

            <!-- Content -->
            <article class="content w-full lg:max-w-600px xl:max-w-800px">
                <slot name="content"></slot>
            </article>

            <!-- Sidebar -->
            <aside class="sidebar hidden lg:block w-250px max-w-250px overflow-y-auto lg:sticky lg:top-100px xl:top-[115px] lg:self-start pt-1 xl:pt-0 ml-75px">
                <slot name="sidebar"></slot>
            </aside>

        </div>

        <!-- Other -->
        <div class="other">
            <slot name="other"></slot>
        </div>

    </section>
</template>

<script>
    export default
    {
        /**
         * Define the public properties.
         *
         */
        props : {
            'dialog'  : { type : Boolean, default : false },
            'invert'  : { type : Boolean, default : false },
            'padding' : { type : Boolean, default : true },
        },
    }
</script>