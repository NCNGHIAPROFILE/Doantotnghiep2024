<template>
    <div class="text-center loading-component">
      <v-progress-circular
        indeterminate
        color="primary"
        :size="size ?? 30"
      />
    </div>
  </template>
  <script>
  
  export default {
    props: {
      size: {},
    },
  };
  </script>
  <style scoped>
  .v-progress-circular {
    margin: 1rem;
  }
  .loading-component {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    height: calc(100%);
    z-index: 9999;
    background: rgba(0,0,0,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
  }
  </style>