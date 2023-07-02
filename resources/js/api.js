import axios from 'axios';

// Set the base URL for your Laravel backend API
axios.defaults.baseURL = 'http://localhost/companymanage/public';

// Set the Axios interceptors to include the CSRF token
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
axios.defaults.withCredentials = true;

// Make sure to remove the code for retrieving the token and setting the Authorization header

axios.get('/sanctum/csrf-cookie');

axios.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response.status === 401) {
      // Handle unauthorized errors, e.g., redirect to login page
      console.log("unauthorized action")
    }
    return Promise.reject(error);
  },
);

export default axios;