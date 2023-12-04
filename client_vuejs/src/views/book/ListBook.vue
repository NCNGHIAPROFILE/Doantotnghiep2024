<template>
  <div>
    <v-app-bar app color="error">
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title class="mr-6">List Sách giấy</v-toolbar-title>
      <v-btn class="ma-2" color="#90CAF9" @click="handleAddNew()">
        <span class="mdi mdi-book-plus"></span>Thêm mới</v-btn>
      <v-spacer></v-spacer>

      <v-btn class="ma-2" outlined color="#90CAF9" @click="logout">
        <span class="mdi mdi-logout"></span>
        Logout</v-btn>
    </v-app-bar>

    <v-navigation-drawer v-model="drawer" app color="#90CAF9">
      <v-list-item>
        <v-list-item-content class="pa-2">
          <v-list-item-title class="text-h2 font-weight-bold">{{ userName }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    
      <v-list-item-group>
        <v-list-item>
          <span class="mdi mdi-book-open-blank-variant"></span>
          <v-menu offset-y>
            <template v-slot:activator="{ on }">
              <v-btn text v-on="on">
                Quản lý sách
                <v-icon right>mdi-menu-down</v-icon>
              </v-btn>
            </template>
            <v-list color="#B2EBF2">
              <v-list-item>
                <v-btn text @click="handleMenuItemClickBook('1')">Sách Giấy</v-btn>
              </v-list-item>
              <v-list-item>
                <v-btn text @click="handleMenuItemClickBook('2')">Sách Số</v-btn>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-list-item>
        <v-list-item>
          <span class="mdi mdi-ticket-account"></span>
          <v-menu offset-y>
            <template v-slot:activator="{ on }">
              <v-btn text v-on="on">
                Quản lý phiếu mượn
                <v-icon right>mdi-menu-down</v-icon>
              </v-btn>
            </template>
            <v-list color="#B2EBF2">
              <v-list-item>
                <v-btn text @click="handleMenuItemClick('1')">Phiếu chưa duyệt</v-btn>
              </v-list-item>
              <v-list-item>
                <v-btn text @click="handleMenuItemClick('2')">Phiếu đã duyệt</v-btn>
              </v-list-item>
              <v-list-item>
                <v-btn text @click="handleMenuItemClick('3')">Phiếu đã trả</v-btn>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-list-item>
        <v-list-item>
          <span class="mdi mdi-account-cog"></span>
          <v-btn text @click="handleUser">Quản lý người dùng</v-btn>
        </v-list-item>
        <v-list-item>
          <span class="mdi mdi-account-key"></span>
          <v-btn text>Account</v-btn>
        </v-list-item>
        <v-list-item>
          <span class="mdi mdi-information"></span>
          <v-btn text>About</v-btn>
        </v-list-item>
      </v-list-item-group>
    </v-navigation-drawer>
    <v-data-table
      :headers="headers"
      :items="data?.books"
      :items-per-page="5"
      class="elevation-1"
    >
    <template v-slot:[`item.Picture`]="{ item }">
      <v-img :src="'http://127.0.0.1:8000/images/' + item.Picture" max-width="100" max-height="100"></v-img>
    </template>
      <template v-slot:[`item.Type`]="{ item }">
        <div>
          {{ item.Type == 0 ? "Sách Giấy" : "Sách Số"}}
        </div>
      </template>
      <template v-slot:[`item.Status`]="{ item }">
        <div>
          {{ item.Status == 0 ? "Đang sử dụng" : "Không tồn tại"}}
        </div>
      </template>
      <template v-slot:[`item.Quantity`]="{ item }">
        <div>
          {{ item.Quantity == 0 ? "Hết sách" : "Còn sách"}}
        </div>
      </template>
      <template v-slot:[`item.actions`]="{ item }">
        <div>
          <v-btn color="primary" @click="update()"> Update </v-btn>
          <v-btn color="warning" @click="remove(item)"> Remove </v-btn>
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
      userName: "Hello Admin",
      drawer: true,
      books: [], 
      selectedFile: null,
      data: {},
      headers: [
        { text: "id", value: "id" },
        { text: "Picture", value: "Picture" },
        { text: "MaSach", value: "MaSach" },
        { text: "NameBook", value: "NameBook" },
        { text: "Author", value: "Author" },
        { text: "MaAdmin", value: "MaAdmin" },
        { text: "Category", value: "Category" },
        { text: "Type", value: "Type" },
        { text: "MaProducer", value: "MaProducer" },
        { text: "YearPublish", value: "YearPublish" },
        { text: "Tình trạng sách", value: "Quantity" },
        { text: "Content", value: "Content" },
        { text: "Status", value: "Status" },
        { text: "Sum_Quantity", value: "Sum_Quantity" },
        { text: "Actions", value: "actions", sortable: false },
      ],
    };
  },
  created() {
    this.getData();
  },
  methods: {
    logout() {
      Request.post("logout")
      .then(response => {
          console.log(response.data);
          this.$router.push('/login');
        })
        .catch(error => {
          console.error('Logout error:', error);
        });
    },
    getData() {
      Request.get("Books/ListBookBasic")
        .then((response) => {
          this.data = response.data;
          console.log(response);
        })
        .catch(() => {})
        .finally(() => {});
    },
    handleAddNew(){
      this.$router.push({ name: "AdminForm" });
    },
    update(){
      this.$router.push({ name: "FormUpdateAdmin" });
    },
    remove(item) {
      Request.delete("Books/DeleteBook/" + item.id)
        .then((response) => {
          if (response.data.status == 200){
            this.getData();
          }
        })
        .catch(() => {})
        .finally(() => {});
    },
    handleUser(){
      this.$router.push({ name: "ListUser" });
    },
    handleMenuItemClick(item) {
      if (item == 1){
        this.$router.push({ name: "AdminListTicketCreate" });
      }else if (item == 2){
        this.$router.push({ name: "AdminListTicketAccpet" });
      } else if (item == 3){
        this.$router.push({ name: "AdminListTicketGiveback" });
        console.log(`Clicked on ${item}`);
      }
    },
    handleMenuItemClickBook(item) {
      if (item == 1){
        this.$router.push({ name: "AdminListBook" });
      }else if (item == 2){
        this.$router.push({ name: "AdminListBookNumber" });
      }
    },
  },
};
</script>

<style>
.inline {
  display: flex;
}
</style>
