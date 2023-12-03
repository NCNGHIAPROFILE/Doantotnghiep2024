<template>
    <v-app>
      <v-app-bar app>
        <v-app-bar-nav-icon @click.stop="toggleDrawer"></v-app-bar-nav-icon>
        <v-toolbar-title>{{ pageTitle }}</v-toolbar-title>
        <v-spacer></v-spacer>
        <!-- Other header elements or actions can go here -->
      </v-app-bar>
  
      <!-- Your main content goes here -->
  
      <v-navigation-drawer app v-model="drawer">
        <v-list>
            <v-list-item link to="/admin-list-ticket">
              <v-list-item-icon>
                <v-icon>mdi-view-dashboard</v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title>Dashboard</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
    
            <v-list-item link to="/profile">
              <v-list-item-icon>
                <v-icon>mdi-account</v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title>Profile</v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-list-item link to="/profile">
                <v-list-item-icon>
                  <v-icon>mdi-account</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                  <v-list-item-title>Profile</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
      
    
          </v-list>
      </v-navigation-drawer>
    </v-app>
  </template>
  
  <script>
  export default {
    data() {
      return {
        drawer: false,
        pageTitle: 'Your Page Title',
      };
    },
    methods: {
      toggleDrawer() {
        this.drawer = !this.drawer;
      },
    },
  };
  </script>
  
  <style>
  /* Your custom styles can go here */
  </style>
  