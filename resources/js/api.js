import axios from 'axios';

// Set the base URL for your Laravel backend API
axios.defaults.baseURL = 'http://localhost/companymanage/public/api';

// Set the Axios interceptors to include the CSRF token and handle authentication errors
axios.interceptors.request.use((config) => {
  const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
  config.headers['X-XSRF-TOKEN'] = csrfToken;
  return config;
});

axios.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response.status === 401) {
      // Handle unauthorized errors, e.g., redirect to login page
    }
    return Promise.reject(error);
  },
);

export default axios;