<template>
    <div>
        <VDialog
            v-model="dialog"
            max-width="700"
        >
            <template v-slot:activator="{ on, attrs }">
                <VBtn
                    color="primary"
                    small
                    dark
                    v-bind="attrs"
                    icon
                    class="ml-4"
                    v-on="on"
                >
                    <VIcon> mdi-pencil </VIcon>
                </VBtn>
            </template>
            <VForm>
                <VCard>
                    <VCardTitle>
                        <VIcon> mdi-pencil </VIcon>
                        Update Entity
                    </VCardTitle>
                    <VDivider />
                    <VCardText>
                        <VTextField
                            v-model="entityNameValue"
                            label="Name"
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
            Entity successfully updated!
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
        };
    },
    computed: {
        ...mapGetters('entity', ['entity']),
        entityNameValue: {
            get() {
                return this.entity.name;
            },
            set(value) {
                this.setName(value);
            },
        },
    },
    methods: {
        ...mapActions('entity', [
            'updateEntity',
            'setName',
        ]),
        ...mapMutations('exception', [
            'activeException',
        ]),
        submit() {
            const payload = {
                id: this.entity.id,
                name: this.entity.name,
            };
            this.updateEntity(payload).then(() => {
                this.dialog = false;
                this.loading = false;
                this.snackbar = true;
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
    },
};
</script>

<style lang="css" scoped>
</style>
