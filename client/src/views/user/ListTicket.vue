<template>
  <div>
    <v-data-table
      :headers="headers"
      :items="desserts"
      :items-per-page="5"
      class="elevation-1"
    ></v-data-table>
  </div>
</template>

<script>
import Request from "@/plugins/request.js";
export default {
  data() {
    return {
      headers: [
        {
          text: "Dessert (100g serving)",
          align: "start",
          sortable: false,
          value: "name",
        },
        { text: "Calories", value: "calories" },
        { text: "Fat (g)", value: "fat" },
        { text: "Carbs (g)", value: "carbs" },
        { text: "Protein (g)", value: "protein" },
        { text: "Iron (%)", value: "iron" },
      ],
      data: {},
      search: "",
      typeSearch: "",
    };
  },
  created() {
    this.getData();
  },
  methods: {
    getData() {
      const id = this.$route.params.id;
      Request.get("Tickets/ListTicket" + id)
        .then((response) => {
          this.data = response.data.books;
          console.log(response);
        })
        .catch(() => {})
        .finally(() => {});
    },
    muon() {
      const param = {
        MaTicket: "",
        MaSV: localStorage.getItem("id"),
        MaSach: this.data.MaSach,
      };
      Request.post("Tickets/AddTicket", param)
        .then((response) => {
          this.data = response.data;
          console.log(response);
        })
        .catch(() => {})
        .finally(() => {});
    },
  },
};
</script>

<style>
.inline {
  display: flex;
}
</style>
