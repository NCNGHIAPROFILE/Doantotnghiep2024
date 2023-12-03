<template>
  <div id="export-main">
    <div>Tên Sách: {{ data.NameBook }}</div>
    <div>Author: {{ data.Author }}</div>
    <div>Category: {{ data.Category }}</div>
    <div>Content: {{ data.Content }}</div>
    <div>MaAdmin: {{ data.MaAdmin }}</div>
    <div>MaProducer: {{ data.MaProducer }}</div>
    <div>MaSach: {{ data.MaSach }}</div>
    <v-btn color="primary" @click="muon()"> Mượn </v-btn>
    <v-btn color="primary" @click="exportToPDF(data.NameBook)"> Download </v-btn>
  </div>
</template>

<script>
import Request from "@/plugins/request.js";
import html2pdf from "html2pdf.js";
export default {
  data() {
    return {
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
      Request.get("Books/ShowBook/" + id)
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
    exportToPDF(name) {
			html2pdf(document.getElementById("export-main"), {
				filename: name + ".pdf",
			});
		},
  },
};
</script>

<style>
.inline {
  display: flex;
}
</style>
