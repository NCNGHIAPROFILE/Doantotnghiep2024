<template>
    <v-container>
        <v-app-bar app color="error">
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
    
            <v-toolbar-title class="mr-6">Chi tiết sách</v-toolbar-title>
            <v-btn class="ma-2" color="#90CAF9" @click="handleAddNew">Thêm mới</v-btn>
            <v-spacer></v-spacer>
    
            <v-btn class="ma-2" outlined color="#90CAF9" @click="logout">Logout</v-btn>
        </v-app-bar>
    
        <v-navigation-drawer v-model="drawer" app color="#90CAF9">
            <v-list-item>
            <v-list-item-content class="pa-2">
                <v-list-item-title class="text-h2 font-weight-bold">{{ userName }}</v-list-item-title>
            </v-list-item-content>
            </v-list-item>
        
            <v-list-item-group>
            <v-list-item>
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
                <v-btn text @click="handleUser">Quản lý người dùng</v-btn>
            </v-list-item>
            <v-list-item>
                <v-btn text>Account</v-btn>
            </v-list-item>
            <v-list-item>
                <v-icon icon="mdi-information"></v-icon>
                <v-btn text>About</v-btn>
            </v-list-item>
            </v-list-item-group>
        </v-navigation-drawer>
      <v-row>
        <v-col cols="12" md="6" style="padding-top: 130px;">
          <v-img :src="product.image" alt="Product Image" width="100%" />
        </v-col>
        <v-col cols="12" md="6">
          <v-card>
            <v-card-title>{{ product.name }}</v-card-title>
            <v-card-subtitle>{{ product.category }}</v-card-subtitle>
            <v-card-text>{{ product.description }}</v-card-text>
            <v-card-actions>
              <v-btn color="primary" @click="addToCart">Thêm vào giỏ hàng</v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </template>
  
  <script>
  export default {
    data() {
      return {
        userName: "Hello Admin",
        drawer: true,
        product: {
          id: 1,
          name: 'Sản phẩm 1',
          category: 'Danh mục 1',
          description: 'Mô tả sản phẩm 1',
          image: 'https://placekitten.com/600/400', // Đường dẫn hình ảnh của sản phẩm
        },
      };
    },
    methods: {
      addToCart() {
        // Thêm logic thêm sản phẩm vào giỏ hàng nếu cần
        console.log('Sản phẩm đã được thêm vào giỏ hàng.');
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
  
  <style scoped>
    /* Các CSS tùy chỉnh nếu cần */
  </style>
  