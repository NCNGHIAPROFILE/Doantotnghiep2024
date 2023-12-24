<template>
  <v-app>
    <v-container>
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
    </v-container>
  </v-app>
</template>

<script>
export default {
  data() {
    return {
      oldPassword: '',
      newPassword: '',
      confirmPassword: '',
    };
  },
  methods: {
    updatePassword() {
      // Thực hiện logic cập nhật mật khẩu ở đây
      console.log('Old Password:', this.oldPassword);
      console.log('New Password:', this.newPassword);
      console.log('Confirm Password:', this.confirmPassword);

      // Sau khi cập nhật thành công, có thể thực hiện chuyển hướng hoặc hiển thị thông báo
    },
  },
};
</script>

<style scoped>
/* Thêm các kiểu CSS tùy chọn tại đây */
</style>