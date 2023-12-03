<template>
  <v-pagination
    v-model="page"
    :length="total"
    :total-visible="getTotalVisible()"
    color="primary"
    circle
    @input="update"
    :disabled="total < 2"
  ></v-pagination>
</template>
<script>
export default {
  data: () => {
    return {
      page: 1,
    };
  },
  props: {
    current: {
      type: Number,
    },
    total: {
      type: Number,
    },
  },
  mounted() {
    this.$watch(
      () => this.current,
      (newValue) => {
        this.page = newValue;
      },
      {
        immediate: true,
      }
    );
  },
  methods: {
    update() {
      this.$emit("pageUpdate", this.page);
    },
    getTotalVisible() {
      let rs = this.total;
      rs = rs > 14 ? 7 : 14;
      return rs;
    },
  },
};
</script>
  <style lang="scss" scoped>
.tableFooter {
  nav {
    ::v-deep .v-pagination--disabled {
      opacity: 0 !important;
    }
  }
}
</style>
  