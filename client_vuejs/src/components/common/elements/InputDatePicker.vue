<template>
    <v-menu
      ref="menu"
      v-model="isShow"
      :close-on-content-click="false"
      transition="scroll-y-transition"
      offset-y
      min-width="auto"
      dense
    >
      <template v-slot:activator="{ on, attrs }">
        <v-row>
          <v-col lg="12" cols="12" sm="12" md="12">
            <ValidationProvider
              v-slot="{ errors }"
              :vid="id"
              :name="validation_label"
              :rules="validation_rules"
            >
              <v-text-field
                v-model="computedDateFormatted"
                readonly
                :disabled="!editable"
                v-bind="attrs"
                v-on="on"
                outlined
                :solo="solo"
                dense
                item-text="name"
                :error-messages="errors"
                :label="label"
                class="input_date"
              >
                <template slot="prepend">
                  <v-icon color="black lighten-1" dark right>
                    mdi-calendar-today-outline
                  </v-icon>
                </template>
              </v-text-field>
            </ValidationProvider>
          </v-col>
        </v-row>
      </template>
      <v-date-picker
        v-model="val"
        color="primary"
        :day-format="(val) => new Date(val).getDate()"
        :max="max"
        :min="min"
        no-title
        scrollable
        dense
        :disabled="disabledDate"
        @change="onInput(val)"
      >
        <v-spacer></v-spacer>
        <v-btn text color="black" @click="onReset()" :disabled="disabledDate">Close</v-btn>
      </v-date-picker>
    </v-menu>
  </template>
  <script>
  import { ValidationProvider } from "vee-validate";
  import { format, parseISO } from "date-fns";
  
  export default {
    data: () => {
      return {
        val: "",
        isShow: false,
      };
    },
    components: {
      ValidationProvider,
    },
    props: {
      editable: {
        type: Boolean,
        default: false,
      },
      values: {
        type: Object,
      },
      name: {
        type: String,
      },
      validation_rules: {
        type: String,
      },
      validation_label: {
        type: String,
      },
      id: {
        type: String,
      },
      label: {
        type: String,
      },
      max: null,
      min: null,
      flagNull: {
        type: Boolean,
        default: false,
      },
      disabledDate: {
        type: Boolean,
        default: false,
      },
      filled: {
        type: Boolean,
        default: true,
      },
      solo: {
        type: Boolean,
        default: false,
      },
      outlined: {
        type: Boolean,
        default: false,
      },
    },
    computed: {
      computedDateFormatted() {
        return this.val ? format(parseISO(this.val), "yyyy/MM/dd") : "";
      },
    },
    mounted() {
      this.$watch(
        () => [this.values, this.name],
        (newValue) => {
          const formValues = newValue[0];
          const name = newValue[1];
          if (formValues && name && formValues[name]) {
            const _date = new Date(formValues[name]);
            this.val = format(_date, "yyyy-MM-dd");
          } else {
            this.val = "";
          }
        },
        { immediate: true, deep: true }
      );
    },
    methods: {
      onInput(val) {
        this.$refs.menu.save(val);
        const _val = format(new Date(val), "yyyy/MM/dd");
        this.$emit("onInput", { name: this.name, value: _val });
        this.isShow = false;
      },
      onReset(){
        let val = this.flagNull ? null : new Date();
        this.$refs.menu.save(val);
        const _val = this.flagNull ? null : format(new Date(val), "yyyy/MM/dd");
        this.$emit("onInput", { name: this.name, value: _val });
        this.isShow = false;
      }
    },
  };
  </script>
  <style lang="scss" scoped>
  .check {
    min-width: 96px;
    flex-grow: 0;
  }
  </style>
  