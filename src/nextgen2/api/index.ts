const API_URL = '/api/v2/';

const FETCH_BASE = (url: string, options: RequestInit = {}) => {
    const headers = new Headers({
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-WP-Nonce': yipnyap_constants.wp_rest_nonce,
    });

    const defaultOptions = {
        headers, ...options,
    };

    return fetch(url, defaultOptions).then(async (response) => {
        const data = await response.json();
        switch (response.status) {
            case 401:
                throw new Error(data.message || 'UNAUTHORIZED');
            case 403:
                throw new Error(data.message || 'FORBIDDEN');
            case 404:
                throw new Error(data.message || 'NOT_FOUND');
            case 500:
                throw new Error(data.message || 'INTERNAL_SERVER_ERROR');
            default:
                break;
        }

        return data;
    });
}

export const FetchHandler = {
    get: (name: string, options: RequestInit = {}) => {
        const url = `${API_URL}${name}/`;
        return FETCH_BASE(url, options);
    },

    post: (name: string, options: RequestInit = {}) => {
        const url = `${API_URL}${name}/`;
        return FETCH_BASE(url, {
            ...options,
            method: 'POST',
        });
    },

    put: (name: string, options: RequestInit = {}) => {
        const url = `${API_URL}${name}/`;
        return FETCH_BASE(url, {
            ...options,
            method: 'PUT',
        });
    },

    delete: (name: string, options: RequestInit = {}) => {
        const url = `${API_URL}${name}/`;
        return FETCH_BASE(url, {
            ...options,
            method: 'DELETE',
        });
    },
}