<template>
  <div>
    <v-app-bar app color="error">
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title class="mr-6">Danh sách sách giấy</v-toolbar-title>

      <v-text-field
        v-model="search"
        label="Tìm kiếm..."
        hide-details
        append-icon="mdi-magnify"
        flat
        solo-inverted
        dense
        style="padding-left: 10px; width: 50px;"
      ></v-text-field>

      <v-select
        dense
        outlined
        label="Loại tìm kiếm"
        :items="['name', 'author', 'category']"
        v-model="typeSearch" 
        style="padding-left: 10px; width: 50px; padding-top: 25px;"
        :rules="[(v) => !!v || 'Nhập loại search vào!']"
      ></v-select>

      <v-btn class="ma-2" outlined color="#90CAF9" @click="onSearch()"> Search </v-btn>
      <v-spacer></v-spacer>

      <v-btn class="ma-2" outlined color="#90CAF9" @click="logout">
        <span class="mdi mdi-logout"></span>
        Logout</v-btn>
    </v-app-bar>
    
    <div style="display: block;">
      <v-row class="content-wrapper">
        <v-col v-for="(book, index) in displayedBooks" :key="book.id || index" cols="12" sm="4" md="4" lg="3" xl="3">
          <v-card style="padding-left: 10px; padding-right: 10px;" height="100%">
            <v-img :src="'http://127.0.0.1:8000/images/' + book.Picture" max-width="500" max-height="200"></v-img>
            <v-card-title >{{ book.NameBook }}</v-card-title>
            <v-card-text style="padding-top: 20px;">{{ `Author: ${book.Author}` }}</v-card-text>
            <v-card-text >{{ `Thể loại: ${book.Category}` }}</v-card-text>
            <v-card-text >{{ `Nhà xuất bản: ${book.MaProducer}`}}</v-card-text>
            <v-row>
              <v-col align="center" justify="center">
                <v-btn color="error" @click="viewDetails(book.id)">
                  <span class="mdi mdi-eye-arrow-left"></span>
                  View Details</v-btn>
              </v-col>
            </v-row>
          </v-card>
        </v-col>
      </v-row>
  
      <v-row style="padding-top: 20px;" class="content-wrapper">
        <v-col>
          <v-pagination v-model="currentPage" :length="totalPages" @input="changePage"></v-pagination>
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
    };
  },
  created() {
    this.getListBook();
  },
  methods: {
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
