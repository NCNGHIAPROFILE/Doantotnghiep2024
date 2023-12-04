import Vue from "vue";
import VueRouter from "vue-router";
// import axios from "axios";
import PageNotFound from '@/components/common/PageNotFound.vue';
import { DEFAULT_TITLE } from "@/common/constant.js";
import Login from "@/views/login/Login.vue";
import Home from "@/views/user/Home.vue";
import UserListBookNumber from "@/views/user/BookNumber.vue";
import UserListTicketCreate from "@/views/user/UserListTicketCreate.vue";
import UserListTicketAccpet from "@/views/user/UserListTicketAccpet.vue";
import UserListTicketGiveback from "@/views/user/UserListTicketGiveback.vue";
import UserHistory from "@/views/user/UserHistory.vue";
import UserForm from "@/views/user/Form.vue";
import FormUpdateUser from "@/views/user/FormUpdateUser.vue";

import AdminListTicketCreate from "@/views/admin/ListTicket.vue";
import AdminListTicketAccpet from "@/views/admin/LictTicketAcpect.vue";
import AdminListTicketGiveback from "@/views/admin/ListTicketGiveback.vue";
import FormUpdateAdmin from "@/views/admin/FormUpdateAdmin.vue";
import AdminForm from "@/views/admin/Form.vue";

import BookDetail from "@/views/admin/DetailBook.vue";
import AdminListBook from "@/views/book/ListBook.vue";
import AdminListBookNumber from "@/views/book/ListBookNumber.vue";
import Footer from "@/views/dashboarch/Footer.vue";
import Menu from "@/views/dashboarch/Menu.vue";
import DashboarchAdmin from "@/views/dashboarch/Admin.vue";
import ListUser from "@/views/user/ListUser.vue";
// import OTP from "@/views/user/otp.vue";
import VerifyOTP from "@/views/user/Verify_OTP.vue";
import Register from "@/views/user/Register.vue";


import Layout from '@/components/layout/Layout.vue';

Vue.use(VueRouter);
Vue.filter('capitalizeFirstLetter', function (value) {
  return value.charAt(0).toUpperCase() + value.slice(1);
})
const routes = [{
  path: '/login',
  name: 'Login',
  component: Login,
  meta: { title: 'Login' }
},
{
  path: '/verify-otp',
  name: 'OTP',
  component: VerifyOTP,
  meta: { title: 'OTP' }
},
{
  path: '/register',
  name: 'Register',
  component: Register,
  meta: { title: 'Register' }
},
{
  path: '/',
  redirect: 'login',
  name: 'Layout',
  component: Layout,
  children: [
    {
      path: '/home',
      name: 'Home',
      component: Home,
      meta: { title: 'Home' }
    },
    {
      path: '/form-update-user',
      name: 'FormUpdateUser',
      component: FormUpdateUser,
      meta: { title: 'FormUpdateUser' }
    },
    {
      path: '/user-form',
      name: 'UserForm',
      component: UserForm,
      meta: { title: 'UserForm' }
    },
    {
      path: '/form-update-admin',
      name: 'FormUpdateAdmin',
      component: FormUpdateAdmin,
      meta: { title: 'FormUpdateAdmin' }
    },
    {
      path: '/admin-form',
      name: 'AdminForm',
      component: AdminForm,
      meta: { title: 'AdminForm' }
    },
    {
      path: '/user-download',
      name: 'UserHistory',
      component: UserHistory,
      meta: { title: 'UserHistory' }
    },
    {
      path: '/user-list-book-number',
      name: 'UserListBookNumber',
      component: UserListBookNumber,
      meta: { title: 'UserListBookNumber' }
    },
    {
      path: '/user-list-ticket',
      name: 'UserListTicketCreate',
      component: UserListTicketCreate,
      meta: { title: 'UserListTicketCreate' }
    },
    {
      path: '/user-list-ticket-accept',
      name: 'UserListTicketAccpet',
      component: UserListTicketAccpet,
      meta: { title: 'UserListTicketAccpet' }
    },
    {
      path: '/user-list-ticket-giveback',
      name: 'UserListTicketGiveback',
      component: UserListTicketGiveback,
      meta: { title: 'UserListTicketGiveback' }
    },
    {
      path: '/book-detail',
      name: 'BookDetail',
      component: BookDetail,
      meta: { title: 'BookDetail' }
    },
    {
      path: '/admin-list-user',
      name: 'ListUser',
      component: ListUser,
      meta: { title: 'ListUser' }
    },
    {
      path: '/admin-list-ticket-create',
      name: 'AdminListTicketCreate',
      component: AdminListTicketCreate,
      meta: { title: 'AdminListTicketCreate' }
    },
    {
      path: '/admin-list-ticket-accpet',
      name: 'AdminListTicketAccpet',
      component: AdminListTicketAccpet,
      meta: { title: 'AdminListTicketAccpet' }
    },
    {
      path: '/admin-list-ticket-giveback',
      name: 'AdminListTicketGiveback',
      component: AdminListTicketGiveback,
      meta: { title: 'AdminListTicketGiveback' }
    },
    {
      path: '/admin-list-book',
      name: 'AdminListBook',
      component: AdminListBook,
      meta: { title: 'AdminListBook' }
    },
    {
      path: '/admin-list-book-number',
      name: 'AdminListBookNumber',
      component: AdminListBookNumber,
      meta: { title: 'AdminListBookNumber' }
    },
    {
      path: '/footer',
      name: 'footer',
      component: Footer,
      meta: { title: 'footer' }
    },
    {
      path: '/menu',
      name: 'menu',
      component: Menu,
      meta: { title: 'menu' }
    },
  ]
  },
  {
    path: '/dashboarch-admin',
    name: 'DashboarchAdmin',
    component: DashboarchAdmin,
    meta: { title: 'DashboarchAdmin' }
  },
  {
    path: '/404',
    name: 'PageNotFound',
    component: PageNotFound
  },
  {
    path: '*',
    redirect: { name: 'PageNotFound' }
  }
]

const router = new VueRouter({
  routes,
  base: process.env.BASE_URL,
  mode: "history",
});
router.beforeEach((to, from, next) => {
  // const publicPages = ['/login'];
  // const authRequired = !publicPages.includes(to.path);
  // const loggedIn = localStorage.getItem('authenticated');
  // axios.interceptors.response.use(
  //   (response) => response,
  //   async (error) => {
  //     if (error?.response?.status === 401) {
  //       localStorage.clear();
  //       return next('/login');
  //     }
  //     return Promise.reject(error);
  //   }
  // );
  // if (authRequired && !loggedIn) {
  //   return next('/login');
  // }
  next();
});

router.afterEach((to) => {
  Vue.nextTick(() => {
    document.title = to.meta.title + DEFAULT_TITLE || DEFAULT_TITLE;
  });
});

export { routes };
export default router;
