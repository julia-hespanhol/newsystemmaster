<template>
    <VRow>
        <VCol
            cols="12"
            class="pb-0"
        >
            <VTextField
                v-model="search"
                outlined
                label="Filter entities..."
                append-icon="mdi-magnify"
            >
                <template
                    #append-outer
                >
                    <EntityRegistrationDialog />
                </template>
            </VTextField>
        </VCol>
        <VCol
            cols="12"
            class="pt-0"
        >
            <VCard>
                <VDataTable
                    :search="search"
                    :headers="headers"
                    :items="entities"
                    :calculate-widths="true"
                    :items-per-page="-1"
                    table-height="80vh"
                >
                    <template v-slot:item.name="{ item }">
                        <RouterLink
                            :to="{ name: 'entity-details', params: { id: item.id }}"
                            class="d-inline mx-1 link"
                            target="_blank"
                        >
                            {{ item.name }}
                            <VIcon
                                small
                                color="primary"
                            >
                                mdi-open-in-new
                            </VIcon>
                        </RouterLink>
                    </template>
                </VDataTable>
            </VCard>
        </VCol>
    </VRow>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from 'vuex';
import EntityRegistrationDialog from './EntityRegistrationDialog.vue';

export default {
    name: 'EntitiesTable',
    components: {
        EntityRegistrationDialog,
    },
    data() {
        return {
            headers: [
                { text: 'First Name', value: 'name', width: '350' },
                { text: 'Institute', value: 'institute.name', width: '350' },
            ],
            search: '',
        };
    },
    computed: {
        ...mapGetters('entity', [
            'entities',
        ]),
    },
    created() {
        if (!this.entities.length) {
            this.loadEntities();
        }
    },
    methods: {
        ...mapActions('entity', ['fetchEntities']),
        ...mapMutations('exception', ['activeException']),
        loadEntities() {
            this.fetchEntities().then(() => {}).catch((error) => {
                const exception = {
                    errorMessage: 'Error while loading entities.',
                    jiraLink: process.env.VUE_APP_JIRA_LINK,
                };
                this.activeException(exception);
                return error;
            });
        },
    },
};
</script>

<style scoped>
</style>
