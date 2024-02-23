import httpClient from './httpClient';

const END_POINT = '/entities';

const getEntity = entityId => httpClient.get(`${END_POINT}/${entityId}`);

const getEntities = () => httpClient.get(`${END_POINT}`);

const registerEntity = entity => httpClient.post(`${END_POINT}`, {
    entity,
});

const updateEntity = entity => httpClient.patch(`${END_POINT}`, {
    entity,
});

export default {
    getEntity,
    getEntities,
    registerEntity,
    updateEntity,
};
