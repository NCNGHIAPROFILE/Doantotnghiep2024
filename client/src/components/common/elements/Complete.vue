<template>
    <ValidationProvider
      v-slot="{ errors }"
      :vid="id"
      :name="validation_label"
      :rules="validation_rules"
    >
      <v-autocomplete
        v-model="val"
        dense
        :items="items"
        :item-text="item_text"
        :item-value="item_value"
        :disabled="!editable"
        outlined
        :clearable = "clear_able"
        :single-line ="single_line"
        :error-messages="errors"
        :label="label"
        :multiple="multiple"
        :chips="multiple"
        @input="$emit('onInput', { name, value: val })"
        :height="height"
        :menu-props="{ maxWidth: 800 }"
      >
        <template slot="prepend">
          <v-icon color="black lighten-1" dark right>
            {{ icon }}
          </v-icon>
        </template>
      </v-autocomplete>
    </ValidationProvider>
  </template>
  <script>
  import { ValidationProvider } from "vee-validate";
  export default {
    components: {
      ValidationProvider,
    },
    props: {
      editable: {
        type: Boolean,
        default: false,
      },
      name: {
        type: String,
      },
      values: {
        type: Object,
      },
      items: {
        type: Array,
      },
      label: {
         type: String,
      },
      validation_rules: {
        type: String,
        default: "",
      },
      validation_label: {
        type: String,
        default: "",
      },
      autofocus: {
        type: Boolean,
        default: false,
      },
      item_text: {
        type: String,
        default: "name",
      },
      item_value: {
        type: String,
        default: "id",
      },
      id: {
        type: String,
      },
      multiple: {
        type: Boolean,
        default: false,
      },
      single_line: {
        Boolean,
        default: true,
      },
      clear_able: {
        Boolean,
        default: true,
      },
      height: {
        type: String,
      },
      icon: {
        type: String,
      }
    },
    data: () => {
      return {
        val: "",
      };
    },
    mounted() {
      this.$watch(
        () => [this.values, this.name],
        (newValue) => {
          const formValues = newValue[0];
          const name = newValue[1];
          if (formValues && name) this.val = formValues[name];
        },
        { immediate: true, deep: true }
      );
    },
  };
  </script>
  <style lang="scss" scoped>
  ::v-deep .v-select.v-input--dense .v-select__selection--comma {
    position: absolute;
  }
  </style>