<template>
  <v-app id="inspire">
    <v-main style="height: 1000px;">
      <router-view />
      <v-footer app color="error">
        <v-col style="color: aliceblue;"
          class="text-center"
          cols="12"
        >
          {{ new Date().getFullYear() }} — <strong style="color: aliceblue;">DANANG ARCHITECTURE UNIVERSITY</strong>
        </v-col>
      </v-footer>  
    </v-main> 
  </v-app>
</template>

<script>

export default {
};
</script>

<style>

</style>
