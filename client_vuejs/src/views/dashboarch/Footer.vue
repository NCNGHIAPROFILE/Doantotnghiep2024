<template>
    <v-footer
      app
      id="dashboard-core-footer"
    >
      <v-container>
        <v-row align="center" no-gutters>
          <v-spacer class="hidden-sm-and-down" />
          <v-col cols="12" md="auto">
            <div class="body-1 font-weight-light pt-6 pt-md-0 text-center">
              &copy; Made By  
              <v-icon size="18">
                mdi-heart
              </v-icon>
              <a href="https://genk.mediacdn.vn/2017/unnamed-file-1503649109771.jpg">Nguyễn Chính Nghĩa</a>.
            </div>
          </v-col>
        </v-row>
      </v-container>
    </v-footer>
  </template>
  
  <script>
    export default {
      name: 'DashboardCoreFooter',
      data: () => ({
        
      }),
    }
  </script>
  
  <style lang="sass">
    #dashboard-core-footer
      a
        font-size: .825rem
        font-weight: 500
        text-decoration: none
        text-transform: uppercase
  </style>