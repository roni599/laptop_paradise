import { createRouter, createWebHistory } from 'vue-router';

import Login from '../components/auth/Login.vue';
import Register from '../components/auth/Register.vue';
import Forget from '../components/auth/Forget.vue';
import Home from '../components/Home.vue';
import Logout from '../components/auth/Logout.vue';

import Create_user from '../components/users/Create_user.vue';
import User_list from '../components/users/User_list.vue';
import Role from '../components/users/Role.vue';

import Brand from '../components/brands/Brand.vue';

import Category from '../components/category/Category.vue';

const routes = [
    { name: 'LoginForm', component: Login, path: '/' },
    { name: 'RegisterForm', component: Register, path: '/register' },
    { name: 'Forget', component: Forget, path: '/forget' },
    { name: 'Home', component: Home, path: '/home' },
    { name: 'Logout', component: Logout, path: '/logout' },



    { name: 'User_create', component: Create_user, path: '/user_create' },
    { name: 'All_user', component: User_list, path: '/all_user' },
    { name: 'Role', component: Role, path: '/role' },

    { name: 'Brand', component: Brand, path: '/brand' },

    { name: 'Category', component: Category, path: '/category' },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;