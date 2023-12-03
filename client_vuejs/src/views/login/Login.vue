<template>
  <v-app>
    <v-container fluid fill-height id="login-page">
      <v-layout align-center justify-center>
        <v-flex :style="{ 'max-width': '350px' }">
          <v-card>
            <v-card-text>
              <transition name="fade" mode="out-in">
                <v-form ref="form" @submit.prevent="submitHandler">
                  <div class="text-center mb-4" style="margin-top: 15px">
                    <img src="../../assets/images/DAU.png" width="150" height="150" />
                  </div>
                  <div style="padding-top: 50px;" class="login-header">{{ pleaseSignIn }}</div>
                  <v-text-field
                    class="text-field-email"
                    placeholder="Email address"
                    prepend-icon="mdi mdi-card-account-mail"
                    type="email"
                    v-model="params.email"
                    :rules="emailRules"
                    required
                    height="30px"
                    :error-messages="errorMessages.email"
                    v-on:keyup.enter="onEnter"
                  ></v-text-field>
                  <v-text-field
                    class="text-field-password"
                    placeholder="Password"
                    prepend-icon="mdi-lock"
                    :append-icon="passwordShow ? 'mdi-eye ic-eye' : 'mdi-eye-off ic-eye'"
                    :type="passwordShow ? 'text' : 'password'"
                    dense
                    height="30px"
                    @click:append="passwordShow = !passwordShow"
                    v-model="params.password"
                    :rules="passwordRules"
                    v-on:keyup.enter="onEnter"
                    required
                  ></v-text-field>
                  <div class="text-center">
                    <v-btn
                      color="blue-grey"
                      Raised
                      width="300"
                      @click="login"
                      >Login
                    </v-btn>
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
      params: {
        email: "",
        password: "",
      },
      pleaseSignIn: "ARCHITECTURE UNIVERSITY LOGIN",
      emailInValid: "Email is not in the correct format",
      emailRequired: "Email is required item",
      passwordRequired: "Password is a required item",
      passwordMaxLength: "Password must be at least 8 characters",
      passwordShow: false,
      errorMessages: {},
      toasts: [],
      loading: false,
      message: "",
      emailRules: [
        (v) => (v.endsWith("@dau.edu.vn") || !v) || "Email must end with @dau.edu.vn",
        (v) => !!v || this.emailRequired,
        (v) => /.+@.+\..+/.test(v) || this.emailInValid,
      ],
      passwordRules: [
        (v) => !!v || this.passwordRequired,
        (v) => (v && v.length >= 8) || this.passwordMaxLength,
      ],
    };
  },
  methods: {
    onEnter() {
      this.login();
    },
    login() {
      Request.post("login", this.params)
        .then((response) => {
          localStorage.setItem("authenticated", response.data.Token);
          if (response.data.status == 200) {
            if (response.data.isAdmin) {
              this.$router.push({ name: "AdminListBook" });
            } else {
              this.$router.push({ name: "Home" });
            }
          }
        })
        .catch(() => {})
        .finally(() => {
        });
    },
  },
};
</script>

<style src="./Login.scss" lang="scss" />
