/* eslint-disable no-unreachable */
import entityApi from '../../api/entity';

const stateData = {
    entities: [],
    entity: null,
};

const getters = {
    entities: state => state.entities,
    entity: state => state.entity,
};

const actions = {
    async fetchEntity({ commit }, entityId) {
        const response = await entityApi.getEntity(entityId);
        commit('SET_ENTITY', response.data.entity);
        return response;
    },
    async fetchEntities({ commit }) {
        const response = await entityApi.getEntities();
        commit('SET_ENTITIES', response.data.entities);
        return response;
    },
    async registerEntity({ commit }, entity) {
        const response = await entityApi.registerEntity(entity);
        commit('PUSH_ENTITY', response.data.entity);
        return response;
    },
    setName({ commit }, name) {
        commit('SET_ENTITY_NAME', name);
    },
};

const mutations = {
    SET_ENTITY(state, entity) {
        state.entity = entity;
    },
    SET_ENTITIES(state, entities) {
        state.entities = entities;
    },
    PUSH_ENTITY(state, entity) {
        state.entities.push(entity);
    },
    SET_ENTITY_NAME(state, name) {
        state.entity.name = name;
    },
};

export default {
    namespaced: true,
    state: stateData,
    getters,
    actions,
    mutations,
};
