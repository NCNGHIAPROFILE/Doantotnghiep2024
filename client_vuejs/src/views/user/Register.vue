<template>
    <v-app>
      <v-container fluid fill-height id="register-page">
        <v-layout align-center justify-center>
          <v-flex :style="{ 'max-width': '350px' }">
            <v-card>
              <v-card-text>
                <transition name="fade" mode="out-in">
                  <v-form ref="form" @submit.prevent="submitHandler">
                    <div class="text-center mb-4" style="margin-top: 15px">
                      <img src="../../assets/images/DAU.png" width="150" height="150" />
                    </div>
                    <div style="padding-top: 50px;" class="login-header">{{ pleaseRegister }}</div>
                    <div style="text-align: center; color: red; font-size: 32px; font-weight: bold;">REGISTER</div>
                    <v-text-field style="padding-top: 10px;"
                      class="text-field-name"
                      placeholder="MSSV"
                      prepend-icon="mdi mdi-identifier"
                      v-model="params.MSSV"
                      required
                      height="30px"
                      :error-messages="errorMessages.name"
                    ></v-text-field>
                    <v-text-field
                      class="text-field-name"
                      placeholder="First Name"
                      prepend-icon="mdi mdi-rename-outline"
                      v-model="params.firstName"
                      required
                      height="30px"
                      :error-messages="errorMessages.name"
                    ></v-text-field>
                    <v-text-field
                      class="text-field-name"
                      placeholder="Last Name"
                      prepend-icon="mdi mdi-rename"
                      v-model="params.lastName"
                      required
                      height="30px"
                      :error-messages="errorMessages.name"
                    ></v-text-field>
                    <v-text-field
                      class="text-field-name"
                      placeholder="Class"
                      prepend-icon="mdi mdi-google-classroom"
                      v-model="params.class"
                      required
                      height="30px"
                      :error-messages="errorMessages.name"
                    ></v-text-field>
                    <v-text-field
                      class="text-field-name"
                      placeholder="address"
                      prepend-icon="mdi mdi-map-marker-outline"
                      v-model="params.address"
                      required
                      height="30px"
                      :error-messages="errorMessages.name"
                    ></v-text-field>
                    <v-text-field
                      class="text-field-name"
                      placeholder="phone"
                      prepend-icon="mdi mdi-phone-forward"
                      v-model="params.phone"
                      required
                      height="30px"
                      :error-messages="errorMessages.name"
                    ></v-text-field>
                    <v-text-field
                      class="text-field-email"
                      placeholder="Email address"
                      prepend-icon="mdi mdi-email"
                      type="email"
                      :rules="emailRules"
                      v-model="params.email"
                      required
                      height="30px"
                      :error-messages="errorMessages.email"
                    ></v-text-field>
                    <v-text-field
                      class="text-field-password"
                      placeholder="Password"
                      prepend-icon="mdi mdi-lock-off"
                      :rules="passwordRules"
                      :append-icon="passwordShow ? 'mdi-eye ic-eye' : 'mdi-eye-off ic-eye'"
                      :type="passwordShow ? 'text' : 'password'"
                      dense
                      height="30px"
                      @click:append="passwordShow = !passwordShow"
                      v-model="params.password"
                      required
                    ></v-text-field>
                    <div class="text-center">
                      <v-btn color="error" Raised width="300" @click="register">Send OTP</v-btn>
                    </div>
                    <div class="text-center">
                      <v-btn color="blue-grey" Raised width="300" @click="back">Back</v-btn>
                    </div>
                    <div style="text-align: center; color: red; font-size: 12px; font-weight: inherit; padding-top: 20px;">{{ error }}</div>
                  </v-form>
                </transition>
              </v-card-text>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-app>
  </template>
  
  <script>
  import Request from "@/plugins/request.js";
  export default {
    data() {
      return {
        params: {
          MSSV: "",
          firstName: "",
          lastName: "",
          name: "",
          class: "",
          address: "",
          phone: "",
          email: "",
          password: "",
          confirmPassword: "",
        },
        pleaseRegister: "DANANG ARCHITECTURE UNIVERSITY",
        nameRequired: "Name is required item",
        emailInValid: "Email is not in the correct format",
        emailRequired: "Email is required item",
        passwordRequired: "Password is a required item",
        passwordMaxLength: "Password must be at least 8 characters",
        passwordShow: false,
        errorMessages: {},
        loading: false,
        message: "",
        error: "",
        nameRules: [(v) => !!v || this.nameRequired],
        emailRules: [
          (v) => (v.endsWith("@dau.edu.vn") || !v) || "Email must end with @dau.edu.vn",
          (v) => !!v || this.emailRequired,
          (v) => /.+@.+\..+/.test(v) || this.emailInValid,
        ],
        passwordRules: [
          (v) => !!v || this.passwordRequired,
          (v) => (v && v.length >= 8) || this.passwordMaxLength,
        ],
        confirmPasswordRules: [(v) => v === this.params.password || "Passwords do not match"],
      };
    },
    methods: {
      onEnter() {
        this.register();
      },
      toNonAccentVietnamese(str) {
        str = str.replace(/A|Á|À|Ã|Ạ|Â|Ấ|Ầ|Ẫ|Ậ|Ă|Ắ|Ằ|Ẵ|Ặ/g, "A");
        str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
        str = str.replace(/E|É|È|Ẽ|Ẹ|Ê|Ế|Ề|Ễ|Ệ/, "E");
        str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
        str = str.replace(/I|Í|Ì|Ĩ|Ị/g, "I");
        str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
        str = str.replace(/O|Ó|Ò|Õ|Ọ|Ô|Ố|Ồ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ỡ|Ợ/g, "O");
        str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
        str = str.replace(/U|Ú|Ù|Ũ|Ụ|Ư|Ứ|Ừ|Ữ|Ự/g, "U");
        str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
        str = str.replace(/Y|Ý|Ỳ|Ỹ|Ỵ/g, "Y");
        str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
        str = str.replace(/Đ/g, "D");
        str = str.replace(/đ/g, "d");
        // Some system encode vietnamese combining accent as individual utf-8 characters
        str = str.replace(/\u0300|\u0301|\u0303|\u0309|\u0323/g, ""); // Huyền sắc hỏi ngã nặng 
        str = str.replace(/\u02C6|\u0306|\u031B/g, ""); // Â, Ê, Ă, Ơ, Ư
      return str;
      },
      register() {
        let rg = this.toNonAccentVietnamese(this.params.lastName).toLowerCase() + "_" + this.params.MSSV + "@dau.edu.vn";
        if (rg == this.params.email) {
          Request.post("register", this.params)
          .then((response) => {
            if (response.data.status == 200) {
              console.log(response.data.status);
              this.$router.push({ name: "OTP" });
            } else {
              this.error = "";
              console.log(response.data.status);
            }
          })
          .catch(() => {})
          .finally(() => {
          });
        }
        else {
          this.error = "Lỗi email không trùng với MSSV";
        }
      },
      back(){
        this.$router.push({ name: "Login" });
      },
    },
  };
  </script>
  <style src="./template.scss" lang="scss" />

  