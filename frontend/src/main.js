import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';

import App from './App.vue';
import axios from 'axios';
import BaseLayout from './components/layouts/BaseLayout.vue';
import AuthorizedLayout from './components/layouts/AuthorizedLayout.vue';
import LoginForm from './components/forms/LoginForm.vue';
import SignupForm from './components/forms/SignupForm.vue';
import MainDashboard from './components/MainDashboard.vue';
import RedirectComponent from './components/RedirectComponent.vue';

import { library } from '@fortawesome/fontawesome-svg-core'

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

/* import specific icons */
import { faClipboard,faEdit,faTrashCan,faBarChart,faCalendar } from '@fortawesome/free-regular-svg-icons'

/* add icons to the library */
library.add(faClipboard,faEdit,faTrashCan,faBarChart,faCalendar)

const guard = function (to, from, next) {
  axios.get('http://localhost:81/api/user',{
    headers: {
      Authorization: `Bearer ${localStorage.getItem("auth_token")}`, 
    }
  }).then(() => {
    next()
  }).catch(() => {
    next('/login')
  });
}

const routes = [
  {
    path: '/',
    component: AuthorizedLayout,
    children: [
      {
        path: '/',
        component:MainDashboard,
        meta: {
          layout: 'default'
        },
        beforeEnter: (to,from,next) => {
          guard(to,from,next);
        }
      },
    ]
  },
  {
    path: '/',
    component: BaseLayout,
    children: [
      {
        path: '/login',
        component: LoginForm,
        meta: {
          layout: 'default',
        },
      },
      {
        path: '/signup',
        component: SignupForm,
        meta: {
          layout: 'default'
        }
      },
      {
        path: '/:shortUrl', // Dynamic segment for shortUrl
        name: 'ShortenedLink',
        component: RedirectComponent,
      },
    ]
  },

];

const router = createRouter({
  history: createWebHistory(),
  routes,
});


const app = createApp(App)
.component('font-awesome-icon', FontAwesomeIcon);
app.use(router);

app.mount('#app');
