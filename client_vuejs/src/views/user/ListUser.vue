<template>
    <div>
      <v-app-bar app color="error">
        <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
        <v-toolbar-title class="mr-6">List người dùng</v-toolbar-title>
        <v-btn class="ma-2" color="#90CAF9" @click="handleAddNew()">
          <span class="mdi mdi-book-plus"></span>
          Thêm mới</v-btn>
          <v-file-input
          style="padding-top: 20px;"
            v-model="selectedFile"
            :showSize="500"
            label="Chọn tệp tin Excel"
            accept=".xls, .xlsx, .csv"
            @change="onFileChange"
          ></v-file-input>

          <v-btn style="color: red; background-color:#90CAF9" @click="importUsers" :disabled="!selectedFile">
            <span class="mdi mdi-cloud-upload-outline" style="padding-right: 10px;"></span>
            Import Users</v-btn>
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
            <v-btn text @click="handlePageUser">Giao diện người dùng</v-btn>
          </v-list-item>
        </v-list-item-group>
      </v-navigation-drawer>
      <v-progress-circular
        indeterminate
        color="red"
        v-if="loading"  
        style="display: flex;
        align-items: center;
        justify-content: center;
        padding-left: 1500px"   
        absolute 
      ></v-progress-circular>
      <v-data-table
        :headers="headers"
        :items="data?.users"
        :items-per-page="5"
        class="elevation-1"
        style="display: block;"
      >
      <template v-slot:[`item.ImageUser`]="{ item }">
        <v-img :src="'http://127.0.0.1:8000/images/' + item.ImageUser" max-width="60" max-height="60"></v-img>
      </template>
        <template v-slot:[`item.actions`]="{ item }">
          <div>
            <div class="my-2">
              <v-btn color="primary" fab x-small dark @click="update()">
                <v-icon>mdi-pencil</v-icon>
              </v-btn>
              &nbsp;
              <v-btn color="warning" fab x-small dark @click="view()">
                <v-icon>mdi mdi-eye-outline</v-icon>
              </v-btn>
              &nbsp;
              <v-btn color="error" fab x-small dark @click="remove(item)">
                <v-icon>mdi mdi-trash-can</v-icon>
              </v-btn>
            </div>
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
        data: {},
        loading: false,
        selectedFile: null,
        headers: [
          { text: "id", value: "id" },
          { text: "Avatar", value: "ImageUser" },
          { text: "MSSV", value: "MaSV" },
          { text: "Họ", value: "FistNameUser"},
          { text: "Tên", value: "LastNameUser"},
          { text: "Lớp", value: "Class" },
          { text: "Địa chỉ", value: "AddressUser" },
          { text: "SĐT", value: "Phone" },
          { text: "Email", value: "email" },
          { text: "Actions", value: "actions", sortable: false },
        ],
      };
    },
    created() {
      this.getData();
    },
    methods: {
      onFileChange() {
        console.log("Selected file:", this.selectedFile);
      },
      update() {
        this.$router.push({ name: "FormUpdateUser" });
      },
      remove(item) {
        Request.delete("Users/DeleteUser/" + item.id)
          .then((response) => {
            if (response.data.status == 200){
              window.location.reload();
              this.getData();
            }
          })
          .catch(() => {})
          .finally(() => {});
      },
      importUsers() {
        this.loading = true;
        console.log("Importing users from Excel:", this.selectedFile);
        const formData = new FormData();
        formData.append("file", this.selectedFile);
        Request.post("ImportUser", formData)
          .then(() => {
            setTimeout(() => {
              this.$router.push({ name: "ListUser" });
              this.loading = false;
              window.location.reload();
            }, 1000);
          })
          .catch(() => {});
        },  
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
            Request.get("Users/ListUser")
            .then((response) => {
                this.data = response.data;
                console.log(response);
            })
            .catch(() => {})
            .finally(() => {});
        },
        handleUser(){
            this.$router.push({ name: "ListUser" });
        },
        handlePageUser(){
          this.$router.push({ name: "Home" });
        },
        handleAddNewExcel(){
          Request.post("login", this.params)
          .then((response) => {
            if (response.data.status == 201) {
              this.$router.push({ name: "ListUser" });
            } else {
              this.$router.push({ name: "Home" });
            }
          })
          .catch(() => {})
          .finally(() => {
          });
        },
        handleAddNew(){
          this.$router.push({ name: "UserForm" });
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
  