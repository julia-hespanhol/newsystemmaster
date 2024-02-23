<template>
    <div>
        <VDialog
            v-model="dialog"
            max-width="700"
        >
            <template v-slot:activator="{ on }">
                <VBtn
                    v-on="on"
                >
                    <VIcon> mdi-plus </VIcon> Register Entity
                </VBtn>
            </template>
            <VForm>
                <VCard
                    max-width="700"
                >
                    <VCardTitle>
                        <VIcon> mdi-plus </VIcon>
                        Register Entity
                    </VCardTitle>
                    <VDivider />
                    <VCardText>
                        <VTextField
                            v-model="name.value"
                            :label="name.label"
                        />
                    </VCardText>
                    <VDivider />
                    <VCardActions>
                        <VSpacer />
                        <VBtn
                            color="primary"
                            class="ml-4"
                            outlined
                            @click="dialog = false"
                        >
                            Close
                        </VBtn>
                        <VBtn
                            color="primary"
                            class="ml-4"
                            outlined
                            type="submit"
                        >
                            Save
                            <VIcon right>
                                mdi-floppy
                            </VIcon>
                        </VBtn>
                    </VCardActions>
                </VCard>
            </VForm>
        </VDialog>
        <VSnackbar
            v-model="snackbar"
            :timeout="2000"
            color="green darken-3"
        >
            Entity successfully registered!
        </VSnackbar>
    </div>
</template>

<script>

import { mapActions, mapGetters, mapMutations } from 'vuex';

export default {
    name: 'EntityEditionDialog',
    data() {
        return {
            dialog: false,
            loading: false,
            snackbar: false,
            name: {
                value: null,
                label: 'Name *',
            },
        };
    },
    computed: {
        ...mapGetters('entity', ['entity']),
    },
    methods: {
        ...mapActions('entity', [
            'registerEntity',
        ]),
        ...mapMutations('exception', [
            'activeException',
        ]),
        submit() {
            const payload = {
                id: this.entity.id,
                name: this.entity.name,
            };
            this.registerEntity(payload).then(() => {
                this.dialog = false;
                this.loading = false;
                this.snackbar = true;
                this.resetForm();
            }).catch(() => {
                const exception = {
                    errorMessage: 'Error while saving update',
                    jiraLink: process.env.VUE_APP_JIRA_LINK,
                };
                this.activeException(exception);
                this.loading = false;
                this.dialog = false;
            });
        },
        resetForm() {
            this.name.value = null;
        },
    },
};
</script>

<style lang="css" scoped>
</style>
