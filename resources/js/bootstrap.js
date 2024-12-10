import axios from 'axios';
window.axios = axios;
document.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found');
}

window.axios.defaults.timeout = 30_000;
window.axios.defaults.withCredentials = true;
window.axios.defaults.headers.common['Authorization'] = localStorage.getItem('token');
window.axios.defaults.headers.common['Accept'] = 'application/json';
