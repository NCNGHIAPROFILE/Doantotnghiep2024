<template>
  <div>
    <v-data-table
      :headers="headers"
      :items="data?.Tickets"
      :items-per-page="5"
      class="elevation-1"
    >
      <template v-slot:[`item.actions`]="{ item }">
        <div>
          <v-btn color="primary" @click="add(item)"> add </v-btn>
          <v-btn color="warning" @click="remove(item)"> remove </v-btn>
        </div>
      </template>
    </v-data-table>
  </div>
</template>
<script>
import Request from "@/plugins/request.js";
export default {
  data() {
    return {
      data: {},
      search: "",
      headers: [
        { text: "id", value: "id" },
        { text: "StatusTicket", value: "StatusTicket" },
        { text: "Note", value: "Note" },
        { text: "MaTicket", value: "MaTicket" },
        { text: "MaSach", value: "MaSach" },
        { text: "MaSV", value: "MaSV" },
        { text: "MaAdmin", value: "MaAdmin" },
        { text: "DateGiveBack", value: "DateGiveBack" },
        { text: "DateCreateTicket", value: "DateCreateTicket" },
        { text: "DateAcceptTiket", value: "DateAcceptTiket" },
        { text: "Actions", value: "actions", sortable: false },
      ],
    };
  },
  created() {
    this.getData();
  },
  methods: {
    getData() {
      Request.get("Tickets/ListTicket")
        .then((response) => {
          this.data = response.data;
          console.log(response.data.Tickets);
        })
        .catch(() => {})
        .finally(() => {});
    },
    add(item) {
      console.log(item);
    },
    remove(item) {
      Request.delete("Books/DeleteBook/" + item.id)
        .then((response) => {
          this.data = response.data;
          console.log(response.data.Tickets);
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
