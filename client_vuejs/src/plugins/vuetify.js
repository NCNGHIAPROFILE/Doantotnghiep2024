import Vue from 'vue';
import Vuetify from 'vuetify/lib/framework';
// import i18n from '@/i18n'
import '@/sass/overrides.sass'

Vue.use(Vuetify);

const theme = {
    primary: '#4CAF50',
    secondary: '#9C27b0',
    accent: '#005caf',
    info: '#00CAE3',
  }

export default new Vuetify({
//   lang: {
//     t: (key, ...params) => i18n.t(key, params),
//   },
  theme: {
    themes: {
      dark: theme,
      light: theme,
    },
  },
})

