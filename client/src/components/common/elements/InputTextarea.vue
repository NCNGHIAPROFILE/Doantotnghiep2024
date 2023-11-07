<template>
    <ValidationProvider
      v-slot="{ errors }"
      :name="validation_label"
      :rules="validation_rules"
    >
      <v-textarea
        v-model="val"
        dense
        color="primary"
        :disabled="!editable"
        outlined
        :error-messages="errors"
        :placeholder="placeholder"
        :height="height"
        :auto-grow="flgCounter"
        no-resize
        @input="$emit('onInput', { name, value: val })"
        :label="label"
      >
        <template slot="prepend">
          <v-icon color="black lighten-1" dark right>
            {{ icon }}
          </v-icon>
        </template>
        <template v-slot:append v-if="flgCounter">
          <span class="counter">
            {{ counter }}
          </span>
        </template>
      </v-textarea>
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
      validation_rules: {
        type: String,
      },
      validation_label: {
        type: String,
      },
      placeholder: {
        type: String,
        default: "",
      },
      height: {
        type: String,
        default:""
      },
      flgCounter : {
        type : Boolean,
        default : false
      },
      counter : {
        type : String,
        default : null
      },
      label: {
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
  .counter {
    margin-top: 110px;
    color: #000000
  }
  </style>
  