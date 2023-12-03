<template>
    <v-app>
      <v-container fluid fill-height id="register-page">
        <v-layout align-center justify-center>
          <v-flex :style="{ 'max-width': '350px' }">
            <v-card>
              <v-card-text>
                <transition name="fade" mode="out-in">
                  <v-form ref="form">
                    <div class="text-center mb-4" style="margin-top: 15px">
                      <img src="../../assets/images/DAU.png" width="150" height="150" />
                    </div>
                    <div style="padding-top: 50px;" class="login-header">{{ pleaseSignIn }}</div>
                    <div style="text-align: center; color: red; font-size: 32px; font-weight: bold;">OTP</div>
                    <v-sheet color="surface">
                      <v-otp-input style="padding-top: 20px;"
                        v-model="OTP"
                        type="number"
                        variant="solo"
                        required
                      ></v-otp-input>
                    </v-sheet>
                    <div class="text-center">
                      <v-btn color="blue-grey" Raised width="300" @click="register">Send OTP</v-btn>
                    </div>
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
        OTP: "",
        pleaseSignIn: "ARCHITECTURE UNIVERSITY LOGIN",
      };
    },
    methods: {
      onEnter() {
        this.register();
      },
      register() {
        Request.post("vertifymail", {OTP : this.OTP})
          .then((response) => {
            if (response.data.status === 200) {
              console.log("Registration successful");
              this.$router.push({ name: "Login" });
            } else {
              console.log("Registration failed");
            }
          })
          .catch(() => {})
          .finally(() => {
          });
      },
    },
  };
  </script>
  
  <style src="./template.scss" lang="scss" />

  