import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';

import App from './App.vue';
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
          const isAuthUser = localStorage.getItem('auth_token') !== null;
                    
          if (isAuthUser){next();}

          next('/login');
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
