<template>
    <v-layout>

        <!-- Content -->
        <template #content>

            <!-- Header -->
            <h4>
                Members
            </h4>

            <!-- Information -->
            <p class="mb-8">
                View the complete directory of all team members within
                the organization. Team members with the manager role may
                perform additional administrative tasks, such as adding
                new members and changing the subscription plan.
            </p>

            <!-- List -->
            <v-list :show="! isPaginatorEmpty()"
                    :items="prop('members.data')"
                    :empty="getPaginatorEmptyMessage('There are no members in the organization')">

                <!-- Left -->
                <template v-slot:left="{ item }">

                    <!-- Avatar -->
                    <v-image type="user"
                             :source="item"
                             class="w-35px h-35px min-w-35px min-h-35px max-w-35px max-h-35px rounded-full mr-6">
                    </v-image>

                    <!-- Profile -->
                    <div class="w-full md:w-3/4">

                        <!-- Name -->
                        <span class="block font-semibold text-15px text-gray-800/85 mb-6px">
                            {{ item.name }}
                        </span>

                        <!-- Email Address -->
                        <span class="block text-15px text-gray-600/75 break-all">
                            {{ item.email }}
                        </span>

                    </div>

                </template>

                <!-- Right -->
                <template v-slot:right="{ item }">

                    <!-- Role -->
                    <v-pill class="w-[85px]"
                            :text="prop('roles').find(role => role.id === item.role).name"
                            :color="prop('roles').find(role => role.id === item.role).color">
                    </v-pill>

                    <!-- Actions -->
                    <v-menu :items="context(item)"
                            :id="`context-members-${item.id}`">
                    </v-menu>

                </template>

            </v-list>

            <!-- Pagination -->
            <v-pagination :paginator="paginator"></v-pagination>

        </template>

        <!-- Sidebar -->
        <template #sidebar>

            <!-- Text -->
            <span class="block font-medium text-12px text-gray-600/90 uppercase mb-9">
                Overview
            </span>

            <!-- Total -->
            <v-statistic icon="user"
                         :text="metric(prop('total'), 'team member')">
            </v-statistic>

            <!-- Actions -->
            <v-actions :items="actions"></v-actions>

            <!-- Filter -->
            <v-filter v-model="session.search.name"
                      @change="(event) => reloadPaginator(event, 'name')">
            </v-filter>

        </template>

        <!-- Other -->
        <template #other>

            <!-- Create Modal -->
            <v-create v-if="modals.create"
                      :visible="modals.create"
                      @closed="modals.create = false">
            </v-create>

            <!-- Edit Modal -->
            <v-edit :member="member"
                    v-if="modals.edit"
                    :visible="modals.edit"
                    @closed="modals.edit = false">
            </v-edit>

        </template>

    </v-layout>
</template>

<script>
    import EditPartial from './edit.vue';
    import Layout from '@/layout/index.vue';
    import CreatePartial from './create.vue';
    import ListComponent from '@/components/list.vue';
    import MenuComponent from '@/components/menu.vue';
    import PillComponent from '@/components/pill.vue';
    import ImageComponent from '@/components/image.vue';
    import ActionComponent from '@/components/actions.vue';
    import FilterComponent from '@/components/filter.vue';
    import StatisticComponent from '@/components/statistic.vue';
    import PaginationComponent from '@/components/pagination.vue';
    import InteractsWithFormatting from '@/mixins/InteractsWithFormatting';
    import InteractsWithPagination from '@/mixins/InteractsWithPagination';
    import InteractsWithAuthorization from '@/mixins/InteractsWithAuthorization';

    export default
    {
        /**
         * Define the mixins.
         *
         */
        mixins : [
            InteractsWithFormatting,
            InteractsWithPagination,
            InteractsWithAuthorization,
        ],

        /**
         * Define the components.
         *
         */
        components : {
            'v-actions'    : ActionComponent,
            'v-create'     : CreatePartial,
            'v-edit'       : EditPartial,
            'v-filter'     : FilterComponent,
            'v-image'      : ImageComponent,
            'v-layout'     : Layout,
            'v-list'       : ListComponent,
            'v-menu'       : MenuComponent,
            'v-pagination' : PaginationComponent,
            'v-pill'       : PillComponent,
            'v-statistic'  : StatisticComponent,
        },

        /**
         * Define the data model.
         *
         */
        data() { return {
            member : null,

            paginator : 'members',

            modals : {
                edit   : false,
                create : false,
            },

            actions : [
                {
                    id      : 'create-member',
                    show    : this.isManager(),
                    icon    : 'user-plus',
                    color   : 'text-emerald-700/70',
                    title   : 'Add member',
                    summary : 'Assign a user to your organization',
                    action  : () => this.modals.create = true,
                },
            ],
        }},

        /**
         * Execute actions when the component is instantiated.
         *
         */
        created()
        {
            session.search = createInertiaForm({
                name : queryString('name'),
            }, 'search');
        },

        /**
         * Define the supporting methods.
         *
         */
        methods :
        {
            /**
             * Retrieve the menu options for the given member.
             *
             */
            context(member)
            {
                return [
                    {
                        id     : `context-members-${member.id}-edit`,
                        icon   : 'key',
                        show   : member.permissions.edit,
                        type   : 'link',
                        label  : 'Change role',
                        action : () => { this.member = member; this.modals.edit = true },
                    }, {
                        show   : member.permissions.edit && member.permissions.delete,
                        type   : 'separator',
                    }, {
                        id     : `context-members-${member.id}-delete`,
                        icon   : 'trash-alt',
                        show   : member.permissions.delete,
                        type   : 'link',
                        label  : 'Delete member',
                        action : () => confirmAction('This will delete the team member.', () => submit(
                            createInertiaForm(), ['members.delete', member.id], 'delete')
                        ),
                    }
                ];
            },
        }
    }
</script>