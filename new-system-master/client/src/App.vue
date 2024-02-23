<template>
    <VApp>
        <VContainer>
            <VRow>
                <img
                    alt="Vue logo"
                    src="./assets/AMBER-logo.png"
                    class="center"
                >
            </VRow>
        </VContainer>
        <VMain>
            <RouterView />
        </VMain>
    </VApp>
</template>

<script>
import { mapMutations } from 'vuex';

export default {
    name: 'App',
    methods: {
        ...mapMutations('exception', [
            'activeException',
        ]),
    },
};
</script>

<style>
.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
}
</style>
