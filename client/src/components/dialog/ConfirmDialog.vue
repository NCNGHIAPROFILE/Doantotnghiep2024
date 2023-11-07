<template>
    <v-card class="dialog">
      <v-card-title>
        <div :style="getTitleColorStyle" >{{ title }}</div>
      </v-card-title>
      <v-card-text class="body">
        <div class="text-wrap">
          <v-card-text class="text" v-html="text"></v-card-text>
        </div>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn depressed outlined :color="getColor" class="btn" @click="$emit('close')"> {{ textClose }} </v-btn>
        <v-btn depressed :color="getColor" class="btn" @click="$emit('yes')">
          {{ textSubmit }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </template>
  
  <script>
  
  export default {
    components: {},
    props: {
      text: {
        type: String,
      },
      title: {
        type: String,
      },
      textClose: {
        default: 'No',
        type: String,
      },
      textSubmit: {
        default: 'Yes',
        type: String,
      },
      warning: {
          type: Boolean,
          default: false,
      },
      showDialog: {
        default: true,
        type: Boolean,
      }
    },
    data: () => ({}),
    computed: {
      getTitleColorStyle() {
      return this.warning ? "color:red;" : "";
      },
      getColor() {
      return this.warning ? "warning" : "primary";
      },
  },
    methods: {},
  };
  </script>
  <style lang="scss" scoped>
  .dialog {
    padding-bottom: 20px;
    .header {
      .header-title-area {
        display: flex;
        justify-content: space-between;
        min-width: 100%;
        max-width: 100%;
      }
    }
    .body {
      .text-wrap {
        padding: 16px 0;
        position: relative;
        .text {
          text-align: center;
          top: 0;
          right: 0;
          bottom: 0;
          left: 0;
          margin: auto;
          width: 80%;
        }
      }
    }
    .btn {
      margin-right: 12px;
    }
  }
  </style>
  