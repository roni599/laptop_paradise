import { createRouter, createWebHistory } from 'vue-router';

import Login from '../components/auth/Login.vue';
import Register from '../components/auth/Register.vue';
import Forget from '../components/auth/Forget.vue';
import Home from '../components/Home.vue';
import Logout from '../components/auth/Logout.vue';

import Employee_create from '../components/employee/Employee_create.vue';
import All_employee from '../components/employee/All_employee.vue';

import Supplier_create from '../components/supplier/Supplier_create.vue';
import All_supplier from '../components/supplier/All_supplier.vue';

import Category_create from '../components/category/Category_create.vue';
import All_category from '../components/category/All_category.vue';

import Product_create from '../components/product/Product_create.vue';
import All_product from '../components/product/All_product.vue';
import Stocks from '../components/product/Stocks.vue';

import Expense_create from '../components/expense/Expense_create.vue';
import All_expense from '../components/expense/All_expense.vue';

import Customer_create from '../components/customer/Customer_create.vue';
import All_customers from '../components/customer/All_customers.vue';
import Pos from '../components/pos/Pos.vue';
import Create_user from '../components/users/Create_user.vue';
import User_list from '../components/users/User_list.vue';
import Role from '../components/users/Role.vue';

const routes = [
    { name: 'LoginForm', component: Login, path: '/' },
    { name: 'RegisterForm', component: Register, path: '/register' },
    { name: 'Forget', component: Forget, path: '/forget' },
    { name: 'Home', component: Home, path: '/home' },
    { name: 'Logout', component: Logout, path: '/logout' },

    { name: 'Employee_create', component: Employee_create, path: '/employee_create' },
    { name: 'All_employee', component: All_employee, path: '/all_employee' },

    { name: 'Supplier_create', component: Supplier_create, path: '/supplier_create' },
    { name: 'All_supplier', component: All_supplier, path: '/all_supplier' },

    { name: 'Category_create', component: Category_create, path: '/category_create' },
    { name: 'All_category', component: All_category, path: '/all_category' },

    { name: 'Product_create', component: Product_create, path: '/product_create' },
    { name: 'All_product', component: All_product, path: '/all_product' },
    { name: 'Stocks', component: Stocks, path: '/stocks' },

    { name: 'Expense_create', component: Expense_create, path: '/expense_create' },
    { name: 'All_expense', component: All_expense, path: '/all_expense' },

    { name: 'Customer_create', component: Customer_create, path: '/customer_create' },
    { name: 'All_customer', component: All_customers, path: '/all_customer' },

    { name: 'pos', component: Pos, path: '/pos' },


    { name: 'User_create', component: Create_user, path: '/user_create' },
    { name: 'All_user', component: User_list, path: '/all_user' },
    { name: 'Role', component: Role, path: '/role' },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;