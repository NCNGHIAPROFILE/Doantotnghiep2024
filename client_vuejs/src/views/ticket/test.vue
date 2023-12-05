<template>
  <v-card class="mx-auto" max-width="600">
    <v-img
      class="align-end text-white"
      height="300"
      src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
      cover
    >
      <v-row class="fill-height align-end">
        <v-col>
          <v-card-title :style="{ fontSize: '26px', fontWeight: 'bold' }" class="white--text">
            Top 10 Australian beaches
          </v-card-title>
        </v-col>
      </v-row>
    </v-img>

    <v-card-text>
      <v-row>
        <v-col>
          <v-divider class="my-3"></v-divider>
          <div class="headline">
            <strong>Beach Name:</strong> {{ beachName }}
          </div>
          <div class="subheading">
            <strong>Location:</strong> {{ location }}
          </div>
        </v-col>
      </v-row>
    </v-card-text>

    <v-card-actions>
      <v-btn color="orange" @click="explore">Explore</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  data() {
    return {
      beachName: 'Whitehaven Beach',
      location: 'Whitsunday Island, Whitsunday Islands',
    };
  },
  methods: {
    explore() {
    },
  },
};
</script>

<style scoped>
  .headline {
    font-size: 20px;
    font-weight: bold;
    margin-top: 10px;
  }

  .subheading {
    font-size: 16px;
    margin-top: 5px;
  }
</style>
