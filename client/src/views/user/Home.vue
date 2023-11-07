<template>
  <div>
    <v-text-field label="Tìm kiếm...." v-model="search"></v-text-field>
    <div style="width: 300px">
      <v-select
        dense
        outlined
        label="Loại search"
        :items="['name', 'author', 'category']"
        :rules="[(v) => !!v || 'Nhập loại search vào!']"
        v-model="typeSearch"
      ></v-select>

      <v-btn color="primary" @click="onSearch()"> Search </v-btn>
    </div>

    <v-row>
      <v-col v-for="(item, i) in data" :key="i">
        <!-- click vào vô details -->
        <v-card
          :loading="loading"
          class="mx-auto my-12"
          max-width="374"
          @click="detail(item)"
        >
          <template slot="progress">
            <v-progress-linear
              color="deep-purple"
              height="10"
              indeterminate
            ></v-progress-linear>
          </template>

          <v-img
            height="250"
            src="https://cdn.vuetifyjs.com/images/cards/cooking.png"
          ></v-img>

          <v-card-title>{{ item.NameBook }}</v-card-title>

          <v-card-text>
            <v-row align="center" class="mx-0">
              <v-rating
                :value="4.5"
                color="amber"
                dense
                half-increments
                readonly
                size="14"
              ></v-rating>

              <div class="grey--text ms-4">4.5 (413)</div>
            </v-row>

            <div class="my-4 text-subtitle-1">
              <span>Mã sách: {{ item.MaSach }}</span> | <span>{{ item.Author }}</span>
            </div>

            <div>
              {{ item.Content }}
            </div>
          </v-card-text>

          <v-divider class="mx-4"></v-divider>

          <v-card-title>Tonight's availability</v-card-title>

          <v-card-text>
            <v-chip-group active-class="deep-purple accent-4 white--text" column>
              <v-chip>5:30PM</v-chip>

              <v-chip>7:30PM</v-chip>

              <v-chip>8:00PM</v-chip>

              <v-chip>9:00PM</v-chip>
            </v-chip-group>
          </v-card-text>

          <v-card-actions>
            <v-btn color="deep-purple lighten-2" text> Reserve </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import Request from "@/plugins/request.js";
export default {
  data() {
    return {
      data: {},
      search: "",
      typeSearch: "",
    };
  },
  created() {
    this.getListBook();
  },
  methods: {
    getListBook() {
      this.loading = true;
      Request.get("Books/ListBook")
        .then((response) => {
          this.data = response.data.Books;
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

    detail(item) {
      console.log(item.id);
      return this.$router.push({ name: "bookDetails", params: { id: item.id } });
    },
  },
};
</script>

<style>
.inline {
  display: flex;
}
</style>
