<template>
    <div>
      <v-app-bar app color="error">
        <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
  
        <v-toolbar-title class="mr-6">Cập nhật sách giấy</v-toolbar-title>
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
        </v-list-item-group>
      </v-navigation-drawer>
      <v-main>
        <v-form v-model="valid" @submit.prevent="submitForm">
          <v-container>
            <v-toolbar color="#82B1FF" class="form-toolbar">
              <v-toolbar-title class="text-center" style="justify-content: center; font-weight:bolder;">Cập nhật sách giấy</v-toolbar-title>
            </v-toolbar>
            <v-row>
              <v-col cols="12" md="4">
                <v-text-field
                  prepend-icon="mdi mdi mdi-book"
                  v-model="params.namebook"
                  :rules="nameRulesnamebook"
                  :counter="100"
                  label="Tên sách"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  prepend-icon="mdi mdi-account-box"
                  v-model="params.author"
                  :rules="nameRulesauthor"
                  :counter="50"
                  label="Tác giả"
                  required
                ></v-text-field>
              </v-col>
            </v-row>

            <v-row>
              <v-col cols="12" md="4">
                <v-text-field
                  prepend-icon="mdi mdi-identifier"
                  v-model="params.content"
                  :rules="Rulescontent"
                  :counter="255"
                  label="Mô tả"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  prepend-icon="mdi mdi-shape"
                  v-model="params.category"
                  :rules="Rulescategory"
                  :counter="20"
                  label="Thể loại"
                  required
                ></v-text-field>
              </v-col>
            </v-row>

            <v-row>
              <v-col cols="12" md="4">
                <v-text-field
                  prepend-icon="mdi mdi-publish"
                  v-model="params.producer"
                  :rules="Rulesproducer"
                  :counter="255"
                  label="Nhà xuất bản"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  prepend-icon="mdi mdi-sigma"
                  v-model="params.sum_quantity"
                  :rules="Rulessum_quantity"
                  label="Tổng số sách"
                  required
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" md="4">
                  <v-file-input
                      v-model="params.avatar"
                      label="Avatar"
                      show-size
                      required
                  ></v-file-input>
              </v-col>
              <v-col cols="12" md="4">
                <div class="text-center">
                  <v-btn
                      color="error"
                      Raised
                      width="300"
                      type="submit"
                      >Cập nhật
                  </v-btn>
                </div>
              </v-col>
            </v-row>
            </v-container>
          </v-form>
      </v-main>
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
        valid: false,
        passwordShow: false,
        params: {
          namebook: "",
          author: "",
          content: "",
          category: "",
          producer: "",
          sum_quantity: "",
          avatar: "",
        },
        pleaseSignIn: "Cập nhật sách giấy",
        nameRulesnamebook: [
            (v) => !!v || 'Name book is required',
            (v) => v.length <= 100 || 'Name book must be less than 100 characters',
        ],
        nameRulesauthor: [
            (v) => !!v || 'Author is required',
            (v) => v.length <= 50 || 'Author must be less than 50 characters',
        ],
        Rulescontent: [
            (v) => !!v || 'Content is required',
            (v) => v.length <= 255 || 'Content must be less than 255 characters',
        ],
        Rulescategory: [
            (v) => !!v || 'Category is required',
            (v) => v.length <= 20 || 'Category must be less than 20 characters',
        ],
        Rulesproducer: [
            (v) => !!v || 'Producer is required',
            (v) => v.length <= 255 || 'Producer must be less than 255 characters',
        ],
        Rulessum_quantity: [
            (v) => !!v || 'Quantity is required',
        ],
      };
    },
    created() {
      this.getData();
    },
    methods: {
        submitForm() {
        const formData = new FormData();
        formData.append('NameBook', this.params.namebook);
        formData.append('Author', this.params.author);
        formData.append('Content', this.params.content);
        formData.append('Category', this.params.category);
        formData.append('MaProducer', this.params.producer);
        formData.append('Sum_Quantity', this.params.sum_quantity);
        formData.append('Picture', this.params.avatar);
        Request.post(`Books/UpdateBook/${this.$route.params.idBook}`, formData)
            .then(response => {
              if (response.data.status == 200){
                this.$router.push({ name: "AdminListBook" });
              }
            })
            .catch(error => {
                console.error('Registration error:', error.response.data);
                this.$router.push({ name: "PageNotFound" });
            });
        },
        logout() {
            Request.post("logout")
            .then(response => {
                console.log(response.data);
                localStorage.clear();
                this.$router.push('/login');
            })
            .catch(error => {
                console.error('Logout error:', error);
            });
        },
        getData() {
          console.log(this.$route.params.idBook);
          Request.get("Books/ShowBook/" + this.$route.params.idBook)
            .then((response) => {
              if (response.data.status === 200) {
                this.params = response.data.books;
                this.params.namebook = this.params.NameBook;
                this.params.author = this.params.Author;
                this.params.content = this.params.Content;
                this.params.category = this.params.Category;
                this.params.producer = this.params.MaProducer;
                this.params.sum_quantity = this.params.Sum_Quantity;
                this.params.avatar = this.params.Picture;
                console.log(response);
              }
              else{
                console.error('Error fetching user data:', response.data.message);
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
  .form-toolbar{
    width: 67%;
    justify-content: center;
    display: flex;
    position: relative;
    z-index: 0;
    justify-content: center;
    align-items: center; 
  }
  </style>
  