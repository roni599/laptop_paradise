import './bootstrap';
import { createApp } from 'vue'
import router from './routes/router';
import App from './components/App.vue';

import User from './Helpers/User';
window.User = User;

import Swal from 'sweetalert2';
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});
window.Toast = Toast;

createApp(App).use(router).mount("#app")
