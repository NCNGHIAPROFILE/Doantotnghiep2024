<template>
    <div class="labelWrapper" :style="style">
      <div
        class="label"
        :class="warning ? 'text__warning' : !editable ? 'text_disabled' : ''"
        :style="isDatepicker ? 'margin-left: 12px' : ''"
      >
        {{ label }}
        <div v-if="required && editable" :class="RerquiredStyle"> * </div>
        <div v-else class="none-required">*</div>
      </div>
      <div><slot /></div>
    </div>
  </template>
  <script>
  export default {
    props: {
      label: {
        type: String,
      },
      required: {
        type: Boolean,
        default: false,
      },
      editable: {
        type: Boolean,
        default: false,
      },
      width: {
        type: String,
        default: "auto",
      },
      warning: {
        type: Boolean,
        default: false,
      },
      isDatepicker: {
        type: Boolean,
        default: false,
      },
    },
    computed: {
      style() {
        return `width:${this.width}`;
      },
      RerquiredStyle() {
        return "required";
      },
    },
  };
  </script>
  <style lang="scss" scoped>
  .labelWrapper {
    padding: 0;
  }
  .label {
    font-size: 14px;
    padding: 4px;
    color: #274FC2;
    &.text__warning {
      color: #ff5252;
    }
    &.text_disabled {
      color: #545557;
    }

  }
  .required {
    font-size: 12px;
    font-weight: normal;
    color: #ff5252 !important;
    background-color: transparent;
    display: inline-block;
    padding: 4px;
    border-radius: 4px;
  }
  .none-required {
    opacity: 0;
    font-size: 12px;
    font-weight: normal;
    color: #274FC2 !important;
    background-color: none;
    display: inline-block;
    padding: 4px;
    border-radius: 4px;
  }
  </style>
  