<template>
  <v-app>
    <v-container fluid fill-height id="login-page">
      <v-layout align-center justify-center>
        <v-flex :style="{ 'max-width': '350px' }">
          <v-card>
            <v-card-text>
              <transition name="fade" mode="out-in">
                <v-form ref="form" @submit.prevent="submitHandler">
                  <div class="text-center mb-4" style="margin-top: -15px">
                    <img src="../../assets/images/logo.png" width="200" height="200" />
                  </div>
                  <div class="login-header">{{ pleaseSignIn }}</div>
                  <v-text-field
                    class="text-field-email"
                    placeholder="Email address"
                    prepend-icon="mdi mdi-account-check"
                    type="email"
                    v-model="params.email_work"
                    :rules="emailRules"
                    required
                    height="30px"
                    :error-messages="errorMessages.email"
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
                    required
                  ></v-text-field>
                  <div class="text-center">
                    <v-btn
                      :loading="loading"
                      color="blue-grey"
                      type="submit"
                      Raised
                      width="300"
                      @click="login"
                      >{{ signIn }}
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
        email_work: "",
        password: "",
      },
      pleaseSignIn: "Đăng nhập GaoRanger",
      signIn: "Login",
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
    login() {
      this.loading = true;
      // Test nếu mà xử lý login rồi thì xoá đi
      this.$router.push({ name: "Home" });

      Request.post("auth/login", this.params)
        .then((response) => {
          localStorage.setItem(response.user.id);
          if (this.user.company_role_id == 1) {
            this.$router.push({ name: "Dashboard" });
          } else {
            this.$router.push({ name: "Home" });
          }
        })
        .catch(() => {})
        .finally(() => {
          this.loading = false;
        });
    },
  },
};
</script>

<style src="./Login.scss" lang="scss" />
