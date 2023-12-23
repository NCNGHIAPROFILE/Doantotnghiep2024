<template>
    <div>
      <v-app-bar app color="error">
        <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
  
        <v-toolbar-title class="mr-6">Cập nhật người dùng</v-toolbar-title>
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
        </v-list-item-group>
      </v-navigation-drawer>
      <v-main>
        <v-form v-model="valid" @submit.prevent="submitForm">
          <v-container>
            <v-toolbar color="#82B1FF" class="form-toolbar">
              <v-toolbar-title class="text-center" style="justify-content: center; font-weight:bolder;">Cập nhật người dùng</v-toolbar-title>
            </v-toolbar>
            <v-row>
              <v-col cols="12" md="4">
                <v-text-field
                  prepend-icon="mdi mdi-rename-outline"
                  v-model="params.firstname"
                  :rules="nameRulesFisrt"
                  :counter="50"
                  label="Fisrt name"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  prepend-icon="mdi mdi-rename"
                  v-model="params.lastname"
                  :rules="nameRulesLast"
                  :counter="10"
                  label="Last name"
                  required
                ></v-text-field>
              </v-col>
            </v-row>

            <v-row>
              <v-col cols="12" md="4">
                <v-text-field
                  prepend-icon="mdi mdi-identifier"
                  v-model="params.mssv"
                  :rules="Rulesmssv"
                  :counter="10"
                  label="MSSV"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  prepend-icon="mdi mdi-google-classroom"
                  v-model="params.classuser"
                  :rules="Rulesclassuser"
                  :counter="5"
                  label="Class"
                  required
                ></v-text-field>
              </v-col>
            </v-row>

            <v-row>
              <v-col cols="12" md="4">
                <v-text-field
                  prepend-icon="mdi mdi-map-marker-outline"
                  v-model="params.address"
                  :rules="Rulesaddress"
                  :counter="255"
                  label="Address"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  prepend-icon="mdi mdi-phone-forward"
                  v-model="params.phone"
                  :rules="Rulesphone"
                  :counter="10"
                  label="Phone"
                  required
                ></v-text-field>
              </v-col>
            </v-row>

            <v-row>
              <!-- <v-col cols="12" md="4">
                  <v-text-field
                  prepend-icon="mdi mdi-email"
                  class="text-field-email"
                  placeholder="Email address"
                  type="email"
                  v-model="params.email"
                  :rules="emailRules"
                  required
                  height="30px"
                ></v-text-field>
              </v-col> -->
              <v-col cols="12" md="4">
                  <v-text-field
                  class="text-field-password"
                  placeholder="Password"
                  prepend-icon="mdi mdi-lock-off"
                  :append-icon="passwordShow ? 'mdi-eye ic-eye' : 'mdi-eye-off ic-eye'"
                  :type="passwordShow ? 'text' : 'password'"
                  dense
                  height="42px"
                  @click:append="passwordShow = !passwordShow"
                  v-model="params.password"
                  :rules="passwordRules"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                  <v-file-input
                      v-model="params.avatar"
                      label="Avatar"
                      show-size
                      required
                  ></v-file-input>
              </v-col>
            </v-row>
              <div class="text-center">
                  <v-btn
                      color="error"
                      Raised
                      width="300"
                      type="submit"
                      >Update
                  </v-btn>
              </div>
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
          firstname: "",
          lastname: "",
          mssv: "",
          address: "",
          classuser: "",
          phone: "",
          // email:"",
          password: "",
          avatar: "",
        },
        pleaseSignIn: "Cập nhật người dùng",
        nameRulesLast: [
            (v) => !!v || 'LastName is required',
            (v) => v.length <= 10 || 'LastName must be less than 10 characters',
        ],
        nameRulesFisrt: [
            (v) => !!v || 'FisrtName is required',
            (v) => v.length <= 50 || 'FisrtName must be less than 50 characters',
        ],
        Rulesmssv: [
            (v) => !!v || 'Mã số sinh viên is required',
            (v) => v.length == 10 || 'Mã số sinh viên must be 10 characters',
        ],
        Rulesclassuser: [
            (v) => !!v || 'Class is required',
            (v) => v.length <= 5 || 'FisrtName must be less than 5 characters',
        ],
        Rulesaddress: [
            (v) => v.length <= 255 || 'LastName must be less than 255 characters',
        ],
        Rulesphone: [
            (v) => v.length == 10 || 'Phone must be 10 characters',
        ],
        // emailRules: [
        //     (v) => (v.endsWith("@dau.edu.vn") || !v) || "Email must end with @dau.edu.vn",
        //     (v) => !!v || this.emailRequired,
        //     (v) => /.+@.+\..+/.test(v) || this.emailInValid,
        // ],
        passwordRules: [
            (v) => !!v || 'Password is required',
            (v) => v.length >= 8 && v.length <= 255 || 'Phone must be less than 8 characters',
        ],
      };
    },
    created() {
        this.getData();
    },
    methods: {
        submitForm() {
          const formData = new FormData();
          formData.append('MaSV', this.params.mssv);
          formData.append('FistNameUser', this.params.firstname);
          formData.append('LastNameUser', this.params.lastname);
          formData.append('Class', this.params.classuser);
          formData.append('AddressUser', this.params.address);
          formData.append('Phone', this.params.phone);
          formData.append('password', this.params.password);
          formData.append('ImageUser', this.params.avatar);
          Request.post(`Users/UpdateUser/${this.$route.params.idUser}`, formData)        
          .then(response => {
            console.log('Update successful:', response.data);
            this.$router.push({ name: "ListUser" });
          })
          .catch(error => {
              console.error('Update error:', error.response.data);
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
          console.log(this.$route.params.idUser);
            Request.get("Users/ShowUser/" + this.$route.params.idUser)
            .then((response) => {
              if (response.data.status === 200) {
                this.params = response.data.users;
                this.params.mssv = this.params.MaSV;
                this.params.firstname = this.params.FistNameUser;
                this.params.lastname = this.params.LastNameUser;
                this.params.classuser = this.params.Class;
                this.params.address = this.params.AddressUser;
                this.params.phone = this.params.Phone;
                this.params.avatar = this.params.ImageUser;
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
  