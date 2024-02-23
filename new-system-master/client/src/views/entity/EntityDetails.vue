<template>
    <VContainer>
        <EntityBasicInformationCard />
    </VContainer>
</template>

<script>

import EntityBasicInformationCard from '../../components/EntityBasicInformationCard.vue';

export default {
    name: 'EntityDetails',
    components: {
        EntityBasicInformationCard,
    },
};
</script>

<style scoped>
</style>
