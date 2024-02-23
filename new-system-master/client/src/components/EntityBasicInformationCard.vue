<template>
    <VCard>
        <VRow>
            <VCardTitle
                class="ml-4"
            >
                {{ entity.name }}
                <EntityEditionDialog />
            </VCardTitle>
            <VCardText>
                <VDivider />
                <VList>
                    <VListItem>
                        <VListItemIcon>
                            <VIcon v-text="'mdi-city'" />
                        </VListItemIcon>
                        <VListItemContent>
                            <VListItemTitle>
                                {{ entity.institute.name }}
                            </VListItemTitle>
                        </VListItemContent>
                    </VListItem>
                </VList>
            </VCardText>
        </VRow>
    </VCard>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import EntityEditionDialog from './EntityEditionDialog.vue';

export default {
    name: 'EntityBasicInformationCard',
    components: {
        EntityEditionDialog,
    },
    computed: {
        ...mapGetters('entity', [
            'entity',
        ]),
    },
    created() {
        this.fetchEntityDetails();
    },
    methods: {
        ...mapActions('entity', [
            'fetchEntity',
        ]),
        async fetchEntityDetails() {
            if (
                !this.entity
                || (this.entity && (this.entity.id !== this.$route.params.id))
            ) {
                await this.fetchEntity(this.$route.params.id);
            }
        },
    },
};
</script>

<style scoped>
</style>
