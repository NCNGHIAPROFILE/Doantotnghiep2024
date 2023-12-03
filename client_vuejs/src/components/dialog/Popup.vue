<template>
    <v-row justify="center">
      <v-dialog 
      scrollable 
      :value="dialog" 
      persistent 
      :width="width" 
      :max-width="maxWidth" 
      @click:outside="$emit('clickOutSite')">
        <template v-if="dialog">
          <slot />
        </template>
      </v-dialog>
    </v-row>
  </template>
  <script>
  export default {
    props: {
      dialog: {
        type: Boolean,
      },
      width: {
        type: String,
        defaultValue: "100%",
      },
      maxWidth: {
        type: String,
        defaultValue: "100%",
      },
    },
  };
  </script>
  