<template>
    <div>
      <v-app-bar app color="error">
        <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
  
        <v-toolbar-title class="mr-6">Chi tiết sách giấy</v-toolbar-title>
        <v-spacer></v-spacer>
  
        <v-btn class="ma-2" outlined color="#90CAF9" @click="logout()">
          <span class="mdi mdi-logout"></span>
          Logout</v-btn>
      </v-app-bar>

      <v-main style="display: block;">
        <div class="d-flex justify-center" >
          <div>
            <v-img
              class="align-end text-white"
              height="500"
              width="500"
              :src="'http://127.0.0.1:8000/images/' + books.Picture"
              cover>
            </v-img>
          </div>

          <v-card style="width: 30%; height: 500px; margin-top: 0%;">
            <v-card-text>
              <h3 style="color: red;">THÔNG TIN SÁCH</h3>
              <v-row>
                <v-col>
                  <v-divider class="my-3"></v-divider>
                  <div class="headline">
                    <strong>Tên sách: </strong> {{ books.NameBook }}
                  </div>
                  <div class="subheading">
                    <strong>Tác giả: </strong> {{ books.Author }}
                  </div>
                  <div class="subheading">
                    <strong>Thể loại: </strong> {{ books.Category }}
                  </div>
                  <div class="subheading">
                    <strong>Nhà xuất bản: </strong> {{ books.MaProducer }}
                  </div>
                  <div class="subheading">
                    <strong>Xuất bản năm</strong> {{ books.YearPublish }}
                  </div>
                  <div class="subheading">
                    <strong>Mô tả: </strong> {{ books.Content }}
                  </div>
                </v-col>
              </v-row>
            </v-card-text>

            <v-card-actions>
              <v-btn color="error" @click="createticket()">Mượn sách</v-btn>
            </v-card-actions>
          </v-card>
        </div>

      </v-main>


      <v-navigation-drawer temporary v-model="drawer" app color="#90CAF9">
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
      };
    },
    created() {
      this.viewDetails();
    },
    methods: {
      createticket(){
        console.log(this.$route.params.idBook);
        Request.post("Tickets/AddTicket/" + this.$route.params.idBook)
          .then(response => {
            console.log('Create ticket successful:', response.data);
            this.$router.push({ name: "UserListTicketCreate" });
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
        Request.get("Books/SearchName?searchNameBook=" + this.search)
          .then((response) => {
            this.data = response.data.books;
            console.log(response);
          })
          .catch(() => {})
          .finally(() => {});
      },
      searchAuthor() {
        this.loading = true;
        Request.get("Books/SearchAuthor?searchAuthorBook=" + this.search)
          .then((response) => {
            this.data = response.data.books;
            console.log(response);
          })
          .catch(() => {})
          .finally(() => {});
      },
      searchCategory() {
        this.loading = true;
        Request.get("Books/SearchCategory?searchCategoryBook=" + this.search)
          .then((response) => {
            this.data = response.data.books;
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
      viewDetails() {
        console.log(this.$route.params.idBook);
        Request.get("Books/ShowBook/" + this.$route.params.idBook)
        .then((response) => {
          this.books = response.data.books;
          console.log(response);
        })
        .catch(() => {})
        .finally(() => {});
      },
  
      onFileChange(event) {
        this.selectedFile = event.target.files[0];
      }
    },
    computed: {
      totalPages() {
        return Math.ceil(this.books.length / this.itemsPerPage);
      },
      displayedBooks() {
        const start = (this.currentPage - 1) * this.itemsPerPage;
        const end = start + this.itemsPerPage;
        return this.books.slice(start, end);
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
  .headline {
    font-size: 20px;
    font-weight: bold;
    margin-top: 10px;
  }
  .subheading {
    font-size: 16px;
  }
  </style>
  