<template>
    <div>
      <v-app-bar app color="error">
        <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
  
        <v-toolbar-title class="mr-6">Lịch sử tải xuống</v-toolbar-title>
        <v-spacer></v-spacer>
  
        <v-btn class="ma-2" outlined color="#90CAF9" @click="logout()">
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
            <span class="mdi mdi-briefcase-eye-outline"></span>
            <v-menu offset-y>
              <template v-slot:activator="{ on }">
                <v-btn text v-on="on">
                  Xem thư viện
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
                  Danh sách Phiếu mượn
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
            <span class="mdi mdi-file-download"></span>
            <v-btn text @click="handleUserHistoryClick()">Lịch sử tải xuống</v-btn>
          </v-list-item>
          <v-list-item>
            <span class="mdi mdi-account-cog"></span>
            <v-menu offset-y>
              <template v-slot:activator="{ on }">
                <v-btn text v-on="on">
                  Thông tin cá nhân
                  <v-icon right>mdi-menu-down</v-icon>
                </v-btn>
              </template>
              <v-list color="#B2EBF2">
                <v-list-item>
                  <v-btn text @click="handleUserItemClick('1')">Cập nhật thông tin</v-btn>
                </v-list-item>
                <v-list-item>
                  <v-btn text @click="handleUserItemClick('2')">Thay đổi password</v-btn>
                </v-list-item>
              </v-list>
            </v-menu>
          </v-list-item>
        </v-list-item-group>
    </v-navigation-drawer>  
    <v-data-table
        :headers="headers"
        :items="data?.historys"
        :items-per-page="5"
        class="elevation-1"
    >
    </v-data-table>
    </div>
  </template>
  <script>
  import Request from "@/plugins/request.js";
  export default {
    data() {
      return {
        userName: "Hello DAUer",
        drawer: true,
        data: {},
        search: "",
        historys: [],
        headers: [
          { text: "id", value: "id" },
          { text: "MaSach", value: "MaSach" },
          { text: "MaSV", value: "MaSV" },
          { text: "DateDownload", value: "DateDownload" },
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
        Request.get("Historys/ShowUserHistoryBook")
        .then((response) => {
            console.log(response.data);
            this.data = response.data;
        })
        .catch(() => {})
        .finally(() => {});
      },
      handleMenuItemClick(item) {
        if (item == 1){
            this.$router.push({ name: "UserListTicketCreate" });
        }else if (item == 2){
            this.$router.push({ name: "UserListTicketAccpet" });
        }else if (item == 3){
            this.$router.push({ name: "UserListTicketGiveback" });
        }
      },
      handleMenuItemClickBook(item) {
        if (item == 1){
            this.$router.push({ name: "Home" });
        }else if (item == 2){
            this.$router.push({ name: "UserListBookNumber" });
        }
      },
      handleUserItemClick(item) {
        if (item == 1){
            this.$router.push({ name: "UserInfo" });
        }else if (item == 2){
            this.$router.push({ name: "UserPassword" });
        }
      },
      handleUserHistoryClick(){
        this.$router.push({ name: "UserHistory" });
      }
    },
  };
  </script>
  
  <style>
  .inline {
    display: flex;
  }
  </style>
  