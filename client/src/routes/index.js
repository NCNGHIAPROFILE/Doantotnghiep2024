import Vue from "vue";
import VueRouter from "vue-router";
// import axios from "axios";
import PageNotFound from '@/components/common/PageNotFound.vue';
import { DEFAULT_TITLE } from "@/common/constant.js";
import Login from "@/views/login/Login.vue";
import Home from "@/views/user/Home.vue";
import AdminListTicket from "@/views/admin/ListTicket.vue";
import BookDetail from "@/views/user/BookDetail.vue";
import Layout from '@/components/layout/Layout.vue'

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
      path: '/book-details',
      name: 'bookDetails',
      component: BookDetail,
      meta: { title: 'Home' }
    },
    {
      path: '/admin-list-ticket',
      name: 'adminListTicket',
      component: AdminListTicket,
      meta: { title: 'Home' }
    },
  ]
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
