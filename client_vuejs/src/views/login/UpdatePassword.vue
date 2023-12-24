<template>
    <div>
      <v-app-bar app color="error">
        <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
  
        <v-toolbar-title class="mr-6">Cập Nhật Mật Khẩu</v-toolbar-title>
        <v-spacer></v-spacer>
  
        <v-btn class="ma-2" outlined color="#90CAF9" @click="logout">
          <span class="mdi mdi-logout"></span>
          Logout</v-btn>
      </v-app-bar>
      
      <div style="display: block;">
        <v-row justify="center">
            <v-col cols="12" sm="8" md="6">
              <v-card>
                <v-card-title class="headline">Cập Nhật Mật Khẩu</v-card-title>
                <v-card-text>
                  <v-form @submit.prevent="updatePassword">
                    <v-text-field
                      v-model="oldPassword"
                      label="Mật khẩu cũ"
                      type="password"
                      required
                    ></v-text-field>
                    <v-text-field
                      v-model="newPassword"
                      label="Mật khẩu mới"
                      type="password"
                      required
                    ></v-text-field>
                    <v-text-field
                      v-model="confirmPassword"
                      label="Xác nhận mật khẩu mới"
                      type="password"
                      required
                    ></v-text-field>
                    <v-btn type="submit" color="primary">Cập Nhật</v-btn>
                  </v-form>
                </v-card-text>
              </v-card>
            </v-col>
          </v-row>
      </div>
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
                  <v-btn text @click="handleUserItemClick()">Thay đổi password</v-btn>
                </v-list-item>
              </v-list>
            </v-menu>
          </v-list-item>
        </v-list-item-group>
      </v-navigation-drawer>
    </div>
  </template>
  
  <script>
  import Request from "@/plugins/request.js";
  export default {
    data() {
      return {
        userName: "Hello DAUer",
        drawer: false,
        books: [], 
        search: "",
        typeSearch: "",
        selectedFile: null,
        currentPage: 1,
        itemsPerPage: 50,
        oldPassword: '',
        newPassword: '',
        confirmPassword: '',
      };
    },
    created() {
      this.getListBook();
    },
    methods: {
        updatePassword() {
            console.log('Old Password:', this.oldPassword);
            console.log('New Password:', this.newPassword);
            console.log('Confirm Password:', this.confirmPassword);
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
      handleUserItemClick() {
        this.$router.push({ name: "UpdatePassword" });
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
      getListBook() {
        this.loading = true;
         
        Request.get("Books/ListBookBasic")
          .then((response) => {
            this.books = response.data.books;
            console.log(response);
          })
          .catch(() => {})
          .finally(() => {});
      },
      searchName() {
        this.loading = true;
        Request.get("Books/SearchNameBasic?searchNameBookBasic=" + this.search)
          .then((response) => {
            this.data = response.data.books;
            this.books = this.data;
            console.log(response);
          })
          .catch(() => {})
          .finally(() => {});
      },
      searchAuthor() {
        this.loading = true;
        Request.get("Books/SearchAuthorBasic?searchAuthorBookBasic=" + this.search)
          .then((response) => {
            this.data = response.data.books;
            this.books = this.data;
            console.log(response);
          })
          .catch(() => {})
          .finally(() => {});
      },
      searchCategory() {
        this.loading = true;
        Request.get("Books/SearchCategoryBasic?searchCategoryBookBasic=" + this.search)
          .then((response) => {
            this.data = response.data.books;
            this.books = this.data;
            console.log(response);
          })
          .catch(() => {})
          .finally(() => {});
      },
      onSearch() {
        switch (this.typeSearch) {
          case "name":
            this.searchName();
            break;
          case "author":
            this.searchAuthor();
            break;
          case "category":
            this.searchCategory();
            break;
        }
      },
      changePage(page) {
          this.currentPage = page;
      },
      viewDetails(idBook) {
        console.log(idBook);
        this.$router.push({ path: "/view-book-detail-basic/" + idBook });
      },
  
      onFileChange(event) {
        this.selectedFile = event.target.files[0];
      },
      handleUserHistoryClick(){
        this.$router.push({ name: "UserHistory" });
      }
    },
    computed: {
      totalPages() {
        return this.books?.length > 0 ? Math.ceil(this.books?.length / this.itemsPerPage) : 0;
      },
      displayedBooks() {
        const start = (this.currentPage - 1) * this.itemsPerPage;
        const end = start + this.itemsPerPage;
        return this.books?.slice(start, end);
      },
    },
  };
  </script>
  
  <style>
  .inline {
    display: flex;
  }
  .app-bar-row {
    padding: 10px;
  }
  
  .title {
    font-size: 1.5rem;
    font-weight: bold;
    color: white;
  }
  .search-field {
    max-width: 300px;
  }
  </style>
  