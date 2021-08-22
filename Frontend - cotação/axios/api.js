import axios from 'axios';
import global from '../url_api_axios.js';

const instance = axios.create({
    baseURL: global,
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
});

export default instance;